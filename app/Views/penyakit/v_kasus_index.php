<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark font-weight-bold"><i class="fa-solid fa-notes-medical text-danger mr-2"></i>Laporan Kasus Penyakit Ternak & Unggas</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('penyakit') ?>">Peta Surveilans</a></li>
          <li class="breadcrumb-item active">Daftar Kasus</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check mr-2"></i><?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-triangle-exclamation mr-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <!-- FILTER & ACTION TOOLBAR -->
    <div class="card card-outline card-primary shadow-sm mb-3">
      <div class="card-body p-3">
        <form method="get" action="<?= base_url('penyakit/kasus') ?>" class="row align-items-end">
          <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
            <label class="small font-weight-bold text-muted mb-1">Penyakit PHMS:</label>
            <select name="id_penyakit" class="form-control form-control-sm" onchange="this.form.submit()">
              <option value="all">-- Semua Penyakit --</option>
              <?php foreach ($penyakit_list as $pen): ?>
                <option value="<?= $pen->id_penyakit ?>" <?= (isset($filters['id_penyakit']) && $filters['id_penyakit'] == $pen->id_penyakit) ? 'selected' : '' ?>>
                  <?= $pen->kode_penyakit ?> - <?= $pen->nama_penyakit ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
            <label class="small font-weight-bold text-muted mb-1">Komoditas:</label>
            <select name="komoditas" class="form-control form-control-sm" onchange="this.form.submit()">
              <option value="all">-- Semua Komoditas --</option>
              <?php foreach ($komoditas_list as $kom): ?>
                <option value="<?= $kom ?>" <?= (isset($filters['komoditas']) && $filters['komoditas'] == $kom) ? 'selected' : '' ?>>
                  <?= $kom ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
            <label class="small font-weight-bold text-muted mb-1">Kecamatan:</label>
            <select name="kecamatan_id" class="form-control form-control-sm" onchange="this.form.submit()">
              <option value="all">-- Semua Kecamatan --</option>
              <?php foreach ($kecamatan_list as $kec): ?>
                <option value="<?= $kec->kecamatan_id ?>" <?= (isset($filters['kecamatan_id']) && $filters['kecamatan_id'] == $kec->kecamatan_id) ? 'selected' : '' ?>>
                  <?= $kec->kecamatan_nama ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3 col-sm-6 text-md-right mt-2 mt-md-0">
            <a href="<?= base_url('penyakit/kasus_add') ?>" class="btn btn-danger btn-sm shadow-sm font-weight-bold">
              <i class="fa-solid fa-plus mr-1"></i> Tambah Laporan Kasus
            </a>
          </div>
        </form>
      </div>
    </div>

    <!-- DATA TABLE -->
    <div class="card shadow-sm border-0">
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap mb-0" id="tableKasus">
          <thead class="bg-light">
            <tr>
              <th style="width: 50px;">No</th>
              <th>No. Laporan</th>
              <th>Tgl Kejadian</th>
              <th>Penyakit PHMS</th>
              <th>Komoditas</th>
              <th>Lokasi (Desa/Kec)</th>
              <th class="text-center">Sakit</th>
              <th class="text-center">Sembuh</th>
              <th class="text-center">Mati</th>
              <th class="text-center">Status</th>
              <th class="text-center" style="width: 100px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($kasus_list)): ?>
              <?php $no = 1; foreach ($kasus_list as $row): ?>
                <?php 
                  $aktif = max(0, $row->jumlah_sakit - ($row->jumlah_sembuh + $row->jumlah_mati + $row->jumlah_potong_bersyarat));
                ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td>
                    <span class="font-weight-bold text-primary"><?= $row->no_laporan ?></span>
                    <?php if ($row->sifat_zoonosis): ?>
                      <span class="badge badge-danger ml-1" title="Penyakit Zoonosis (Menular ke Manusia)">Zoonosis</span>
                    <?php endif; ?>
                  </td>
                  <td><?= date('d/m/Y', strtotime($row->tanggal_kejadian)) ?></td>
                  <td>
                    <span class="font-weight-bold"><?= $row->nama_penyakit ?></span>
                  </td>
                  <td><?= $row->komoditas ?></td>
                  <td><?= $row->desa_nama ?> <small class="text-muted">(<?= $row->kecamatan_nama ?>)</small></td>
                  <td class="text-center font-weight-bold text-danger"><?= $row->jumlah_sakit ?></td>
                  <td class="text-center font-weight-bold text-success"><?= $row->jumlah_sembuh ?></td>
                  <td class="text-center font-weight-bold text-dark"><?= $row->jumlah_mati ?></td>
                  <td class="text-center">
                    <?php if ($row->status_kasus === 'Selesai'): ?>
                      <span class="badge badge-success">Selesai (Bebas)</span>
                    <?php elseif ($row->status_kasus === 'Terkendali'): ?>
                      <span class="badge badge-info">Terkendali</span>
                    <?php elseif ($row->status_kasus === 'Terkonfirmasi'): ?>
                      <span class="badge badge-danger">Terkonfirmasi Positif</span>
                    <?php else: ?>
                      <span class="badge badge-warning">Suspek</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center text-nowrap">
                    <div class="btn-group btn-group-sm text-nowrap" role="group">
                      <a href="<?= base_url('penyakit/kasus_detail/' . $row->id_kasus) ?>" class="btn btn-info" title="Lihat Detail Kasus">
                        <i class="fa-solid fa-circle-info"></i>
                      </a>
                      <a href="<?= base_url('penyakit/kasus_edit/' . $row->id_kasus) ?>" class="btn btn-warning" title="Edit Laporan Kasus">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <a href="<?= base_url('penyakit/kasus_delete/' . $row->id_kasus) ?>" class="btn btn-danger" title="Hapus Laporan Kasus" onclick="return confirm('Apakah Anda yakin ingin menghapus data kasus ini?');">
                        <i class="fa-solid fa-trash-can"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="11" class="text-center py-4 text-muted">
                  <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i> Belum ada data laporan kasus penyakit pada filter ini.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>
