<?php

namespace App\Controllers;

use App\Models\sdsModel;
use CodeIgniter\HTTP\CURLRequest;


class Sayfalar extends BaseController
{
    //Ortak Alanlar

    public function giris()
    {
        echo view('giris');
    }

    public function uyeol(){
        echo view('uyeol');
    }

    public function kontrolGiris(){

        helper(['form, url']);
        $sdsVt = new sdsModel();

        $eposta = $this->request->getPost('eposta');
        $sifre = $this->request->getPost('sifre');

        $kullanici = $sdsVt->builder('kullanicilar')
            ->where('eposta', $eposta)->where('sifre', $sifre)
            ->get()->getResultArray();

        if (empty($kullanici)){
            return redirect()->back()->with('hata', 'Kullanıcı adı veya şifre hatalı.');
        }else{
            session()->start();
            session()->set('kullanici_sds', ['eposta' => $kullanici[0]['eposta'], 'tipi' => $kullanici[0]['tipi']]);

            return redirect()->to(base_url().'anasayfa');
        }
    }

    public function kontrolUye(){
        helper(['form, url']);
        $sdsVt = new sdsModel();

        $eposta = $this->request->getPost('eposta');
        $sifre = $this->request->getPost('sifre');
        $tipi = $this->request->getPost('tipi');
        $belge = $this->request->getFile('belge');

        $kullanici = $sdsVt->builder('kullanicilar')->where('eposta', $eposta)->get(1)->getResultArray();

        if (empty($eposta) or  empty($sifre) or empty($tipi) or !strpos($eposta, '@')){
            return redirect()->back()->with('hata', 'Eposta, Şifre ve Tür boş bırakalamaz');
        }else{
            if (strlen($sifre) >= 8){
                if (empty($kullanici)){

                    if ($tipi != 'Öğrenci' && filesize($belge) > 256){
                        return redirect()->back()->with('hata', 'Anladım teşekkürler...');
                    }


                    if (isset($belge)){
                        $belgeAdi = 'Yok';
                    }else{
                        $belgeAdi = $this->resimYukle($belge, $eposta);

                        if ($belgeAdi == "hata boyut"){
                            return redirect()->back()->with('hata', 'Dosya boyutu 2MB\' yi geçmemeli.');
                        }elseif ($belgeAdi == "hata geçersiz"){
                            return redirect()->back()->with('hata', 'Desteklenen dosya biçimleri: jpg, jpeg, png ve pdf');
                        }
                    }

                    $uyelikBilgileri = [
                        'eposta' => $eposta,
                        'sifre' => $sifre,
                        'tipi' => $tipi,
                        'belge_adi' => $belgeAdi,
                    ];

                    $sdsVt->builder('kullanicilar')->insert($uyelikBilgileri);

                    session()->set('kullanici_sds', ['eposta' => $eposta, 'tipi' => $tipi]);

                    return redirect()->to('/');
                }else{
                    return redirect()->back()->with('hata', 'Bu eposta sisteme zaten kayıtlı..');
                }
            }else{
                return redirect()->back()->with('hata', 'Şifre en az 8 haneli olmalı');
            }

        }

    }

    public function anasayfa()
    {
        $temaRengi = $this->request->getVar('temaRengi');
        $cikisYap = $this->request->getVar('cikis');

        if ($cikisYap === 'cikisyapiliyor'){
            session()->destroy();
            return redirect()->to(base_url());
        }

        if (!empty($temaRengi)){

            $sdsVt = new sdsModel();

            if ($temaRengi == "light"){
                $sdsVt->builder('kullanicilar')
                    ->where('eposta', session()->get('kullanici_sds')['eposta'])->set(['tema' => 0])->update();
            }else{
                $sdsVt->builder('kullanicilar')
                    ->where('eposta', session()->get('kullanici_sds')['eposta'])->set(['tema' => 1])->update();
            }

        }

        echo view('header');
        echo view('anasayfa');
        echo view('footer');
    }

    //Admin Bölümü

    public function ogrenci_listesi(){
        echo view('header');
        echo view('yonetici/ogrenci_listesi');
        echo view('footer');
    }

    public function ogrenci_istekleri(){
        echo view('header');
        echo view('yonetici/ogrenci_istekleri');
        echo view('footer');
    }

    public function bagisci_listesi(){
        echo view('header');
        echo view('yonetici/bagisci_listesi');
        echo view('footer');
    }

    public function yapilan_bagislar(){
        echo view('header');
        echo view('yonetici/yapilan_bagislar');
        echo view('footer');
    }

    //Öğrenci Bölümü

    public function talepOlustur(){
        echo view('header');
        echo view('kullanici/ogrenci/talep_olustur');
        echo view('footer');
    }

    //Bağışçı Bölümü

    public function bagisYap(){
        echo view('header');
        echo view('kullanici/bagisci/bagis_yap');
        echo view('footer');
    }

    public function bagisKayitlari(){
        echo view('header');
        echo view('kullanici/bagisci/bagis_kayitlari');
        echo view('footer');
    }

    function resimYukle($gorsel, $eposta){
        if (isset($gorsel)){
            $meme_tipi = $gorsel->getMimeType();
            $uzanti = $gorsel->getExtension();
            $boyut = filesize($gorsel) / 1024;

            $desteklenen_tipler = ["image/jpg", "image/jpeg", "image/png", 'application/pdf'];
            $desteklenen_uzantilar = ["png", "jpg", "jpeg", 'pdf'];

            if (in_array($meme_tipi, $desteklenen_tipler) && in_array($uzanti, $desteklenen_uzantilar)){
                if ($boyut < 2048){
                    if (!$gorsel->hasMoved()){
                        $parcalaEposta = explode('@', $eposta);
                        $rastgeleSayi = rand(10000000,900000000);

                        $dosyaAdi = $parcalaEposta[0].'-'.$rastgeleSayi.".".$uzanti;
                        $gorsel->move(ROOTPATH."../public_html/sds_public/belgeler", $dosyaAdi);
                        return $dosyaAdi;
                    }
                } else {
                    return 'hata boyut';
                }
            } else {
                return 'hata geçersiz';
            }
        }else{
            return 'Yok';
        }
    }

    private function gelenKisi($kim)
    {
        if ($kim == 'ayça'){
            return 'hoşgeldin ayça';
        }else{
            return 'hoşgeldin misafir';
        }
    }
}
