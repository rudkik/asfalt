<!DOCTYPE html>
<html lang="ru">
<head>
    <title>SMMarket - Orders | SMMarket</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta http-equiv="content-type" content="text/html; charset=utf8">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/favicon.png" rel="shortcut icon" type="image/x-icon" />

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/css/base.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/style.css">

    <!--  загрузка файлов -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/loadimage_v2/image.main.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/loadimage_v2/jquery.jgrowl.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/_component/loadfile/css/style.css"  />
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/loadfile/js/jquery.knob.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/loadfile/js/jquery.ui.widget.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/loadfile/js/jquery.iframe-transport.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/loadfile/js/jquery.fileupload.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/loadfile/js/script.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/admin-panel/server/jquery-ui.min.js"></script>
</head>
<body>
<div class="green-block">
    <div class="header header-top-shop">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="logo-block">
                        <a href="/"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png" class="logo img-responsive" alt=""></a>
                    </div>
                    <div class="nav-pills">
                        <div class="top-menu">
                            <ul class="nav navbar-nav nav-top-menu">
                                <li>
                                    <a href="/sadmin/shopbill/index?shop_bill_status_id=1,3,4,5,8">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/bill.png" class="img-responsive" alt="">
                                        <span>Заказы</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/sadmin/shopgoodcatalog/index?type=3722">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/goods.png" class="img-responsive" alt="">
                                        <span>Категории товаров</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/sadmin/shopgood/index?type=3722">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/goods.png" class="img-responsive" alt="">
                                        <span>Товары</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/sadmin/shopbranch/index?type=3724&is_public_ignore=1">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/partner.png" class="img-responsive" alt="">
                                        <span>Поставщики</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/sadmin/shopbranch/index?type=3731&is_public_ignore=1">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/shop.png" class="img-responsive" alt="">
                                        <span>Магазины</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/sadmin/shopoperation/index">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/manager.png" class="img-responsive" alt="">
                                        <span>Менеджеры</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/sadmin/shopoperation/edit?id=<?php echo $siteData->operationID; ?>&shop_branch_id=<?php echo $siteData->shopID; ?>">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/password.png" class="img-responsive" alt="">
                                        <span>Смена пароля</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/sadmin/shopuser/unlogin">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/exit.png" class="img-responsive" alt="">
                                        <span>Выход</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="shop">
                        <div class="title">администатор</div>
                        <div class="name"><?php echo $siteData->shop->getName(); ?></div>
                        <div class="user"><?php echo $siteData->user->getName(); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-shift-shop"></div>
</div>
<?php echo trim($data['view::main']); ?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="/"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png" class="logo img-responsive" alt=""></a>
            </div>
            <div class="col-md-3">
                <ul>
                    <li>
                        <a href="/sadmin/shopbill/index?shop_bill_status_id=1,3,4,5,8">
                            <span>Заказы</span>
                        </a>
                    </li>
                    <li>
                        <a href="/sadmin/shopgood/index?type=3722">
                            <span>Товары</span>
                        </a>
                    </li>
                    <li>
                        <a href="/sadmin/shopbranch/index?type=3721">
                            <span>Поставщики</span>
                        </a>
                    </li>
                    <li>
                        <a href="/sadmin/shopbranch/index?type=3731">
                            <span>Магазины</span>
                        </a>
                    </li>
                    <li>
                        <a href="/sadmin/shopoperation/index">
                            <span>Менеджеры</span>
                        </a>
                    </li>
                    <li>
                        <a href="/sadmin/shopuser/unlogin">
                            <span>Смена пароля</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h3>Контакты</h3>
                <p><b>Товарищество с ограниченной ответственностью «Smart Market Group»</b></p>
                <p><b>БИН</b> 160740019740 Кбе 17</p>
                <p><b>Юр.адрес</b> 050059, Республика Казахстан, Бостандыкский р-н, г.Алматы, ул.Панфилова, 212</p>
                <p><b>ИИК</b> KZ51926180219Y405000 (KZT) в АО «Казкоммерцбанк»</p>
                <p><b>БИК</b> KZKOKZKX</p>
                <p><b>Генеральный Директор:</b> Смоленский Юрий Викторович</p>
                <p><b>Коммерческий Директор:</b> Тимур Алиев</p>
                <p><b>+7 747 574 00 22</b></p>
                <p><b>Категорийный менеджер:</b> Оксана Русакова</p>
                <p><b>+7 707 166 25 70</b></p>
            </div>
        </div>
    </div>
</footer>

<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
<script>
    $(function () {
        $(".select2").select2();

        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });
</script>

<!-- Bootstrap 3.3.5 -->
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/main.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/loadimage_v2/dmuploader.min.js"></script>
</body>
</html>