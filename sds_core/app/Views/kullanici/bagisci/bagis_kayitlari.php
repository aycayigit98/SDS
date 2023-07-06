<?php

$sdsVt = new \App\Models\sdsModel();

$bagis_kayitlari = $sdsVt->builder('yapilan_bagislar')->where('bagisci_eposta', session()->get('kullanici_sds')['eposta'])->get()->getResultArray();

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
                        <th>Bağış Miktarı</th>
                        <th>Bağış Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($bagis_kayitlari as $bagis): ?>
                        <tr class="">
                            <td><?= $bagis['id'] ?></td>
                            <td><?= $bagis['talep_adi'] ?></td>
                            <td><?= $bagis['bagis_miktari'] ?> ₺</td>
                            <td><?= date('H:i - d/m/Y', strtotime($bagis['kayit_tarihi'])) ?></td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
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

        $('#talep-olustur-btn').click(function () {
            $.post('<?= base_url() ?>ajax/kullanici', {
                aksiyon: 'ogrenci_talep_olustur',
                talepAdi: $('#talep-adi-input').val(),
                talepMiktari: $('#talep-miktar-input').val(),
                talepAciklamasi: $('#aciklama-textarea').val(),
            }).done(function (data) {
                if (data === 'başarılı') {
                    $('#modalBasligi').text('Talep Başarıyla Oluşturuldu (3sn)').addClass('text-success');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    $('#modalBasligi').text('Talep Oluşturma Başarısız...').addClass('text-danger');
                }
            });
        });

    });
</script>