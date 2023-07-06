<?php

$sdsVt = new \App\Models\sdsModel();
$ogrenciler = $sdsVt->builder('kullanicilar')->where('tipi', 'Öğrenci')->get()->getResultArray();

?>

<style>
    @media (max-width: 767px) {
        .dataTables_wrapper .dataTables_info {
            display: none;
        }
    }

</style>

<div class="row">
    <!--<div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row text-center gx-2 gy-2">
                    <div class="col-12 col-md-6 col-lg-3">
                        <button class="btn btn-primary rounded-pill waves-effect w-100 ">
                            Yeni Öğrenci Ekle
                        </button>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <button class="btn btn-primary rounded-pill waves-effect w-100 ">
                            Yeni Öğrenci Ekle
                        </button>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <button class="btn btn-primary rounded-pill waves-effect w-100 ">
                            Yeni Öğrenci Ekle
                        </button>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <button class="btn btn-primary rounded-pill waves-effect w-100 ">
                            Yeni Öğrenci Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="example" class="display table border rounded-3" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>E-posta</th>
                        <th>Belge</th>
                        <th>Talep Sayısı</th>
                        <th>Durum</th>
                        <th>Cüzdan</th>
                        <th>Kayıt Tarihi</th>
                        <th>Güncellenme Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($ogrenciler as $ogrenci): ?>
                    <tr class="ogrenci-id" data-bs-toggle="modal" value="<?= $ogrenci['id'] ?>"
                        data-bs-target="#ayrintiModal">
                        <td><?= $ogrenci['id'] ?></td>
                        <td><?= $ogrenci['eposta'] ?></td>
                        <td><?= $ogrenci['belge_adi'] ?></td>
                        <td><?= $sdsVt->builder('talepler')->where('eposta', $ogrenci['eposta'])->countAllResults() ?></td>
                        <td>
                            <?= ($ogrenci['onay'] == 'evet') ? '<i class="mdi mdi-check-circle fs-5 text-success"></i> Aktif' : '<i class="mdi mdi-close-circle fs-5 text-danger"></i> Pasif' ?>
                        </td>
                        <td><?= $ogrenci['cuzdan'] ?> ₺</td>
                        <td><?= date('H:i - d/m/Y', strtotime($ogrenci['kayit_tarihi'])) ?></td>
                        <td><?= ($ogrenci['guncelleme_tarihi'] != '') ? date('H:i d/m/Y', $ogrenci['guncelleme_tarihi']) : 'Güncellenmedi' ?></td>
                    </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ayrintiModal" tabindex="-1"
     aria-labelledby="modalBaslik"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="modalBaslik">Öğrenci ID: </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-check form-switch form-switch-lg mb-3 w-100 text-center" dir="ltr">
                    <label class="form-check-label fs-4" data-on-label="aktif" data-off-label="pasif" for="radio-onay">Öğrenci Onayı</label>
                    <input type="checkbox" class="form-check-input" id="radio-onay">
                </div>
                <div class="row mb-4">
                    <label for="input-belge" class="col-sm-3 col-form-label">Belge</label>
                    <div class="col-sm-9">
                        <a target="_blank" href="#" id="link-belge"><input type="text" class="form-control border-info" id="input-belge" disabled></a>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="input-tckimlik" class="col-sm-3 col-form-label">TC Kimlik</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="input-tckimlik">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="input-adi" class="col-sm-3 col-form-label">Adı</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="input-adi">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="input-soyadi" class="col-sm-3 col-form-label">Soyadı</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="input-soyadi">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="input-eposta" class="col-sm-3 col-form-label">E-Posta</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control border-danger" id="input-eposta" disabled>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="input-sifre" class="col-sm-3 col-form-label">Şifre</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="input-sifre">
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="form-check-label col-sm-4" for="radio-tema">Tema (kapalı: açık tema)</label>
                    <div class="form-check form-switch form-switch-md mb-3 col-sm-8" dir="ltr">
                        <input type="checkbox" class="form-check-input" id="radio-tema">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="sil-btn" type="button" class="btn btn-danger waves-effect waves-light">Sil</button>
                <button id="modal-kapat-btn" type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Kapat</button>
                <button id="guncelle-btn" type="button" class="btn btn-primary waves-effect waves-light">Güncelle</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            order: [[0, 'desc']],
            scrollX: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });

        $('#example tbody').on('click', '.ogrenci-id', function() {
            var ogrenci_id = $(this).attr('value');
            $.post('<?= base_url() ?>ajax/admin', {
                aksiyon: 'ogrenci_liste_detay_modal',
                ogrenci_id: ogrenci_id,
            }).done(function(data) {
                var veri = JSON.parse(data);
                $('#modalBaslik').text('Öğrenci ID: ' + veri.id);

                if (veri.onay === 'evet') {
                    $("#radio-onay").prop('checked', true);
                } else {
                    $("#radio-onay").prop('checked', false);
                }

                if (veri.tema === '1') {
                    $("#radio-tema").prop('checked', true);
                } else {
                    $("#radio-tema").prop('checked', false);
                }

                $("#input-belge").val(veri.belge_adi);
                $("#link-belge").attr('href', '<?= base_url() ?>belgeler/' + veri.belge_adi);
                $('#input-tckimlik').val(veri.tckimlik);
                $('#input-adi').val(veri.ad);
                $('#input-soyadi').val(veri.soyad);
                $('#input-eposta').val(veri.eposta);
                $('#input-sifre').val(veri.sifre);
            });
        });

        $('#guncelle-btn').click(function () {
            var onay; var tema;

            if ($("#radio-onay").prop('checked') === true){
                onay = 'evet';
            }else {
                onay = 'hayir';
            }

            if ($("#radio-tema").prop('checked') === true){
                tema = '1';
            }else {
                tema = '0';
            }

            var tckimlik = $('#input-tckimlik').val();
            var adi = $('#input-adi').val();
            var soyadi = $('#input-soyadi').val();
            var eposta = $('#input-eposta').val();
            var sifre = $('#input-sifre').val();

            $.post('<?= base_url() ?>ajax/admin', {
                aksiyon: 'ogrenci_liste_guncelle',
                onay: onay,
                tema: tema,
                tckimlik: tckimlik,
                adi: adi,
                soyadi: soyadi,
                eposta: eposta,
                sifre: sifre,
            }).done(function (data) {
                if (data === 'tamam'){
                    $('#modalBaslik').text('Güncelleme Başarılı (3 sn)').addClass('text-success');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }else {
                    $('#modalBaslik').text('Güncelleme Başarısız').addClass('text-danger');
                }
            });
        });

        $('#sil-btn').click(function () {
            $.post('<?= base_url() ?>ajax/admin', {
                aksiyon: 'ogrenci_liste_sil',
                eposta: $('#input-eposta').val(),
            }).done(function (data) {
                if (data === 'tamam'){
                    $('#modalBaslik').text('Silme Başarılı (3 sn)').addClass('text-success');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }else {
                    $('#modalBaslik').text('Silme Başarısız').addClass('text-danger');
                }
            })
        });

    });
</script>