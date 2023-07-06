<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


$routes->group('', ["filter" => "panelfiltre"], function ($routes){
    $routes->get('/', 'Sayfalar::giris');
    $routes->get('uyeol', 'Sayfalar::uyeol');
    $routes->match(['get', 'post'],'/kontrolgiris', 'Sayfalar::kontrolGiris');
    $routes->match(['get', 'post'],'/kontroluye', 'Sayfalar::kontrolUye');
});

$routes->group('', ["filter" => "girisfiltre"], function ($routes){

    $routes->get('anasayfa', 'Sayfalar::anasayfa');

    if (!empty(session()->get('kullanici_sds')['tipi'])){
        if (session()->get('kullanici_sds')['tipi'] == 'Admin'){
            $routes->get('ogrenci_listesi', 'Sayfalar::ogrenci_listesi');
            $routes->get('ogrenci_istekleri', 'Sayfalar::ogrenci_istekleri');
            $routes->get('bagisci_listesi', 'Sayfalar::bagisci_listesi');
            $routes->get('yapilan_bagislar', 'Sayfalar::yapilan_bagislar');
            $routes->match(['get', 'post'],'ajax/admin', 'Ajax::admin');
        }elseif(session()->get('kullanici_sds')['tipi'] == 'Öğrenci'){
            $routes->get('ogrenci/talep_olustur', 'Sayfalar::talepOlustur');
        }elseif (session()->get('kullanici_sds')['tipi'] == 'Bağışçı'){
            $routes->get('bagis/bagis_yap', 'Sayfalar::bagisYap');
            $routes->get('bagis/kayitlar', 'Sayfalar::bagisKayitlari');
        }else{
            session()->destroy();
            return redirect()->back()->with('hata', 'Hande Yener');
        }
    }



    $routes->match(['get', 'post'],'ajax/kullanici', 'Ajax::kullanici');

});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
