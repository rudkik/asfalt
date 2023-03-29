<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php if($siteData->shopID > 0){ ?>
        <title><?php echo $siteData->shop->getName(); ?> - кабинет</title>
    <?php }else{ ?>
        <title>Кабинет компании</title>
    <?php } ?>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/css/base.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/manager/css/style.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/image.main.css">

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/server/jquery-ui.min.js"></script>
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-static-top text-center" role="navigation" style="margin: 0px;">
            <div class="navbar-custom-menu" style="float: none;display: inline-block;">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/manager/shopbranch/index?type=51658" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/sladushka/manager/icons/shop.png" class="img-responsive" alt="">
                            <span class="label label-success"><?php echo $siteData->globalDatas['view::shop_count']; ?></span>
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/manager/shopbranch/index?type=51658"><b>Магазины</b></a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/manager/shoptablerubric/index?type=51657&table_id=<?php echo Model_Shop_Good::TABLE_ID; ?>" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/sladushka/manager/icons/catalog.png" class="img-responsive" alt="">
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/manager/shoptablerubric/index?type=51657&table_id=<?php echo Model_Shop_Good::TABLE_ID; ?>"><b>Группы</b></a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/manager/shopgood/index?type=51657" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/sladushka/manager/icons/goods.png" class="img-responsive" alt="">
                            <span class="label label-warning"><?php echo $siteData->globalDatas['view::good_count']; ?></span>
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/manager/shopgood/index?type=51657"><b>Продукция</b></a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/manager/shoppaid/index" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/sladushka/manager/icons/payment.png" class="img-responsive" alt="">
                            <span class="label label-info"><?php echo $siteData->globalDatas['view::paid_count']; ?></span>
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/manager/shoppaid/index"><b>Оплата</b></a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/manager/shopcart/index" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/sladushka/manager/icons/cart.png" class="img-responsive" alt="">
                            <span class="label label-maroon"><?php echo $siteData->globalDatas['view::cart_count']; ?></span>
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/manager/shopcart/index"><b>Корзина</b></a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/manager/shopoperationstock/index?id=53943" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/sladushka/manager/icons/stock.png" class="img-responsive" alt="">
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/manager/shopoperationstock/index?id=53943"><b>Заявки</b></a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/manager/shopbill/index?type=51662" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/sladushka/manager/icons/bill.png" class="img-responsive" alt="">
                            <span class="label label-danger"><?php echo $siteData->globalDatas['view::bill_count']; ?></span>
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/manager/shopbill/index?type=51662"><b>Заказы</b></a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/manager/shopreturn/index?type=52317" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/sladushka/manager/icons/return.png" class="img-responsive" alt="">
                            <span class="label label-danger"><?php echo $siteData->globalDatas['view::return_count']; ?></span>
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/manager/shopreturn/index?type=52317"><b>Возвраты</b></a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/manager/shopuser/unlogin" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/sladushka/manager/icons/exit.png" class="img-responsive" alt="">
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/manager/shopuser/unlogin"><b>Выход</b></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <section class="content">
        <div class="content-wrapper">
            <div class="box box-primary ">
                <div class="box-body">
                    <?php echo trim($data['view::main']); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/manager/js/main.js"></script>
</body>
</html>
