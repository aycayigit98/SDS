<?php

$sdsVt = new \App\Models\sdsModel();
$ogrenciler = $sdsVt->builder('kullanicilar')->where('tipi', 'Öğrenci')->get()->getResultArray();

$talepler = $sdsVt->builder('talepler')->where('goster', 'evet')->get()->getResultArray();

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
                        <th>Talep Başlığı</th>
                        <th>Talep Açıklaması</th>
                        <th>Talep Miktarı</th>
                        <th>Onay</th>
                        <th>Kayıt Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($talepler as $talep): ?>
                        <tr class="talep-id" data-bs-toggle="modal" talepid="<?= $talep['id'] ?>"
                            data-bs-target="#ayrintiModal">
                            <td><?= $talep['id'] ?></td>
                            <td><?= $talep['eposta'] ?></td>
                            <td><?= $talep['talep_adi'] ?></td>
                            <td><?= $talep['talep_aciklamasi'] ?></td>
                            <td><?= $talep['talep_miktari'] ?></td>
                            <td>
                                <?= ($talep['onay_durumu'] == 'evet') ? '<i class="mdi mdi-check-circle fs-4 text-success"></i> Aktif' : '<i class="mdi mdi-close-circle fs-4 text-danger"></i> Pasif' ?>
                            </td>
                            <td><?= date('H:i d/m/Y', strtotime($talep['kayit_tarihi'])) ?></td>
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
                <h5 class="modal-title mt-0" id="modalBaslik">Talep ID: </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-check form-switch form-switch-lg mb-3 w-100 text-center" dir="ltr">
                    <label class="form-check-label fs-4" data-on-label="aktif" data-off-label="pasif" for="radio-onay">TALEP ONAYI</label>
                    <input type="checkbox" class="form-check-input" id="radio-onay">
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d-none">
                            <input type="text" id="id-input" hidden>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="eposta-input" placeholder="qweqwe">
                            <label for="eposta-input">E-Posta</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="talepbaslik-input" placeholder="qweqwe">
                            <label for="talepbaslik-input">Talep Başlığı</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="talepaciklama-input" style="height: 100px" placeholder="qweqwe"></textarea>
                            <label for="talepaciklama-input">Talep Açıklaması</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="talepmiktar-input" placeholder="qweqwe">
                            <label for="talepmiktar-input">Talep Miktarı</label>
                        </div>
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

        $('#example tbody').on('click', '.talep-id', function() {
            var id_talep = $(this).attr('talepid');
            $.post('<?= base_url() ?>ajax/admin', {
                aksiyon: 'ogrenci_talepleri_detay_modal',
                talep_id: id_talep,
            }, function (data) {
                var veri = JSON.parse(data);

                $('#modalBaslik').text('Talep ID: '+veri.id)

                if (veri.onay_durumu === 'evet') {
                    $("#radio-onay").prop('checked', true);
                } else {
                    $("#radio-onay").prop('checked', false);
                }

                $('#id-input').val(veri.id);
                $('#eposta-input').val(veri.eposta).attr('disabled', true);
                $('#talepbaslik-input').val(veri.talep_adi);
                $('#talepaciklama-input').text(veri.talep_aciklamasi);
                $('#talepmiktar-input').val(veri.talep_miktari);

            });
        });

        $('#guncelle-btn').click(function () {
            var onay;

            if ($("#radio-onay").prop('checked') === true){
                onay = 'evet';
            }else {
                onay = 'hayir';
            }

            var talep_id = $('#id-input').val();
            var talep_adi = $('#talepbaslik-input').val();
            var talep_aciklamasi = $('#talepaciklama-input').val();
            var talep_miktari = $('#talepmiktar-input').val();

            $.post('<?= base_url() ?>ajax/admin', {
                aksiyon: 'ogrenci_talep_guncelle',
                talep_id: talep_id,
                onay_durumu: onay,
                talep_adi: talep_adi,
                talep_aciklamasi: talep_aciklamasi,
                talep_miktari: talep_miktari,
            }).done(function (data) {
                if (data === 'tamam'){
                    $('#modalBaslik').text('Güncelleme Başarılı (3 sn)').addClass('text-success');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }else {
                    $('#modalBaslik').text(data).addClass('text-danger');
                }
            });
        });

        $('#sil-btn').click(function () {
            $.post('<?= base_url() ?>ajax/admin', {
                aksiyon: 'ogrenci_talep_sil',
                talep_id: $('#id-input').val(),
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