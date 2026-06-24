<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <title>SI TERNAK | <?php echo $title; ?></title> -->
<title>SI TERNAK<?php echo !empty($title) ? " | " . $title : ""; ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo base_url('assets/admin_template/adminlte/plugins/fontawesome-free/css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/admin_template/adminlte/dist/css/adminlte.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/admin_template/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>">
  
  <?php // Tambahkan CSS untuk plugin lain jika diperlukan, contoh: DataTables ?>
  <link rel="stylesheet" href="<?php echo base_url('assets/admin_template/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css'); ?>">

  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo base_url('assets/img/logo_sinjai.png'); ?>" alt="AdminLTELogo" height="60" width="60">
  </div>

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user-circle"></i>
          <span>Administrator</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">User Menu</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profil Saya
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?php echo site_url('auth/logout'); ?>" class="dropdown-item dropdown-footer bg-danger">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo site_url('dashboard'); ?>" class="brand-link">
      <img src="<?php echo base_url('assets/img/logo_sinjai.png'); ?>" alt="Logo Sinjai" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SI TERNAK</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url('assets/admin_template/adminlte/dist/img/avatar5.png'); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Administrator</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">MAIN NAVIGATION</li>
          <li class="nav-item">
            <a href="<?php echo site_url('dashboard'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item <?php echo $this->uri->segment(1) == 'perkembangan' ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo $this->uri->segment(1) == 'perkembangan' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Perkembangan Ternak
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('perkembangan/kelompok'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'kelompok' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kelompok Ternak</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('perkembangan/laporan'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'laporan' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Bulanan</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item <?php echo $this->uri->segment(1) == 'inseminasi' ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo $this->uri->segment(1) == 'inseminasi' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-venus-mars"></i>
              <p>
                Reproduksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                <a href="<?= site_url('inseminasi') ?>" class="nav-link <?= ($this->uri->segment(1) == 'inseminasi' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index')) ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Inseminasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('inseminasi/kelahiran') ?>" class="nav-link <?= $this->uri->segment(2) == 'kelahiran' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kelahiran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('inseminasi/pkb') ?>" class="nav-link <?= $this->uri->segment(2) == 'pkb' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemeriksaan Kebuntingan</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item <?php echo $this->uri->segment(1) == 'pakan' ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo $this->uri->segment(1) == 'pakan' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-seedling"></i>
              <p>
                Produksi Pakan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('pakan/laporan_produksi'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'laporan_produksi' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Input Laporan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('pakan/laporan_bulanan'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'laporan_bulanan' ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Bulanan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('pakan'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'pakan' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index')) ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Pakan</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item <?php echo $this->uri->segment(1) == 'vaksinasi' ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo $this->uri->segment(1) == 'vaksinasi' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-syringe"></i>
              <p>
                Vaksinasi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                <a href="<?= site_url('vaksinasi') ?>" class="nav-link <?= ($this->uri->segment(1) == 'vaksinasi' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index')) ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Upload Laporan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('vaksinasi/rekap') ?>" class="nav-link <?= $this->uri->segment(2) == 'rekap' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rekap per Bulan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('vaksinasi/rekap_petugas') ?>" class="nav-link <?= $this->uri->segment(2) == 'rekap_petugas' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rekap per Petugas</p>
                </a>
              </li>
            </ul>
          </li>
          
          
          <li class="nav-item">
            <a href="<?php echo site_url('laporan'); ?>" class="nav-link <?php echo $this->uri->segment(1) == 'laporan' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Generate Laporan</p>
            </a>
          </li>

          <li class="nav-header">MASTER DATA</li>
          <li class="nav-item">
             <a href="<?php echo site_url('master/petugas'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'master' && $this->uri->segment(2) == 'petugas') ? 'active' : ''; ?>">
              <i class="fas fa-id-card-alt nav-icon"></i>
              <p>Petugas Lapangan</p>
            </a>
          </li>
          <li class="nav-item">
             <a href="<?php echo site_url('master/peternak'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'master' && $this->uri->segment(2) == 'peternak') ? 'active' : ''; ?>">
              <i class="fas fa-users nav-icon"></i>
              <p>Data Peternak</p>
            </a>
          </li>
          <li class="nav-item">
             <a href="<?php echo site_url('master/hewan'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'master' && $this->uri->segment(2) == 'hewan') ? 'active' : ''; ?>">
              <i class="fas fa-paw nav-icon"></i>
              <p>Data Hewan</p>
            </a>
          </li>
           <li class="nav-item">
             <a href="<?php echo site_url('master/pakan'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'master' && $this->uri->segment(2) == 'pakan') ? 'active' : ''; ?>">
              <i class="fas fa-box nav-icon"></i>
              <p>Jenis Pakan</p>
            </a>
          </li>
          <li class="nav-item">
             <a href="<?php echo site_url('master/pengguna'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'master' && $this->uri->segment(2) == 'pengguna') ? 'active' : ''; ?>">
              <i class="fas fa-user-cog nav-icon"></i>
              <p>Manajemen Pengguna</p>
            </a>
          </li>
        </ul>
      </nav>
      </div>
    </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <title>SI TERNAK</title>
          </div><div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active"><?php echo !empty($title) ? $title : ""; ?></li>
            </ol>
          </div>
        </div>
        </div>
        </div>
    <section class="content">
      <div class="container-fluid">