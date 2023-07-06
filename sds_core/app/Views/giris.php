<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login | Lexa - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>kaynak/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?= base_url() ?>kaynak/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url() ?>kaynak/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url() ?>kaynak/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="card-body pt-0">

                        <h3 class="text-center mt-5 mb-4">
                            <a href="index.html" class="d-block auth-logo">
                                <img src="<?= base_url() ?>kaynak/images/logo-dark.png" alt="" height="30" class="auth-logo-dark">
                                <img src="<?= base_url() ?>kaynak/images/logo-light.png" alt="" height="30" class="auth-logo-light">
                            </a>
                        </h3>

                        <div class="p-3">
                            <h4 class="text-muted font-size-18 mb-1 text-center">Hoşgeldiniz</h4>
                            <?php if (session()->getFlashdata('hata') != '' ): ?>
                                <div class="alert alert-danger alert-dismissible fade show mt-4 px-4 mb-0 text-center" role="alert">
                                    <i class="mdi mdi-alert-octagon-outline d-block display-4 mt-2 mb-3 text-danger"></i>
                                    <h5 class="text-danger">Başarısız</h5>
                                    <p><?= session()->getFlashdata('hata') ?></p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                                    </button>
                                </div>
                            <?php endif; ?>
                            <form method="post" class="form-horizontal mt-4" action="<?= base_url() ?>kontrolgiris">
                                <div class="mb-3">
                                    <label for="username">E-Posta</label>
                                    <input type="text" class="form-control rounded-pill"
                                           id="username" name="eposta" placeholder="Bir e-posta girin">
                                </div>
                                <div class="mb-3">
                                    <label for="userpassword">Şifre</label>
                                    <input type="password"
                                           class="form-control rounded-pill"
                                           id="userpassword" name="sifre"
                                           placeholder="Bir şifre girin">
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <button class="fw-bold btn btn-primary w-md waves-effect waves-light w-100 rounded-pill mb-2"
                                                type="submit">Giriş Yap</button>
                                        <a href="<?= base_url() ?>uyeol"
                                           class="fw-bold btn btn-danger w-md waves-effect waves-light w-100 rounded-pill"
                                           type="submit">Üye Ol</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center">
                    © <script>document.write(new Date().getFullYear())</script> SDS <span class="d-none d-sm-inline-block"> - <i class="mdi mdi-heart text-danger"></i> ile yapıldı - Ayça.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script src="<?= base_url() ?>kaynak/libs/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>kaynak/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>kaynak/libs/metismenu/metisMenu.min.js"></script>
<script src="<?= base_url() ?>kaynak/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url() ?>kaynak/libs/node-waves/waves.min.js"></script>
<script src="<?= base_url() ?>kaynak/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
<!-- App js -->
<script src="<?= base_url() ?>kaynak/js/app.js"></script>
</body>

</html>