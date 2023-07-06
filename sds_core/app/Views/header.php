<?php

use App\Models\sdsModel;

$sdsVt = new sdsModel();

$kullanici = $sdsVt->builder('kullanicilar')
    ->where('eposta', session()->get('kullanici_sds')['eposta'])
    ->get(2)->getResultArray()[0];


if ($kullanici['tema'] == 1) {
    $temaSec = 'dark';
    $link = base_url() . 'anasayfa?temaRengi=light';
} else {
    $temaSec = 'light';
    $link = base_url() . 'anasayfa?temaRengi=dark';
}

?>

<!doctype html>
<html lang="tr" data-bs-theme="<?= $temaSec ?>">

<head>

    <meta charset="utf-8"/>
    <title>SDS Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Öğrenciler ile Burs vermek isteyenler buluşuyor" name="description"/>
    <meta content="Aycha" name="author"/>

    <link rel="shortcut icon" href="<?= base_url() ?>kaynak/images/favicon.ico">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
          rel="stylesheet">
    <script src="<?= base_url() ?>kaynak/libs/jquery/jquery.min.js"></script>

    <link href="<?= base_url() ?>kaynak/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url() ?>kaynak/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url() ?>kaynak/css/app.min.css" id="app-style" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url() ?>kaynak/css/font.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url() ?>kaynak/css/font-1.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url() ?>kaynak/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
          type="text/css">
    <link href="<?= base_url() ?>kaynak/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
          type="text/css">
    <link href="<?= base_url() ?>kaynak/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
          rel="stylesheet" type="text/css">

</head>


<body data-sidebar="<?= $temaSec ?>" data-topbar="<?= $temaSec ?>" class="vertical-collpsed"
      style="font-family: 'Roboto'">

<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">

                <div class="navbar-brand-box">
                    <a href="<?= base_url() ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?= base_url() ?>kaynak/images/logo-sm.png" alt="" height="30">
                    </span>
                        <span class="logo-lg">
                        <img src="<?= base_url() ?>kaynak/images/logo-dark.png" alt="" height="45">
                    </span>
                    </a>

                    <a href="<?= base_url() ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?= base_url() ?>kaynak/images/logo-sm.png" alt="" height="30">
                    </span>
                        <span class="logo-lg">
                        <img src="<?= base_url() ?>kaynak/images/logo-light.png" alt="" height="45">
                    </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
                    <i class="mdi mdi-menu"></i>
                </button>

            </div>
            <form class="app-search w-100">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Ara...">
                    <span class="fa fa-search"></span>
                </div>
            </form>
            <div class="d-flex">

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user"
                             src="https://picsum.photos/100/100"
                             alt="Header Avatar">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end rounded-3">

                        <div class="dropdown-item text-center">
                            <h5>Merhaba <?= esc($kullanici['tipi']) ?></h5>
                            <div><?= esc($kullanici['eposta']) ?></div>
                        </div>

                        <a class="dropdown-item" href="<?= $link ?>">
                            <i class="mdi mdi-theme-light-dark font-size-17 text-muted align-middle me-1"></i>
                            Tema Değiştir
                        </a>

                        <a class="dropdown-item text-danger" href="<?= base_url() ?>anasayfa?cikis=cikisyapiliyor">
                            <i class="mdi mdi-power font-size-17 text-muted align-middle me-1 text-danger"></i>
                            Çıkış Yap
                        </a>


                    </div>
                </div>

            </div>
        </div>
    </header>

    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <div id="sidebar-menu">
                <?php if ($kullanici['tipi'] == 'Admin'): ?>
                    <ul class="metismenu list-unstyled" id="side-menu">

                        <li>
                            <a href="<?= base_url() ?>anasayfa" class=" waves-effect">
                                <i class="mdi mdi-home"></i>
                                <span>Anasayfa</span>
                            </a>
                        </li>

                        <li class="menu-title">Öğrenci</li>

                        <li>
                            <a href="<?= base_url() ?>ogrenci_listesi" class=" waves-effect">
                                <i class="mdi mdi-account-supervisor-circle"></i>
                                <span>Öğrenci Listesi</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= base_url() ?>ogrenci_istekleri" class=" waves-effect">
                                <i class="mdi mdi-briefcase-search-outline"></i>
                                <span>Öğrenci İstekleri</span>
                            </a>
                        </li>

                        <li class="menu-title">Bağışçı</li>

                        <li>
                            <a href="<?= base_url() ?>bagisci_listesi" class=" waves-effect">
                                <i class="mdi mdi-account-supervisor"></i>
                                <span>Bağışçı Listesi</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= base_url() ?>yapilan_bagislar" class=" waves-effect">
                                <i class="mdi mdi-cash-multiple"></i>
                                <span>Yapılan Bağışlar</span>
                            </a>
                        </li>

                        <li class="menu-title">Yönetim</li>

                        <li>
                            <a href="#" class=" waves-effect">
                                <i class="mdi mdi-message-alert"></i>
                                <span>İçerik Raporla</span>
                            </a>
                        </li>


                    </ul>
                <?php elseif ($kullanici['tipi'] == 'Bağışçı'): ?>
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li>
                            <a href="<?= base_url() ?>" class=" waves-effect">
                                <i class="mdi mdi-home"></i>
                                <span>Anasayfa</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>bagis/bagis_yap" class=" waves-effect">
                                <i class="mdi mdi-message-draw"></i>
                                <span>Bağış Yap</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>bagis/kayitlar" class=" waves-effect">
                                <i class="mdi mdi-message-draw"></i>
                                <span>Yaptığım Bağışlar</span>
                            </a>
                        </li>
                    </ul>
                <?php elseif ($kullanici['tipi'] == 'Öğrenci'): ?>
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li>
                            <a href="<?= base_url() ?>" class=" waves-effect">
                                <i class="mdi mdi-home"></i>
                                <span>Anasayfa</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>ogrenci/talep_olustur" class=" waves-effect">
                                <i class="mdi mdi-message-draw"></i>
                                <span>Taleplerim</span>
                            </a>
                        </li>
                    </ul>

                <?php else: ?>
                    <?php session()->destroy(); ?>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">