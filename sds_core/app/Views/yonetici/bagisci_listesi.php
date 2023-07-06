<?php

$sdsVt = new \App\Models\sdsModel();

$bagiscilar = $sdsVt->builder('kullanicilar')->where('tipi', 'Bağışçı')->get()->getResultArray();

?>

<style>
    @media (max-width: 767px) {
        .dataTables_wrapper .dataTables_info {
            display: none;
        }
    }

</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="example" class="display table border rounded-3" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>E-posta</th>
                        <th>Cüzdan</th>
                        <th>Kayıt Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($bagiscilar as $bagisci): ?>
                        <tr class="bagisci-id" data-bs-toggle="modal" bagisciid="<?= $bagisci['id'] ?>"
                            data-bs-target="#ayrintiModal">
                            <td><?= $bagisci['id'] ?></td>
                            <td><?= $bagisci['eposta'] ?></td>
                            <td><?= ($bagisci['cuzdan'] == '') ? '0' : $bagisci['cuzdan'] ?> ₺</td>
                            <td><?= date('H:i - d/m/Y', strtotime($bagisci['kayit_tarihi'])) ?></td>
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
                <h5 class="modal-title mt-0" id="modalBaslik">Bağışçı ID: </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--<div class="form-check form-switch form-switch-lg mb-3 w-100 text-center" dir="ltr">
                    <label class="form-check-label fs-4" data-on-label="aktif" data-off-label="pasif" for="radio-onay">TALEP ONAYI</label>
                    <input type="checkbox" class="form-check-input" id="radio-onay">
                </div>-->
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
                            <input type="text" class="form-control" id="cuzdan-input" placeholder="qweqwe">
                            <label for="cuzdan-input">Cüzdan</label>
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

        $('#example tbody').on('click', '.bagisci-id', function() {
            var id_bagisci = $(this).attr('bagisciid');
            $.post('<?= base_url() ?>ajax/admin', {
                aksiyon: 'bagisci_detaylar_modal',
                bagisci_id: id_bagisci,
            }, function (data) {
                var veri = JSON.parse(data);

                $('#modalBaslik').text('Bağışçı ID: '+veri.id)

                $('#id-input').val(veri.id);
                $('#eposta-input').val(veri.eposta).attr('disabled', true);
                $('#cuzdan-input').val(veri.cuzdan);
            });
        });

        $('#guncelle-btn').click(function () {

            var bagisci_id = $('#id-input').val();
            var cuzdan = $('#cuzdan-input').val();

            $.post('<?= base_url() ?>ajax/admin', {
                aksiyon: 'bagisci_guncelle',
                bagisci_id: bagisci_id,
                cuzdan: cuzdan,
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
                aksiyon: 'bagisci_sil',
                bagisci_id: $('#id-input').val(),
            }).done(function (data) {
                if (data === 'tamam'){
                    $('#modalBaslik').text('Silme Başarılı (3 sn)').addClass('text-success');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }else {
                    $('#modalBaslik').text(data).addClass('text-danger');
                }
            })
        });

    });
</script>