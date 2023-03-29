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
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/css/base.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/style.css">

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/scripts.js"></script>
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
                                    <a href="/customer/shopbill/index">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/bill.png" class="img-responsive" alt="">
                                        <span>Заказы</span>
                                    </a>
                                </li>
                                <li  >
                                    <a href="/customer/shopoperation/index">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/manager.png" class="img-responsive" alt="">
                                        <span>Менеджеры</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/customer/shopbranch/index?type=3724">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/partner.png" class="img-responsive" alt="">
                                        <span>Поставщики</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/customer/shopgood/index?type=3722&good_select_type_id=3723">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/new.png" class="img-responsive" alt="">
                                        <span>Новинки</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/customer/shopgood/index?type=3722&is_discount=1">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/sale.png" class="img-responsive" alt="">
                                        <span>Акции</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/customer/shopbranch/edit?id=<?php echo $siteData->shopID; ?>">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/info.png" class="img-responsive" alt="">
                                        <span>Данные торговой точки</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/customer/shopoperation/edit?id=<?php echo $siteData->operationID; ?>">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/password.png" class="img-responsive" alt="">
                                        <span>Смена пароля</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/customer/shopuser/unlogin">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/exit.png" class="img-responsive" alt="">
                                        <span>Выход</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="shop" >
                        <div class="title">торговая точка</div>
                        <div class="name"><?php echo $siteData->userShop->getName(); ?></div>
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
                        <a href="/customer/shopbill/index">
                            <span>Заказы</span>
                        </a>
                    </li>
                    <li>
                        <a href="/customer/shopoperation/index">
                            <span>Менеджеры</span>
                        </a>
                    </li>
                    <li>
                        <a href="/customer/shopbranch/index?type=3721">
                            <span>Поставщики</span>
                        </a>
                    </li>
                    <li>
                        <a href="/customer/shopgood/index?type=3722&good_select_type_id=3723">
                            <span>Новинки</span>
                        </a>
                    </li>
                    <li>
                        <a href="/customer/shopgood/index?type=3721&is_discount=1">
                            <span>Акции</span>
                        </a>
                    </li>
                    <li>
                        <a href="/customer/shopuser/unlogin">
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

<!-- Bootstrap 3.3.5 -->
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/main.js"></script>
</body>
</html>