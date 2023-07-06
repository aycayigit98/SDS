<?php

$sdsVt = new \App\Models\sdsModel();

$talepler = $sdsVt->builder('talepler')->where('onay_durumu', 'evet')->where('goster', 'evet')->get()->getResultArray();

?>

<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="example" class="display table border rounded-3" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Talep Adı</th>
                        <th>Talep Miktarı</th>
                        <th>Talep Açıklaması</th>
                        <th>Onay Durumu</th>
                        <th>Kayıt Tarihi</th>
                        <th>Güncellenme Tarihi</th>
                        <th>Bağış</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($talepler as $talep): ?>
                        <tr>
                            <td><?= $talep['id'] ?></td>
                            <td><?= $talep['talep_adi'] ?></td>
                            <td><?= $talep['talep_miktari'] ?> ₺</td>
                            <td><?= $talep['talep_aciklamasi'] ?></td>
                            <td><?= ($talep['onay_durumu'] != 'evet') ? '<span class="badge bg-warning text-black fs-6">İnceleniyor</span>' : '<span class="badge bg-success text-black fs-6">Onaylandı</span>' ?></td>
                            <td><?= date('H:i - d/m/Y', strtotime($talep['kayit_tarihi'])) ?></td>
                            <td><?= date('H:i - d/m/Y', $talep['guncelleme_tarihi']) ?></td>
                            <td>
                                <button  talepadi="<?= $talep['talep_adi'] ?>" talepmiktari="<?= $talep['talep_miktari'] ?>" talepid="<?= $talep['id'] ?>"
                                        type="button" data-bs-toggle="modal" data-bs-target="#bagisModal"
                                   class="btn btn-primary waves-effect waves-light btn-sm rounded-pill bagis-yap-btn" >Bağış Yap</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bagisModal" tabindex="-1" aria-labelledby="modalBasligi"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalBasligi">Bağış Yap</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="talep-adi-input" disabled>
                            <label for="talep-adi-input">Bağış Yap</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="talep-miktar-input">
                            <label for="talep-miktar-input">Ne kadar bağış yapmak istiyorsunuz?</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="iptal-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    İptal
                </button>
                <button id="bagis-yap-btn" type="button" class="btn btn-primary">Bağış Yap</button>
                <input type="text" class="d-none" id="talep-id-i">
                <input type="text" class="d-none" id="talep-adi-i">
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

        $('#example tbody').on('click', '.bagis-yap-btn', function() {

            var talep_id = $(this).attr('talepid');
            var talep_adi = $(this).attr('talepadi');
            var talep_miktari = $(this).attr('talepmiktari');

            $('#talep-id-i').val(talep_id);
            $('#talep-adi-i').val(talep_adi);
            $('#talep-adi-input').val(talep_adi);
            $('#talep-miktar-input').val(talep_miktari);

        });


        $('#bagis-yap-btn').click(function () {
            $.post('<?= base_url() ?>ajax/kullanici', {
                aksiyon: 'bagis_yap',
                talep_id: $('#talep-id-i').val(),
                talep_adi: $('#talep-adi-i').val(),
                talep_miktari: $('#talep-miktar-input').val(),
            }).done(function (data) {
                if (data === 'başarılı') {
                    $('#modalBasligi').text('Bağışınız Gerçekleşti, Teşekkürler (3sn)').removeClass('text-danger').addClass('text-success');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    $('#modalBasligi').text(data).addClass('text-danger');
                }
            });
        });

    });
</script>