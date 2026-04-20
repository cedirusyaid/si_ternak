<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vaksinasi extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_vaksinasi');
        $this->load->library('upload');
    }

    public function index()
    {
        $data['title'] = 'Upload Laporan Vaksinasi';
        $this->load->view('template/header', $data);
        $this->load->view('vaksinasi/v_upload', $data);
        $this->load->view('template/footer');
    }

    public function rekap()
    {
        $data['title'] = 'Rekapitulasi Laporan Vaksinasi';
        $data['rekap'] = $this->M_vaksinasi->get_rekap_by_month();
        $this->load->view('template/header', $data);
        $this->load->view('vaksinasi/v_rekap', $data);
        $this->load->view('template/footer');
    }

    public function rekap_petugas()
    {
        $data['title'] = 'Rekapitulasi Vaksinasi per Petugas';

        $selected_period = $this->input->get('periode');
        $filters = [];
        if ($selected_period) {
            list($filters['bulan'], $filters['tahun']) = explode('-', $selected_period);
        }

        $data['rekap'] = $this->M_vaksinasi->get_rekap_by_petugas($filters);
        
        $periods = $this->M_vaksinasi->get_vaksinasi_distinct_periods();
        $grouped_periods = [];
        foreach ($periods as $p) {
            if (!isset($grouped_periods[$p->tahun])) {
                $grouped_periods[$p->tahun] = [];
            }
            $grouped_periods[$p->tahun][] = $p->bulan;
        }

        $data['grouped_periods'] = $grouped_periods;
        $data['selected_period'] = $selected_period;

        $this->load->view('template/header', $data);
        $this->load->view('vaksinasi/v_rekap_petugas', $data);
        $this->load->view('template/footer');
    }

    public function process_upload()
    {
        $upload_path = './uploads/vaksinasi/';
        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'zip';
        $config['max_size']      = '0'; // Tidak ada batasan

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('zip_file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('vaksinasi');
        }

        $file_data = $this->upload->data();
        $zip_path = $file_data['full_path'];

        $zip = new ZipArchive;
        if ($zip->open($zip_path) === TRUE) {
            $extract_path = $upload_path . pathinfo($file_data['file_name'], PATHINFO_FILENAME);
            $zip->extractTo($extract_path);
            $zip->close();

            // Hapus file zip asli
            unlink($zip_path);

            // Cari file CSV di dalam folder yang diekstrak
            $csv_files = glob($extract_path . '/*.csv');
            if (empty($csv_files)) {
                $this->session->set_flashdata('error', 'File CSV tidak ditemukan di dalam ZIP.');
                $this->_delete_dir($extract_path); // Hapus folder ekstraksi
                redirect('vaksinasi');
            }

            $csv_file_path = $csv_files[0]; // Ambil file CSV pertama yang ditemukan

            $batch_data = [];
            $batch_size = 1000;
            $total_imported = 0;
            $skipped_count = 0;

            if (($handle = fopen($csv_file_path, "r")) !== FALSE) {
                $header = fgetcsv($handle, 0, ",");

                while (($row = fgetcsv($handle, 0, ",")) !== FALSE) {
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
                            $this->M_vaksinasi->insert_batch($batch_data);
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
                    $this->M_vaksinasi->insert_batch($batch_data);
                    $total_imported += count($batch_data);
                }
            }

            if ($total_imported > 0) {
                $success_msg = 'Berhasil mengimpor ' . $total_imported . ' data. ';
                if ($skipped_count > 0) {
                    $success_msg .= $skipped_count . ' data diabaikan (bukan Kab. Sinjai).';
                }
                $this->session->set_flashdata('success', $success_msg);
            } else {
                $this->session->set_flashdata('error', 'Tidak ada data untuk Kabupaten Sinjai yang ditemukan dalam file.');
            }

            // Hapus folder ekstraksi dan isinya
            $this->_delete_dir($extract_path);

            redirect('vaksinasi');

        } else {
            $this->session->set_flashdata('error', 'Gagal membuka file ZIP.');
            unlink($zip_path); // Hapus file zip jika gagal dibuka
            redirect('vaksinasi');
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
