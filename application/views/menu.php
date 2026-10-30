<?php
$thisPage = $this->uri->segment(1);
$thisPage1 = $this->uri->segment(2);
?>
<!-- sidebar -->
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <br>
        <div class="sidebar-brand">
            <a href="<?= base_url() ?>dashboard"><img src="<?= base_url() ?>assets/stisla/images/iaa.png" alt="logo" width="120">
                <h4></h4>
                <h6 style="color: #fff">INVESTMENT</h6>
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= base_url() ?>dashboard"><img src="<?= base_url() ?>assets/stisla/images/iaa.png" alt="logo" width="50">
            </a>
        </div>
        <br><br>
        <ul class="sidebar-menu">
            <li class="<?= ($thisPage == 'dashboard') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>dashboard"><i class="fas fa-home"></i><span>Dashboard</a></li>
            <li class="<?= ($thisPage == 'saldo') ? 'dropdown active' : 'dropdown'; ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-wallet"></i>
                    <span>Saldo</span></a>
                <ul class="dropdown-menu">
                    <li class="<?= ($thisPage1 == 'investasi') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>saldo/investasi">Investasi</a></li>
                    <li class="<?= ($thisPage1 == 'rata_harian') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>saldo/rata_harian">Rata-rata Harian</a></li>
                </ul>
            </li>
            <li class="<?= ($thisPage == 'distribusi_porsi') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>distribusi_porsi"><i class="fas fa-balance-scale"></i> <span>Distribusi dan Porsi SHU</span></a></li>
            <li class="<?= ($thisPage == 'dividen') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>dividen_persero"><i class="fas fa-balance-scale"></i> <span>Dividen Persero</span></a></li>
            <li class="<?= ($thisPage == 'surat_saham') ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url() ?>surat_saham"><i class="fas fa-file"></i> <span>Surat Saham</span></a></li>


            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                <a href="<?= site_url('auth/logout') ?>" class="btn btn-light btn-lg btn-block">
                    <i class="fas fa-sign-out-alt"></i> <b>Logout</b>
                </a>
            </div>
    </aside>
</div>
<!-- /sidebar -->