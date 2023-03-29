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
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/stock/write/css/style.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/image.main.css">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/fonts/font-awesome/v4.7.0/css/font-awesome.min.css">

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
                        <a href="<?php echo $siteData->urlBasic; ?>/stock_write/action/photo" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/stock/write/icons/photo.png" class="img-responsive" alt="Фото">
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/stock_write/action/photo"><b>Фото</b></a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/stock_write/action/stock" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/stock/write/icons/stock.png" class="img-responsive" alt="Разместить">
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/stock_write/action/stock"><b>Разместить</b></a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/stock_write/action/revision" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/stock/write/icons/revision.png" class="img-responsive" alt="Ревизия">
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/stock_write/action/revision"><b>Ревизия</b></a>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo $siteData->urlBasic; ?>/stock_write/shopuser/unlogin" class="dropdown-toggle" data-toggle="control-sidebar">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/stock/write/icons/exit.png" class="img-responsive" alt="">
                        </a>
                        <a class="menu-title" href="<?php echo $siteData->urlBasic; ?>/stock_write/shopuser/unlogin"><b>Выход</b></a>
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
<script src="<?php echo $siteData->urlBasic; ?>/css/stock/write/js/main.js"></script>
</body>
</html>
