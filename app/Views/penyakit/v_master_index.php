<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark font-weight-bold">
          <i class="fa-solid fa-viruses text-primary mr-2"></i>Katalog Penyakit Hewan Menular Strategis (PHMS)
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('penyakit') ?>">Peta Surveilans</a></li>
          <li class="breadcrumb-item active">Master Penyakit</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <div class="card card-outline card-primary shadow-sm">
      <div class="card-header">
        <h3 class="card-title font-weight-bold">Daftar Penyakit Prioritas Nasional (Ternak & Unggas)</h3>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap mb-0" id="tableMasterPenyakit">
          <thead class="bg-light">
            <tr>
              <th style="width: 50px;">No</th>
              <th>Kode</th>
              <th>Nama Penyakit</th>
              <th>Kelompok Hewan</th>
              <th>Kategori Agen</th>
              <th class="text-center">Sifat Zoonosis</th>
              <th>Masa Inkubasi</th>
              <th>Gejala Klinis & Dampak</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($penyakit_list as $row): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><span class="badge badge-primary font-weight-bold"><?= $row->kode_penyakit ?></span></td>
                <td>
                  <span class="font-weight-bold text-dark"><?= $row->nama_penyakit ?></span>
                  <?php if (!empty($row->nama_ilmiah)): ?>
                    <br><small class="text-muted font-italic"><?= $row->nama_ilmiah ?></small>
                  <?php endif; ?>
                </td>
                <td><?= $row->kelompok_hewan ?></td>
                <td><span class="badge badge-secondary"><?= $row->kategori_agen ?></span></td>
                <td class="text-center">
                  <?php if ($row->sifat_zoonosis): ?>
                    <span class="badge badge-danger px-2 py-1"><i class="fa-solid fa-triangle-exclamation mr-1"></i>ZOONOSIS</span>
                  <?php else: ?>
                    <span class="badge badge-light text-muted">Non-Zoonosis</span>
                  <?php endif; ?>
                </td>
                <td><?= $row->masa_inkubasi_hari ?> Hari</td>
                <td style="max-width: 320px; white-space: normal;" class="small"><?= $row->deskripsi_gejala ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>
