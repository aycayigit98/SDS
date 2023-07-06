<?php

namespace App\Controllers;


use App\Models\sdsModel;

class Ajax extends BaseController
{

    public function admin()
    {
        $sdsVt = new sdsModel();

        $aksiyon = $this->request->getPost('aksiyon');

        if (session()->get('kullanici_sds')['tipi'] == 'Admin') {
            if ($aksiyon == "ogrenci_liste_detay_modal") {
                $ogrenci = $sdsVt
                    ->builder('kullanicilar')
                    ->where('id', $this->request->getPost('ogrenci_id'))
                    ->get()
                    ->getResultArray()[0];

                return json_encode($ogrenci);
            }

            if ($aksiyon == 'ogrenci_liste_guncelle') {

                $onay = $this->request->getPost('onay');
                $tckimlik = $this->request->getPost('tckimlik');
                $adi = $this->request->getPost('adi');
                $soyadi = $this->request->getPost('soyadi');
                $eposta = $this->request->getPost('eposta');
                $sifre = $this->request->getPost('sifre');
                $tema = $this->request->getPost('tema');

                $veri = [
                    'onay' => $onay,
                    'tckimlik' => $tckimlik,
                    'ad' => $adi,
                    'soyad' => $soyadi,
                    'sifre' => $sifre,
                    'tema' => $tema,
                    'guncelleme_tarihi' => strtotime('now'),
                ];


                $guncelle = $sdsVt->builder('kullanicilar')->where('eposta', $eposta)->set($veri)->update();

                if ($guncelle) {
                    echo 'tamam';
                } else {
                    echo 'hata';
                }

                die();

            }

            if ($aksiyon == 'ogrenci_liste_sil') {

                $eposta = $this->request->getPost('eposta');
                $sil = $sdsVt->builder('kullanicilar')->where('eposta', $eposta)->delete();
                if ($sil) {
                    echo 'tamam';
                } else {
                    echo 'hata';
                }

                die();
            }
        } elseif (session()->get('kullanici_sds')['tipi'] == 'Öğrenci') {
            if ($aksiyon == 'ogrenci_talep_olustur') {
                $talepAdi = $this->request->getVar('talepAdi');
                $talepMiktari = $this->request->getVar('talepMiktari');
                $talepAciklamasi = $this->request->getVar('talepAciklamasi');

                $veri = [
                    'eposta' => session()->get('kullanici_sds')['eposta'],
                    'talep_adi' => $talepAdi,
                    'talep_miktari' => $talepMiktari,
                    'talep_aciklamasi' => $talepAciklamasi,
                    'onay_durumu' => 'hayır',
                ];

                $sdsVt->builder('talepler')->insert($veri);

                die('başarılı');
            }
        } elseif (session()->get('kullanici_sds')['tipi'] == 'Bağışçı') {
            if ($aksiyon == 'bagis_yap') {

            }
        }

        if ($aksiyon == 'ogrenci_talepleri_detay_modal') {
            $talep_id = $this->request->getVar('talep_id');

            $talepSorgu = $sdsVt->builder('talepler')->where('id', $talep_id)->get()->getResultArray()[0];

            return json_encode($talepSorgu);

        }

        if ($aksiyon == 'ogrenci_talep_guncelle') {

            $talep_id = $this->request->getVar('talep_id');
            $onay_durumu = $this->request->getVar('onay_durumu');
            $talep_adi = $this->request->getVar('talep_adi');
            $talep_aciklamasi = $this->request->getVar('talep_aciklamasi');
            $talep_miktari = $this->request->getVar('talep_miktari');

            if (!empty($talep_id) and !empty($talep_miktari) and !empty($talep_adi)) {
                $veri = [
                    'onay_durumu' => $onay_durumu,
                    'talep_adi' => $talep_adi,
                    'talep_aciklamasi' => $talep_aciklamasi,
                    'talep_miktari' => $talep_miktari,
                    'guncelleme_tarihi' => strtotime('now'),
                ];

                $sdsVt->builder('talepler')->where('id', $talep_id)->set($veri)->update();

                die('tamam');
            } else {
                die('Talep açıklaması hariç kutular boş olamaz');
            }
        }

        if ($aksiyon == 'ogrenci_talep_sil') {
            $talep_id = $this->request->getVar('talep_id');

            $sil = $sdsVt->builder('talepler')->where('id', $talep_id)->delete();

            if ($sil) {
                die('tamam');
            } else {
                die('Bir hata oluştu');
            }
        }

        if ($aksiyon == 'bagisci_detaylar_modal') {
            $bagisci_id = $this->request->getVar('bagisci_id');

            $talepSorgu = $sdsVt->builder('kullanicilar')->where('tipi', 'Bağışçı')
                ->where('id', $bagisci_id)->get()->getResultArray()[0];

            return json_encode($talepSorgu);

        }

        if ($aksiyon == 'bagisci_guncelle') {

            $bagisci_id = $this->request->getVar('bagisci_id');
            $cuzdan = $this->request->getVar('cuzdan');

            if (!empty($cuzdan) and !empty($bagisci_id)) {
                $veri = [
                    'cuzdan' => $cuzdan,
                    'guncelleme_tarihi' => strtotime('now'),
                ];

                $sdsVt->builder('kullanicilar')->where('tipi', 'Bağışçı')->where('id', $bagisci_id)->set($veri)->update();

                die('tamam');
            } else {
                die('Cüzdanı boş bıraktınız veya Bağışçı Bulunamadı');
            }
        }

        if ($aksiyon == 'bagisci_sil') {
            $bagisci_id = $this->request->getVar('bagisci_id');

            $sil = $sdsVt->builder('kullanicilar')->where('tipi', 'Bağışçı')->where('id', $bagisci_id)->delete();

            if ($sil) {
                die('tamam');
            } else {
                die('Silme başarısız, bağışçı yok yada silinmiş olabilir...');
            }
        }
    }

    public function kullanici()
    {
        $sdsVt = new sdsModel();

        $aksiyon = $this->request->getVar('aksiyon');

        if ($aksiyon == 'ogrenci_belge_yukle') {
            $eposta = session()->get('kullanici_sds')['eposta'];
            $belge = $this->request->getFile('belge');


            if (!isset($belge)) {
                return redirect()->back()->with('hata', 'Belge boş olamaz');
            } else {

                $belgeAdi = $this->resimYukle($belge, $eposta);

                if ($belgeAdi == "hata boyut") {
                    return redirect()->back()->with('hata', 'Belge 2MB\'yi geçmemeli.');
                } elseif ($belgeAdi == "hata geçersiz") {
                    return redirect()->back()->with('hata', 'JPG, JPEG, PNG, PDF dışında bir dosya yükleyemezsiniz.');
                }
            }

            $sdsVt->builder('kullanicilar')->where('eposta', $eposta)->set(['belge_adi' => $belgeAdi])->update();

            return redirect()->back()->with('hata', 'Dosya Yükleme Başarılı...');
        }

        if ($aksiyon == 'ogrenci_talep_olustur') {
            $talepAdi = $this->request->getVar('talepAdi');
            $talepMiktari = $this->request->getVar('talepMiktari');
            $talepAciklamasi = $this->request->getVar('talepAciklamasi');

            if (empty($talepAdi) or empty($talepMiktari) or empty($talepAciklamasi)) {
                die('Kutulardan hiç biri boş bırakılamaz, miktar sadece rakamlardan oluşabilir.');
            }

            $veri = [
                'eposta' => session()->get('kullanici_sds')['eposta'],
                'talep_adi' => $talepAdi,
                'talep_miktari' => $talepMiktari,
                'talep_aciklamasi' => $talepAciklamasi,
                'onay_durumu' => 'hayır',
            ];

            $sdsVt->builder('talepler')->insert($veri);

            die('başarılı');
        }

        if ($aksiyon == 'talep_sil') {
            $eposta = $this->request->getVar('eposta');
            $talepAdi = $this->request->getVar('talep_adi');

            $sdsVt->builder('talepler')->where('eposta', $eposta)->where('talep_adi', $talepAdi)->delete();

            return redirect()->back();
        }

        if ($aksiyon == 'bagis_yap') {
            $talep_id = $this->request->getVar('talep_id');
            $talep_adi = $this->request->getVar('talep_adi');
            $talep_miktari = $this->request->getVar('talep_miktari');


            if (empty($talep_id) or empty($talep_adi) or empty($talep_miktari)) {
                die('Bir hata oluştu tekrar deneyin.');
            }

            $talepGetir = $sdsVt->builder('talepler')
                ->where('id', $talep_id)
                ->where('talep_adi', $talep_adi)
                ->get()->getResultArray();

            $bagisciGetir = $sdsVt->builder('kullanicilar')
                ->where('tipi', session()->get('kullanici_sds')['tipi'])
                ->where('eposta', session()->get('kullanici_sds')['eposta'])->get()->getResultArray();

            $ogrenciGetir = $sdsVt->builder('kullanicilar')
                ->where('tipi', 'Öğrenci')
                ->where('eposta', $talepGetir[0]['eposta'])->get()->getResultArray();

            if (!empty($talepGetir)) {
                if ($talepGetir[0]['onay_durumu'] == 'evet') {

                    $gelenTalepMiktari = $talepGetir[0]['talep_miktari'];

                    $ogrenciEposta = $talepGetir[0]['eposta'];
                    $ogrenciCuzdan = $ogrenciGetir[0]['cuzdan'];

                    $bagisciEposta = $bagisciGetir[0]['eposta'];
                    $bagisciCuzdan = $bagisciGetir[0]['cuzdan'];


                    if ($talep_miktari > $bagisciCuzdan) {
                        die('Bakiyeniz Yetersiz');
                    }

                    if ($gelenTalepMiktari < $talep_miktari) {
                        die('Talebin miktarından fazla bağış yapamazsınız');
                    }

                    $bagisciYeniCuzdanMiktari = $bagisciCuzdan - $talep_miktari;

                    $sdsVt->builder('kullanicilar')
                        ->where('eposta', $bagisciEposta)
                        ->set(['cuzdan' => $bagisciYeniCuzdanMiktari])
                        ->update();

                    $ogrenciYeniCuzdanMiktari = $ogrenciCuzdan + $talep_miktari;

                    $sdsVt->builder('kullanicilar')
                        ->where('eposta', $ogrenciEposta)
                        ->set(['cuzdan' => $ogrenciYeniCuzdanMiktari])
                        ->update();

                    $veri = [
                        'ogrenci_eposta' => $ogrenciEposta,
                        'bagisci_eposta' => $bagisciEposta,
                        'talep_adi' => $talep_adi,
                        'bagis_miktari' => $talep_miktari,
                    ];

                    $sdsVt->builder('yapilan_bagislar')->insert($veri);

                    if ($talep_miktari === $gelenTalepMiktari) {
                        $veri = [
                            'goster' => 'hayir',
                            'guncelleme_tarihi' => strtotime('now'),
                        ];
                        $sdsVt->builder('talepler')->where('id', $talepGetir[0]['id'])->set($veri)->update();
                    }

                    if ($talep_miktari < $gelenTalepMiktari) {
                        $yeniTalepFiyati = $gelenTalepMiktari - $talep_miktari;
                        $veri = [
                            'talep_miktari' => $yeniTalepFiyati,
                            'guncelleme_tarihi' => strtotime('now'),
                        ];
                        $sdsVt->builder('talepler')->where('id', $talepGetir[0]['id'])->set($veri)->update();
                    }

                    die('başarılı');

                } else {
                    die('Bu talep onaylanmamış');
                }

            } else {
                die('Böyle bir talep bulunamadı.');
            }

        }

    }

    function resimYukle($gorsel, $eposta)
    {
        if (isset($gorsel)) {
            $meme_tipi = $gorsel->getMimeType();
            $uzanti = $gorsel->getExtension();
            $boyut = filesize($gorsel) / 1024;

            $desteklenen_tipler = ["image/jpg", "image/jpeg", "image/png", 'application/pdf'];
            $desteklenen_uzantilar = ["png", "jpg", "jpeg", 'pdf'];

            if (in_array($meme_tipi, $desteklenen_tipler) && in_array($uzanti, $desteklenen_uzantilar)) {
                if ($boyut < 2048) {
                    if (!$gorsel->hasMoved()) {
                        $parcalaEposta = explode('@', $eposta);
                        $rastgeleSayi = rand(10000000, 900000000);

                        $dosyaAdi = $parcalaEposta[0] . '-' . $rastgeleSayi . "." . $uzanti;
                        $gorsel->move(ROOTPATH . "../public_html/sds_public/belgeler", $dosyaAdi);
                        return $dosyaAdi;
                    }
                } else {
                    return 'hata boyut';
                }
            } else {
                return 'hata geçersiz';
            }
        } else {
            return 'Yok';
        }
    }

}
