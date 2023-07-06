<?php

$sdsVt = new \App\Models\sdsModel();

$ogrenciGetir = $sdsVt->builder('kullanicilar')->where('eposta', session()->get('kullanici_sds')['eposta'])->get()
    ->getResultArray()[0];
$ogrenciSayisiToplam = $sdsVt->builder('kullanicilar')->where('tipi', 'Öğrenci')->countAllResults();
$bagisciSayisiToplam = $sdsVt->builder('kullanicilar')->where('tipi', 'Bağışçı')->countAllResults();
$onayliOgrenciSayisiToplam = $sdsVt->builder('kullanicilar')->where('tipi', 'Öğrenci')->where('onay', 'evet')->countAllResults();
$onaylanmamisOgrenciSayisiToplam = $sdsVt->builder('kullanicilar')->where('tipi', 'Öğrenci')->where('onay', 'hayir')->countAllResults();
$toplamSayisi = $sdsVt->builder('kullanicilar')->countAllResults();
$ogrenciTalepleriToplam = $sdsVt->builder('talepler')->countAllResults();
$yapilanBagislar = $sdsVt->builder('yapilan_bagislar')->countAllResults();

$sayacOgrenci = 0;
foreach ($sdsVt->builder('kullanicilar')->where('tipi', 'Öğrenci')->get()->getResultArray() as $ogrenci) {
    if (strtotime($ogrenci['kayit_tarihi']) > ((strtotime('now')) - (60 * 60 * 24))) {
        $sayacOgrenci++;
    }
}

$sayacBagisci = 0;
foreach ($sdsVt->builder('kullanicilar')->where('tipi', 'Bağışçı')->get()->getResultArray() as $bagisci) {
    if (strtotime($bagisci['kayit_tarihi']) > ((strtotime('now')) - (60 * 60 * 24))) {
        $sayacBagisci++;
    }
}

$sayacToplam = 0;
foreach ($sdsVt->builder('kullanicilar')->get()->getResultArray() as $toplam) {
    if (strtotime($toplam['kayit_tarihi']) > ((strtotime('now')) - (60 * 60 * 24))) {
        $sayacToplam++;
    }
}

$sayacTalepler = 0;
foreach ($sdsVt->builder('talepler')->get()->getResultArray() as $talep) {
    if (strtotime($talep['kayit_tarihi']) > ((strtotime('now')) - (60 * 60 * 24))) {
        $sayacTalepler++;
    }
}

$sayacYapilanBagislar = 0;
foreach ($sdsVt->builder('yapilan_bagislar')->get()->getResultArray() as $talep) {
    if (strtotime($talep['kayit_tarihi']) > ((strtotime('now')) - (60 * 60 * 24))) {
        $sayacYapilanBagislar++;
    }
}

$toplamBagisBugun = 0;
foreach ($sdsVt->builder('yapilan_bagislar')->get()->getResultArray() as $yapilanBagis) {
    if (strtotime($yapilanBagis['kayit_tarihi']) > ((strtotime('now')) - (60 * 60 * 24))) {
        $toplamBagisBugun = $toplamBagisBugun+$yapilanBagis['bagis_miktari'];
    }
}

$toplamBagisTumZamanlar = 0;
foreach ($sdsVt->builder('yapilan_bagislar')->get()->getResultArray() as $yapilanBagis) {
    $toplamBagisTumZamanlar = $toplamBagisTumZamanlar+$yapilanBagis['bagis_miktari'];
}

?>

<?php if (session()->get('kullanici_sds')['tipi'] == 'Admin'): ?>

    <style>

        .card:hover {
            transform: scale(1.05); /* Kartın boyutunu %5 oranında büyütür */
            transition: transform 0.3s ease; /* Geçiş süresi ve animasyon etkisi ayarlanır */
        }

    </style>

    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-school float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Kayıtlı Öğrenci</h6>
                        <h2 class="mb-4 text-white"><?= $ogrenciSayisiToplam ?></h2>
                        <span class="badge bg-dark fs-6"> <?= $sayacOgrenci ?> </span> <span class="ms-2">BUGÜN</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-file-check float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Onaylanmış Öğrenci
                            <i class="mdi mdi-check-circle text-success"></i></h6>
                        <h2 class="mb-4 text-white"><?= $onayliOgrenciSayisiToplam ?></h2>
                        <span class="badge bg-dark fs-6"> 0 </span> <span class="ms-2">BUGÜN</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-file-excel float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Onaylanmamış Öğrenci </h6>
                        <h2 class="mb-4 text-white"><?= $onaylanmamisOgrenciSayisiToplam ?></h2>
                        <span class="badge bg-dark fs-6"> 0 </span> <span class="ms-2">BUGÜN</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cash-refund float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Öğrenci Talepleri</h6>
                        <h2 class="mb-4 text-white"><?= $ogrenciTalepleriToplam ?></h2>
                        <span class="badge bg-dark fs-6"> <?= $sayacTalepler ?> </span> <span class="ms-2">BUGÜN</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cards-heart float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Kayıtlı Bağışçı</h6>
                        <h2 class="mb-4 text-white"><?= $bagisciSayisiToplam ?></h2>
                        <span class="badge bg-dark fs-6"> <?= $sayacBagisci ?> </span> <span class="ms-2">BUGÜN</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-bank-transfer-in float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Yapılan Bağışlar</h6>
                        <h2 class="mb-4 text-white"><?= $yapilanBagislar ?></h2>
                        <span class="badge bg-dark fs-6"> <?= $sayacYapilanBagislar ?> </span> <span class="ms-2">BUGÜN</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-checkbox-multiple-marked-circle float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Toplam Bağış</h6>
                        <h2 class="mb-4 text-white"><?= $toplamBagisTumZamanlar ?> ₺</h2>
                        <span class="badge bg-dark fs-6"> <?= $toplamBagisBugun ?> ₺</span> <span class="ms-2">BUGÜN</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-danger">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-account-supervisor-circle float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Toplam Kullanıcı</h6>
                        <h2 class="mb-4 text-white"><?= $toplamSayisi ?></h2>
                        <span class="badge bg-dark fs-6"> <?= $sayacToplam ?> </span> <span class="ms-2">BUGÜN</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php elseif (session()->get('kullanici_sds')['tipi'] == 'Bağışçı'): ?>
    <?php
    $bagislarim = $sdsVt->builder('yapilan_bagislar')->where('bagisci_eposta', session()->get('kullanici_sds')['eposta'])->countAllResults();
    $yapilanBagislar = $sdsVt->builder('yapilan_bagislar')->where('bagisci_eposta',  session()->get('kullanici_sds')['eposta'])->countAllResults();
    ?>

    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cash-refund float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Yaptığım Bağış</h6>
                        <h2 class="mb-4 text-white"><?= $bagislarim ?></h2>
                        <span>Yaptığınız tüm bağışları ifade eder.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-school float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Öğrenci Sayımız</h6>
                        <h2 class="mb-4 text-white"><?= $ogrenciSayisiToplam ?></h2>
                        <span class="badge bg-dark fs-6"> <?= $sayacOgrenci ?> </span> <span class="ms-2">BUGÜN</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cards-heart float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Bağışçı Sayımız</h6>
                        <h2 class="mb-4 text-white"><?= $bagisciSayisiToplam ?></h2>
                        <span class="badge bg-dark fs-6"> <?= $sayacBagisci ?> </span> <span
                                class="ms-2">BUGÜN</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card mini-stat bg-danger">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-wallet float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-capitalize mb-3 font-size-16 text-white">Bakiyem</h6>
                        <h2 class="mb-4 text-white"><?= ($ogrenciGetir['cuzdan'] == '') ? 0 : $ogrenciGetir['cuzdan'] ?> ₺</h2>
                        <span><i class="mdi mdi-clover"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php elseif (session()->get('kullanici_sds')['tipi'] == 'Öğrenci'): ?>
    <?php if ($ogrenciGetir['belge_adi'] == 'Yok'): ?>
        <div class="row align-items-center justify-content-center">
            <div class="col-12 text-center mt-2">
                <h2>
                    Belge Yüklemediniz.
                </h2>
                <p class="fs-5 text-muted" id="ikinci-baslik">
                    <?php if (empty(session()->getFlashdata('hata'))): ?>
                        Öğrenci olduğunuzu teyit eden bir belge yükleyiniz...
                    <?php else: ?>
                        <span class="text-danger">
                        <?= session()->getFlashdata('hata') ?>
                    </span>
                    <?php endif; ?>
                </p>
                <p style="font-size: 7rem">
                    <i class="mdi mdi-file-excel"></i>
                </p>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-8 col-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Belge Yükleyin
                        </h5>

                        <form id="belgeForm" action="<?= base_url() ?>ajax/kullanici?aksiyon=ogrenci_belge_yukle"
                              enctype="multipart/form-data" method="post">
                            <input class="form-control rounded-0 border-primary" type="file" id="belge" name="belge">
                            <button type="submit" id="belge-gonder-btn"
                                    class="btn btn-primary waves-effect rounded-0 w-100">Yükle
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    <?php elseif ($ogrenciGetir['onay'] != 'evet'): ?>
        <div class="row">
            <div class="col-12 text-center mt-5">
                <h2>
                    Yönetici tarafından onaylanmanız bekleniyor.
                </h2>
                <p class="fs-5 text-muted">
                    Belgeleriniz incelendikten sonra, hesabınız aktif edilecektir...
                </p>
                <p style="font-size: 10rem">
                    <i class="mdi mdi-feature-search"></i>
                </p>
            </div>
        </div>
    <?php else: ?>
        <?php
        $taleplerim = $sdsVt->builder('talepler')->where('eposta', session()->get('kullanici_sds')['eposta'])->countAllResults();
        $yapilanBagislar = $sdsVt->builder('yapilan_bagislar')->where('ogrenci_eposta',  session()->get('kullanici_sds')['eposta'])->countAllResults();
        ?>
        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cash-refund float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-capitalize mb-3 font-size-16 text-white">Taleplerim</h6>
                            <h2 class="mb-4 text-white"><?= $taleplerim ?></h2>
                            <span>Yaptığınız tüm talepleri ifade eder.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-school float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-capitalize mb-3 font-size-16 text-white">Öğrenci Sayımız</h6>
                            <h2 class="mb-4 text-white"><?= $ogrenciSayisiToplam ?></h2>
                            <span class="badge bg-dark fs-6"> <?= $sayacOgrenci ?> </span> <span class="ms-2">BUGÜN</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cards-heart float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-capitalize mb-3 font-size-16 text-white">Bağışçı Sayımız</h6>
                            <h2 class="mb-4 text-white"><?= $bagisciSayisiToplam ?></h2>
                            <span class="badge bg-dark fs-6"> <?= $sayacBagisci ?> </span> <span
                                    class="ms-2">BUGÜN</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card mini-stat bg-danger">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-wallet float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-capitalize mb-3 font-size-16 text-white">Bakiyem</h6>
                            <h2 class="mb-4 text-white"><?= ($ogrenciGetir['cuzdan'] == '') ? 0 : $ogrenciGetir['cuzdan'] ?> ₺</h2>
                            <span>Size yapılan toplam bağış sayısı &nbsp; <span class="badge bg-primary fs-5"><?= $yapilanBagislar ?></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php endif; ?>



