<?php

namespace App\Controllers;

use App\Models\VaksinasiModel;
use DateTime;

class Vaksinasi extends BaseController
{
    public function index()
    {
        $data['title'] = 'Upload Laporan Vaksinasi';
        return view('template/header', $data)
             . view('vaksinasi/v_upload', $data)
             . view('template/footer');
    }

    public function rekap()
    {
        $vaksinasiModel = new VaksinasiModel();
        $data['title'] = 'Rekapitulasi Laporan Vaksinasi';
        $data['rekap'] = $vaksinasiModel->get_rekap_by_month();

        return view('template/header', $data)
             . view('vaksinasi/v_rekap', $data)
             . view('template/footer');
    }

    public function rekap_petugas()
    {
        $vaksinasiModel = new VaksinasiModel();
        $data['title'] = 'Rekapitulasi Vaksinasi per Petugas';

        $selected_period = $this->request->getGet('periode');
        $filters = [];
        if ($selected_period) {
            list($filters['bulan'], $filters['tahun']) = explode('-', $selected_period);
        }

        $data['rekap'] = $vaksinasiModel->get_rekap_by_petugas($filters);
        
        $periods = $vaksinasiModel->get_vaksinasi_distinct_periods();
        $grouped_periods = [];
        foreach ($periods as $p) {
            if (!isset($grouped_periods[$p->tahun])) {
                $grouped_periods[$p->tahun] = [];
            }
            $grouped_periods[$p->tahun][] = $p->bulan;
        }

        $data['grouped_periods'] = $grouped_periods;
        $data['selected_period'] = $selected_period;

        return view('template/header', $data)
             . view('vaksinasi/v_rekap_petugas', $data)
             . view('template/footer');
    }

    public function process_upload()
    {
        $validationRule = [
            'zip_file' => [
                'label' => 'ZIP File',
                'rules' => [
                    'uploaded[zip_file]',
                    'mime_in[zip_file,application/zip,application/x-zip-compressed,application/octet-stream]',
                    'ext_in[zip_file,zip]',
                ],
            ],
        ];

        if (!$this->validate($validationRule)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->to(base_url('vaksinasi'));
        }

        $file = $this->request->getFile('zip_file');

        if ($file->isValid() && !$file->hasMoved()) {
            $upload_path = WRITEPATH . 'uploads/vaksinasi/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $newName = $file->getRandomName();
            $file->move($upload_path, $newName);
            $zip_path = $upload_path . $newName;

            $zip = new \ZipArchive;
            if ($zip->open($zip_path) === true) {
                $extract_path = $upload_path . pathinfo($newName, PATHINFO_FILENAME);
                $zip->extractTo($extract_path);
                $zip->close();

                // Hapus file zip asli
                unlink($zip_path);

                // Cari file CSV di dalam folder yang diekstrak
                $csv_files = glob($extract_path . '/*.csv');
                if (empty($csv_files)) {
                    session()->setFlashdata('error', 'File CSV tidak ditemukan di dalam ZIP.');
                    $this->_delete_dir($extract_path); // Hapus folder ekstraksi
                    return redirect()->to(base_url('vaksinasi'));
                }

                $csv_file_path = $csv_files[0]; // Ambil file CSV pertama yang ditemukan

                $batch_data = [];
                $batch_size = 1000;
                $total_imported = 0;
                $skipped_count = 0;

                $vaksinasiModel = new VaksinasiModel();

                if (($handle = fopen($csv_file_path, "r")) !== false) {
                    $header = fgetcsv($handle, 0, ",");

                    while (($row = fgetcsv($handle, 0, ",")) !== false) {
                        if (count($header) != count($row)) continue; // Lewati baris yang korup
                        $data_row = array_combine($header, $row);

                        if (isset($data_row['kabupaten']) && strtolower(trim($data_row['kabupaten'])) == 'sinjai') {
                            $id_penyakit_raw = $data_row['id_penyakit'];
                            $id_penyakit_json = '[' . str_replace(['{', '}'], '', $id_penyakit_raw) . ']';

                            $date_str = $data_row['tanggal_vaksinasi'];
                            $tanggal_vaksinasi = $this->_parse_date($date_str);

                            $batch_data[] = [
                                'id' => $data_row['id'],
                                'id_program' => $data_row['id_program'],
                                'program_vaksinasi' => $data_row['program_vaksinasi'],
                                'id_penyakit' => $id_penyakit_json,
                                'penyakit' => $data_row['penyakit'],
                                'kecamatan' => $data_row['kecamatan'],
                                'desa' => $data_row['desa'],
                                'tanggal_vaksinasi' => $tanggal_vaksinasi,
                                'urutan_vaksinasi' => $data_row['urutan_vaksinasi'],
                                'namapetugas' => $data_row['namapetugas'],
                                'nomorpetugas' => $data_row['nomorpetugas'],
                                'identifikasihewan' => $data_row['identifikasihewan'],
                                'eartag' => $data_row['eartag'],
                                'rumpun' => $data_row['rumpun'],
                                'hewan' => $data_row['hewan'],
                                'jenis_kelamin' => $data_row['jenis_kelamin'],
                                'umur' => $data_row['umur'],
                                'namapemilik' => $data_row['namapemilik'],
                                'telppemilik' => $data_row['telppemilik'],
                                'nikpemilik' => $data_row['nikpemilik'],
                            ];

                            if (count($batch_data) >= $batch_size) {
                                $vaksinasiModel->insert_batch($batch_data);
                                $total_imported += count($batch_data);
                                $batch_data = []; // Reset batch
                            }
                        } else {
                            $skipped_count++;
                        }
                    }
                    fclose($handle);

                    // Insert sisa data yang belum mencapai ukuran batch
                    if (!empty($batch_data)) {
                        $vaksinasiModel->insert_batch($batch_data);
                        $total_imported += count($batch_data);
                    }
                }

                if ($total_imported > 0) {
                    $success_msg = 'Berhasil mengimpor ' . $total_imported . ' data. ';
                    if ($skipped_count > 0) {
                        $success_msg .= $skipped_count . ' data diabaikan (bukan Kab. Sinjai).';
                    }
                    session()->setFlashdata('success', $success_msg);
                } else {
                    session()->setFlashdata('error', 'Tidak ada data untuk Kabupaten Sinjai yang ditemukan dalam file.');
                }

                // Hapus folder ekstraksi dan isinya
                $this->_delete_dir($extract_path);
                return redirect()->to(base_url('vaksinasi'));
            } else {
                session()->setFlashdata('error', 'Gagal membuka file ZIP.');
                unlink($zip_path); // Hapus file zip jika gagal dibuka
                return redirect()->to(base_url('vaksinasi'));
            }
        } else {
            session()->setFlashdata('error', 'Terjadi kesalahan saat upload berkas.');
            return redirect()->to(base_url('vaksinasi'));
        }
    }

    private function _parse_date($date_str)
    {
        $date_formats = ['d-m-Y', 'd/m/Y', 'Y-m-d', 'm/d/Y', 'd-m-y', 'd/m/y', 'm/d/y', 'Y-m-d H:i:s'];
        $tanggal_vaksinasi = null;

        foreach ($date_formats as $format) {
            $date = DateTime::createFromFormat($format, $date_str);
            if ($date !== false) {
                $year = (int)$date->format('Y');
                if ($year > (int)date('Y') + 1) { // Check if year is in the distant future
                    // It might be a d-m-y vs m-d-y issue, try swapping day and month
                    $parts = preg_split('/[-\/]/', $date_str);
                    if (count($parts) === 3) {
                        $new_date_str = $parts[1] . '-' . $parts[0] . '-' . $parts[2];
                        $new_date = DateTime::createFromFormat($format, $new_date_str);
                        if ($new_date !== false) {
                            $new_year = (int)$new_date->format('Y');
                            if ($new_year <= (int)date('Y') + 1) {
                                $date = $new_date;
                            }
                        }
                    }
                }
                $tanggal_vaksinasi = $date->format('Y-m-d H:i:s');
                break;
            }
        }
        return $tanggal_vaksinasi;
    }

    // Fungsi helper untuk menghapus direktori secara rekursif
    private function _delete_dir($dir)
    {
        if (!is_dir($dir)) return;
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->_delete_dir("$dir/$file") : unlink("$dir/$file");
        }
        rmdir($dir);
    }
}
