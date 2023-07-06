<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title>Galiba bir hata oldu.</title>

    <style>
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>
</head>
<body>

    <div class="container text-center">

        <h1 class="headline">Bir hata oluştu...</h1>

        <p class="lead"><a href="<?= base_url() ?>hata?hataalindi">Hata aldığın yeri bana bildir... </a></p>

    </div>

</body>

</html>
