<?php

$sdsVt = new \App\Models\sdsModel();

$talepler = $sdsVt->builder('talepler')->where('goster', 'evet')->where('eposta', session()->get('kullanici_sds')['eposta'])->get()->getResultArray();

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary w-25 rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                    <i class="mdi mdi-message-draw"></i> Talep Oluştur
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="modalBasligi"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalBasligi">Talep Oluştur</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="talep-adi-input">
                                            <label for="talep-adi-input">Talep Adı</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="talep-miktar-input">
                                            <label for="talep-miktar-input">İstediğiniz yardım miktarı (Örn:
                                                500)</label>
                                        </div>
                                        <div class="form-floating">
                                            <textarea class="form-control" id="aciklama-textarea"
                                                      style="height: 100px"></textarea>
                                            <label for="aciklama-textarea">Açıklama</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="iptal-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    İptal
                                </button>
                                <button id="talep-olustur-btn" type="button" class="btn btn-primary">Talebi Oluştur
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($talepler as $talep): ?>
                        <tr class="">
                            <td><?= $talep['id'] ?></td>
                            <td><?= $talep['talep_adi'] ?></td>
                            <td><?= $talep['talep_miktari'] ?> ₺</td>
                            <td><?= $talep['talep_aciklamasi'] ?></td>
                            <td><?= ($talep['onay_durumu'] != 'evet') ? '<span class="badge bg-warning text-black fs-6">İnceleniyor</span>' : '<span class="badge bg-success text-black fs-6">Onaylandı</span>' ?></td>
                            <td><?= date('H:i - d/m/Y', strtotime($talep['kayit_tarihi'])) ?></td>
                            <td><?= ($talep['guncelleme_tarihi'] == '') ? 'Güncellenmedi' : date('H:i - d/m/Y', strtotime($talep['guncelleme_tarihi'])) ?></td>
                            <td class="text-center">
                                <a href="<?= base_url() ?>ajax/kullanici?aksiyon=talep_sil&talep_adi=<?= $talep['talep_adi'] . '&eposta=' . $talep['eposta'] ?>"
                                   type="button"
                                   class="btn btn-danger waves-effect waves-light btn-sm rounded-pill">Sil</a>
                            </td>
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
                    $('#modalBasligi').text('Talep Başarıyla Oluşturuldu (3sn)').removeClass('text-danger').addClass('text-success');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    $('#modalBasligi').html(data).addClass('text-danger').addClass('text-start');
                }
            });
        });

    });
</script>