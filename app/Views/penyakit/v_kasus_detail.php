<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark font-weight-bold">
          <i class="fa-solid fa-circle-info text-info mr-2"></i>Rincian Laporan Kasus: <?= $kasus->no_laporan ?>
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('penyakit/kasus') ?>">Daftar Kasus</a></li>
          <li class="breadcrumb-item active">Detail</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-7">
        <div class="card card-primary card-outline shadow-sm">
          <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-file-medical mr-1"></i> Data Epidemiologi & Kejadian</h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-bordered mb-0">
              <tr>
                <th style="width: 35%;" class="bg-light">Nomor Laporan</th>
                <td><span class="font-weight-bold text-primary"><?= $kasus->no_laporan ?></span></td>
              </tr>
              <tr>
                <th class="bg-light">Jenis Penyakit</th>
                <td>
                  <span class="font-weight-bold"><?= $kasus->nama_penyakit ?></span>
                  <?php if (!empty($kasus->nama_ilmiah)): ?>
                    <br><small class="text-muted font-italic">(<?= $kasus->nama_ilmiah ?>)</small>
                  <?php endif; ?>
                  <?php if ($kasus->sifat_zoonosis): ?>
                    <span class="badge badge-danger ml-2">ZOONOSIS (Menular ke Manusia)</span>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th class="bg-light">Komoditas Hewan</th>
                <td><?= $kasus->komoditas ?></td>
              </tr>
              <tr>
                <th class="bg-light">Lokasi Administratif</th>
                <td><?= !empty($kasus->dusun) ? $kasus->dusun . ', ' : '' ?>Desa <b><?= $kasus->desa_nama ?></b>, Kec. <b><?= $kasus->kecamatan_nama ?></b></td>
              </tr>
              <tr>
                <th class="bg-light">Pemilik Ternak</th>
                <td><?= !empty($kasus->nama_peternak_db) ? $kasus->nama_peternak_db : ($kasus->nama_peternak_manual ?? '-') ?></td>
              </tr>
              <tr>
                <th class="bg-light">Tanggal Kejadian</th>
                <td><?= date('d F Y', strtotime($kasus->tanggal_kejadian)) ?> (Dilaporkan: <?= date('d/m/Y', strtotime($kasus->tanggal_lapor)) ?>)</td>
              </tr>
              <tr>
                <th class="bg-light">Tanggal Selesai</th>
                <td><?= !empty($kasus->tanggal_selesai) ? date('d F Y', strtotime($kasus->tanggal_selesai)) : '<span class="text-warning font-weight-bold">Kasus Masih Berjalan (Belum Selesai)</span>' ?></td>
              </tr>
              <tr>
                <th class="bg-light">Status Kasus</th>
                <td>
                  <?php if ($kasus->status_kasus === 'Selesai'): ?>
                    <span class="badge badge-success px-2 py-1">Selesai (Kasus Ditutup / Pulih)</span>
                  <?php elseif ($kasus->status_kasus === 'Terkendali'): ?>
                    <span class="badge badge-info px-2 py-1">Terkendali (Masa Karantina)</span>
                  <?php elseif ($kasus->status_kasus === 'Terkonfirmasi'): ?>
                    <span class="badge badge-danger px-2 py-1">Terkonfirmasi Positif</span>
                  <?php else: ?>
                    <span class="badge badge-warning px-2 py-1">Suspek (Gejala Awal)</span>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th class="bg-light">Tindakan Medis</th>
                <td><?= !empty($kasus->tindakan_penanganan) ? nl2br($kasus->tindakan_penanganan) : '-' ?></td>
              </tr>
              <tr>
                <th class="bg-light">SOP Darurat Penyakit</th>
                <td class="text-danger small"><?= !empty($kasus->prosedur_darurat) ? nl2br($kasus->prosedur_darurat) : '-' ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-5">
        <!-- STATISTIK KASUS KANDANG -->
        <div class="card card-outline card-info shadow-sm mb-3">
          <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-chart-pie mr-1"></i> Rincian Populasi & Hasil</h3>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-6 mb-3">
                <div class="border rounded p-2 bg-light">
                  <span class="text-muted small d-block">Populasi Rentan</span>
                  <h4 class="font-weight-bold text-primary mb-0"><?= $kasus->populasi_rentan ?> <small>Ekor</small></h4>
                </div>
              </div>
              <div class="col-6 mb-3">
                <div class="border rounded p-2 bg-light">
                  <span class="text-muted small d-block">Ternak Sakit</span>
                  <h4 class="font-weight-bold text-danger mb-0"><?= $kasus->jumlah_sakit ?> <small>Ekor</small></h4>
                </div>
              </div>
              <div class="col-6">
                <div class="border rounded p-2 bg-light">
                  <span class="text-muted small d-block">Ternak Sembuh</span>
                  <h4 class="font-weight-bold text-success mb-0"><?= $kasus->jumlah_sembuh ?> <small>Ekor</small></h4>
                </div>
              </div>
              <div class="col-6">
                <div class="border rounded p-2 bg-light">
                  <span class="text-muted small d-block">Kematian</span>
                  <h4 class="font-weight-bold text-dark mb-0"><?= $kasus->jumlah_mati ?> <small>Ekor</small></h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- FOTO DOKUMENTASI -->
        <?php if (!empty($kasus->foto_gejala)): ?>
          <div class="card card-outline card-secondary shadow-sm mb-3">
            <div class="card-header">
              <h3 class="card-title font-weight-bold"><i class="fa-solid fa-camera mr-1"></i> Dokumentasi Gejala Klinis</h3>
            </div>
            <div class="card-body text-center p-2">
              <img src="<?= base_url('uploads/penyakit/' . $kasus->foto_gejala) ?>" class="img-fluid rounded border shadow-sm" alt="Foto Gejala Klinis">
            </div>
          </div>
        <?php endif; ?>

        <!-- GPS KOORDINAT -->
        <?php if (!empty($kasus->koordinat_gps)): ?>
          <div class="card shadow-sm mb-3">
            <div class="card-body p-3">
              <span class="text-muted small d-block font-weight-bold"><i class="fa-solid fa-location-dot text-danger mr-1"></i> Titik Koordinat GPS:</span>
              <code><?= $kasus->koordinat_gps ?></code>
              <a href="https://maps.google.com/?q=<?= urlencode($kasus->koordinat_gps) ?>" target="_blank" class="btn btn-outline-primary btn-sm float-right">
                <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Buka Google Maps
              </a>
            </div>
          </div>
        <?php endif; ?>

        <div class="text-right">
          <a href="<?= base_url('penyakit/kasus_edit/' . $kasus->id_kasus) ?>" class="btn btn-warning mr-1">
            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Laporan
          </a>
          <a href="<?= base_url('penyakit/kasus') ?>" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar
          </a>
        </div>
      </div>
    </div>

  </div>
</section>
