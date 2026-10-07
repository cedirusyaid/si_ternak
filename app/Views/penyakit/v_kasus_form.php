<?php
  $isEdit = isset($kasus);
  $action = $isEdit ? base_url('penyakit/kasus_update/' . $kasus->id_kasus) : base_url('penyakit/kasus_store');
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark font-weight-bold">
          <i class="fa-solid <?= $isEdit ? 'fa-pen-to-square text-warning' : 'fa-circle-plus text-danger' ?> mr-2"></i><?= $title ?>
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('penyakit/kasus') ?>">Laporan Kasus</a></li>
          <li class="breadcrumb-item active"><?= $isEdit ? 'Edit' : 'Tambah' ?></li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-triangle-exclamation mr-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <div class="card card-primary card-outline shadow-sm">
      <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="card-body">
          <div class="row">
            
            <!-- KOLOM KIRI: LOKASI & PENYAKIT -->
            <div class="col-md-6 border-right">
              <h5 class="text-primary font-weight-bold mb-3 border-bottom pb-2">
                <i class="fa-solid fa-map-location-dot mr-1"></i> 1. Identifikasi Penyakit & Lokasi
              </h5>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">No. Laporan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="no_laporan" class="form-control" value="<?= $isEdit ? $kasus->no_laporan : $auto_no_laporan ?>" required <?= $isEdit ? 'readonly' : '' ?>>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Jenis Penyakit <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="id_penyakit" class="form-control" required>
                    <option value="">-- Pilih Penyakit PHMS --</option>
                    <?php foreach ($penyakit_list as $pen): ?>
                      <option value="<?= $pen->id_penyakit ?>" <?= ($isEdit && $kasus->id_penyakit == $pen->id_penyakit) ? 'selected' : '' ?>>
                        <?= $pen->kode_penyakit ?> - <?= $pen->nama_penyakit ?> (<?= $pen->kelompok_hewan ?>)
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Komoditas Ternak <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="komoditas" class="form-control" required>
                    <option value="">-- Pilih Komoditas --</option>
                    <?php foreach ($komoditas_list as $kom): ?>
                      <option value="<?= $kom ?>" <?= ($isEdit && $kasus->komoditas == $kom) ? 'selected' : '' ?>>
                        <?= $kom ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Kecamatan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="kecamatan_id" id="kecamatan_id" class="form-control" required>
                    <option value="">-- Pilih Kecamatan --</option>
                    <?php foreach ($kecamatan_list as $kec): ?>
                      <option value="<?= $kec->kecamatan_id ?>" <?= ($isEdit && $kasus->kecamatan_id == $kec->kecamatan_id) ? 'selected' : '' ?>>
                        <?= $kec->kecamatan_nama ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Desa / Kelurahan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="desa_id" id="desa_id" class="form-control" required>
                    <option value="">-- Pilih Kecamatan Dahulu --</option>
                    <?php if ($isEdit && !empty($desa_list)): ?>
                      <?php foreach ($desa_list as $desa): ?>
                        <option value="<?= $desa->desa_id ?>" <?= ($kasus->desa_id == $desa->desa_id) ? 'selected' : '' ?>>
                          <?= $desa->desa_nama ?>
                        </option>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Dusun / RW</label>
                <div class="col-sm-8">
                  <input type="text" name="dusun" class="form-control" placeholder="Contoh: Dusun Babakia" value="<?= $isEdit ? $kasus->dusun : '' ?>">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Nama Peternak</label>
                <div class="col-sm-8">
                  <input type="text" name="nama_peternak_manual" class="form-control" placeholder="Nama Pemilik Kandang" value="<?= $isEdit ? $kasus->nama_peternak_manual : '' ?>">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Koordinat GPS</label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" name="koordinat_gps" id="koordinat_gps" class="form-control" placeholder="Latitude, Longitude" value="<?= $isEdit ? $kasus->koordinat_gps : '' ?>">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-outline-secondary" onclick="getLocation()" title="Ambil Lokasi GPS Saat Ini">
                        <i class="fa-solid fa-crosshairs"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- KOLOM KANAN: STATISTIK KASUS & STATUS -->
            <div class="col-md-6">
              <h5 class="text-primary font-weight-bold mb-3 border-bottom pb-2">
                <i class="fa-solid fa-chart-line mr-1"></i> 2. Indikator Epidemiologi & Waktu
              </h5>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Tgl Kejadian Sakit <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="date" name="tanggal_kejadian" class="form-control" value="<?= $isEdit ? $kasus->tanggal_kejadian : date('Y-m-d') ?>" required>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tgl Kasus Selesai</label>
                <div class="col-sm-8">
                  <input type="date" name="tanggal_selesai" class="form-control" value="<?= $isEdit ? $kasus->tanggal_selesai : '' ?>">
                  <small class="form-text text-muted">Isi jika semua ternak di lokasi ini sudah sembuh/selesai ditangani.</small>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Populasi Rentan</label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="number" name="populasi_rentan" class="form-control" value="<?= $isEdit ? $kasus->populasi_rentan : '10' ?>" min="0">
                    <div class="input-group-append"><span class="input-group-text">Ekor</span></div>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold text-danger">Jumlah Sakit <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="number" name="jumlah_sakit" class="form-control font-weight-bold text-danger" value="<?= $isEdit ? $kasus->jumlah_sakit : '1' ?>" min="1" required>
                    <div class="input-group-append"><span class="input-group-text">Ekor</span></div>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold text-success">Jumlah Sembuh</label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="number" name="jumlah_sembuh" class="form-control text-success font-weight-bold" value="<?= $isEdit ? $kasus->jumlah_sembuh : '0' ?>" min="0">
                    <div class="input-group-append"><span class="input-group-text">Ekor</span></div>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold text-dark">Jumlah Kematian</label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="number" name="jumlah_mati" class="form-control text-dark font-weight-bold" value="<?= $isEdit ? $kasus->jumlah_mati : '0' ?>" min="0">
                    <div class="input-group-append"><span class="input-group-text">Ekor</span></div>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Status Kasus <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="status_kasus" class="form-control font-weight-bold" required>
                    <option value="Suspek" <?= ($isEdit && $kasus->status_kasus === 'Suspek') ? 'selected' : '' ?>>Suspek (Gejala Awal)</option>
                    <option value="Terkonfirmasi" <?= ($isEdit && $kasus->status_kasus === 'Terkonfirmasi') ? 'selected' : '' ?>>Terkonfirmasi Positif</option>
                    <option value="Terkendali" <?= ($isEdit && $kasus->status_kasus === 'Terkendali') ? 'selected' : '' ?>>Terkendali (Masa Karantina)</option>
                    <option value="Selesai" <?= ($isEdit && $kasus->status_kasus === 'Selesai') ? 'selected' : '' ?>>Selesai (Pulih / Kasus Ditutup)</option>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tindakan Medis</label>
                <div class="col-sm-8">
                  <textarea name="tindakan_penanganan" class="form-control" rows="2" placeholder="Contoh: Terapi antibiotik, desinfeksi kandang, isolasi"><?= $isEdit ? $kasus->tindakan_penanganan : '' ?></textarea>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Foto Gejala</label>
                <div class="col-sm-8">
                  <input type="file" name="foto_gejala" class="form-control-file" accept="image/*">
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="card-footer bg-light text-right">
          <a href="<?= base_url('penyakit/kasus') ?>" class="btn btn-secondary mr-2">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
          </a>
          <button type="submit" class="btn btn-primary font-weight-bold shadow-sm">
            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Laporan Kasus
          </button>
        </div>

      </form>
    </div>

  </div>
</section>

<script>
  // Dynamic AJAX Desa Dropdown
  document.getElementById('kecamatan_id').addEventListener('change', function () {
    const kecId = this.value;
    const desaSelect = document.getElementById('desa_id');
    desaSelect.innerHTML = '<option value="">-- Memuat Desa... --</option>';

    if (!kecId) {
      desaSelect.innerHTML = '<option value="">-- Pilih Kecamatan Dahulu --</option>';
      return;
    }

    fetch(`<?= base_url('penyakit/ajax_get_desa_by_kecamatan') ?>/${kecId}`)
      .then(res => res.json())
      .then(data => {
        desaSelect.innerHTML = '<option value="">-- Pilih Desa / Kelurahan --</option>';
        data.forEach(desa => {
          const opt = document.createElement('option');
          opt.value = desa.desa_id;
          opt.textContent = desa.desa_nama;
          desaSelect.appendChild(opt);
        });
      })
      .catch(err => {
        console.error(err);
        desaSelect.innerHTML = '<option value="">Gagal memuat desa</option>';
      });
  });

  // GPS Geolocation Auto-detect
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
        document.getElementById('koordinat_gps').value = position.coords.latitude + ", " + position.coords.longitude;
      }, function (error) {
        alert("Gagal mendeteksi lokasi GPS: " + error.message);
      });
    } else {
      alert("Perangkat Anda tidak mendukung fitur Geolocation.");
    }
  }
</script>
