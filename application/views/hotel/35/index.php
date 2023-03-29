<!DOCTYPE html>
<html lang="en">

<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8">
    <title><?php echo $siteData->shop->getName(); ?> - кабинет</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/assets/fonts/open-sans/styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/tether/css/tether.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/jscrollpane/jquery.jscrollpane.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/assets/styles/common.min.css">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/assets/styles/themes/primary.min.css">
    <!-- END THEME STYLES -->

    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/jquery/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/prism/prism.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/assets/styles/libs/bootstrap-notify/bootstrap-notify.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/bootstrap-table/bootstrap-table.min.css"> <!-- Original -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/assets/styles/libs/bootstrap-table/bootstrap-table.min.css"> <!-- Customization -->

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/assets/styles/libs/select2/select2.min.css">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/css/style.css">
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/bloodhound.min.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/typeahead.jquery.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/js/handlebars.js"></script>

    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.css"/>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/admin-panel/server/jquery-ui.min.js"></script>

    <?php if ($siteData->operation->getShopTableRubricID() == 1){ ?>
    <link rel="stylesheet" href=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/lib/codemirror.css">
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/lib/codemirror.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/edit/matchbrackets.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/xml/xml.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/javascript/javascript.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/css/css.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/clike/clike.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/php/php.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/selection/active-line.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/edit/closetag.js"></script>

    <link rel="stylesheet" href=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/foldgutter.css" />
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/foldcode.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/foldgutter.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/brace-fold.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/xml-fold.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/markdown-fold.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/comment-fold.js"></script>

    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/display/fullscreen.js"></script>

    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/edit/matchtags.js"></script>

    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/hint/html-hint.js"></script>
    <script src=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/hint/show-hint.js"></script>
    <link rel="stylesheet" href=" <?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/hint/show-hint.css">
    <?php } ?>

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/hotel/css/style.css?cache=2">
</head>

<body class="ks-navbar-fixed ks-sidebar-default ks-sidebar-fixed ks-theme-primary ks-page-loading">

<nav class="navbar ks-navbar">
    <div href="index.html" class="navbar-brand">
        <a href="#" class="ks-sidebar-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
        <a href="#" class="ks-sidebar-mobile-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
        <a href="index.html" class="ks-logo"><?php echo $siteData->shop->getName(); ?></a>
        <span class="nav-item dropdown ks-dropdown-grid">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>
            <div class="dropdown-menu ks-info ks-scrollable" aria-labelledby="Preview" data-height="260">
                <div class="ks-scroll-wrapper">
                    <a href="#" class="ks-grid-item">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span class="ks-text">Справочники</span>
                    </a>
                </div>
            </div>
        </span>
    </div>
    <div class="ks-wrapper">
        <nav class="nav navbar-nav">
            <div class="ks-navbar-menu"></div>
            <div class="ks-navbar-actions">
                <?php
                $s = $siteData->operation->getName();
                if (!empty($s)){
                    ?>
                    <div class="nav-item dropdown ks-user">
                    <span class="nav-item nav-link">
                        <?php echo $s; ?>
                    </span>
                    </div>
                <?php } ?>
                <div class="nav-item dropdown ks-user">
                    <a class="nav-item nav-link" href="<?php echo $siteData->urlBasic; ?>/hotel/shopuser/unlogin">
                        Выход
                    </a>
                </div>
            </div>
        </nav>
        <nav class="nav navbar-nav ks-navbar-actions-toggle">
            <a class="nav-item nav-link" href="#">
                <span class="fa fa-ellipsis-h ks-icon ks-open"></span>
                <span class="fa fa-close ks-icon ks-close"></span>
            </a>
        </nav>
        <nav class="nav navbar-nav ks-navbar-menu-toggle">
            <a class="nav-item nav-link" href="#">
                <span class="fa fa-th ks-icon ks-open"></span>
                <span class="fa fa-close ks-icon ks-close"></span>
            </a>
        </nav>
    </div>
</nav>
<div class="ks-container">
    <div class="ks-column ks-sidebar ks-info">
        <div class="ks-wrapper">
            <ul class="nav nav-pills nav-stacked">
                <?php if ($siteData->operation->getShopTableRubricID() != 4){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span>Текущий день</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-bill-item-entry" data-title="На въезд" href="<?php echo $siteData->urlBasic; ?>/hotel/shopbillitem/current_entry">На въезд</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-bill-item-exit" data-title="На выезд" href="<?php echo $siteData->urlBasic; ?>/hotel/shopbillitem/current_exit">На выезд</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-bill-item-relax" data-title="Отдыхают" href="<?php echo $siteData->urlBasic; ?>/hotel/shopbillitem/current_relax">Отдыхают</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-room-free" data-title="Свободные номера" href="<?php echo $siteData->urlBasic; ?>/hotel/shoproom/current_free">Свободные номера</a>

                        <?php if ($siteData->operation->getShopTableRubricID() == 2){ ?>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-client" data-title="Клиенты" href="<?php echo $siteData->urlBasic; ?>/hotel/shopclient/index">Клиенты</a>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-bill" data-title="Брони" href="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/index">Брони</a>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-consumable" data-title="Расходники" href="<?php echo $siteData->urlBasic; ?>/hotel/shopconsumable/index">Расходники</a>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-report" data-title="Отчеты" href="<?php echo $siteData->urlBasic; ?>/hotel/shopreport/index">Отчеты</a>
                        <?php } ?>
                    </div>
                </li>
                <?php } ?>
                <?php if ($siteData->operation->getShopTableRubricID() != 2){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span>Бронирование</span>
                    </a>
                    <div class="dropdown-menu">
                        <?php if ($siteData->operation->getShopTableRubricID() == 4){ ?>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-bill" data-title="Брони" href="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/index">Брони</a>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-report" data-title="Отчеты" href="<?php echo $siteData->urlBasic; ?>/hotel/shopreport/index">Отчеты</a>
                        <?php }else{ ?>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-client" data-title="Клиенты" href="<?php echo $siteData->urlBasic; ?>/hotel/shopclient/index">Клиенты</a>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-bill" data-title="Брони" href="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/index">Брони</a>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-bill-cancel" data-title="Отмененные брони" href="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/index_cancel">Отмененные брони</a>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-payment" data-title="Оплата" href="<?php echo $siteData->urlBasic; ?>/hotel/shoppayment/index">Оплата</a>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-refund" data-title="Возврат" href="<?php echo $siteData->urlBasic; ?>/hotel/shoprefund/index">Возврат</a>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-consumable" data-title="Расходники" href="<?php echo $siteData->urlBasic; ?>/hotel/shopconsumable/index">Расходники</a>
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-report" data-title="Отчеты" href="<?php echo $siteData->urlBasic; ?>/hotel/shopreport/index">Отчеты</a>
                        <?php } ?>
                    </div>
                </li>
                <?php } ?>
                <?php if ($siteData->operation->getShopTableRubricID() == 1){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span>Справочники</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-pricelist" data-title="Прайс-листы" href="<?php echo $siteData->urlBasic; ?>/hotel/shoppricelist/index">Прайс-листы</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-feast" data-title="Праздники" href="<?php echo $siteData->urlBasic; ?>/hotel/shopfeast/index">Праздники</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-holiday" data-title="Дни предоплаты" href="<?php echo $siteData->urlBasic; ?>/hotel/shopholiday/index">Дни предоплаты</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-service" data-title="Услуги" href="<?php echo $siteData->urlBasic; ?>/hotel/shopservice/index">Услуги</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-building" data-title="Здания" href="<?php echo $siteData->urlBasic; ?>/hotel/shopbuilding/index">Здания</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-floor" data-title="Этажи" href="<?php echo $siteData->urlBasic; ?>/hotel/shopfloor/index">Этажи</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-room" data-title="Номера" href="<?php echo $siteData->urlBasic; ?>/hotel/shoproom/index">Номера</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-room-type" data-title="Группы номеров" href="<?php echo $siteData->urlBasic; ?>/hotel/shoproomtype/index">Группы номеров</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-operation" data-title="Операторы" href="<?php echo $siteData->urlBasic; ?>/hotel/shopoperation/index">Операторы</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-paid-type" data-title="Способы оплат" href="<?php echo $siteData->urlBasic; ?>/hotel/shoppaidtype/index">Способы оплат</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-cogs"></span>
                        <span>Настройка компании</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-shop" data-title="Данные компании" href="<?php echo $siteData->urlBasic; ?>/hotel/shop/edit">Данные компании</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-pdf" data-title="PDF-шаблоны" href="<?php echo $siteData->urlBasic; ?>/hotel/shoppdf/index">PDF-шаблоны</a>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="ks-column ks-page">
        <div class="ks-header">
            <section class="ks-title" style="padding: 0 15px;">
                <ul id="tab-modals" class="nav ks-nav-tabs ks-tabs-page-default">
                    <li class="nav-item">
                        <?php if($siteData->url == '/hotel/shopclient/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-client">Клиенты</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif($siteData->url == '/hotel/shoppdf/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-pdf">PDF-шаблоны</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shopbill/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-bill">Брони</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shopbill/index_cancel'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-bill-cancel">Отмененные брони</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shopoperation/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-operation">Операторы</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shoppaidtype/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-paid-type">Способы оплат</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shoppayment/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-payment">Оплата</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shopfeast/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-feast">Праздники</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shoppricelist/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-pricelist">Прайс-листы</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shopservice/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-service">Услуги</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shopholiday/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-holiday">Дни предоплаты</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shop/edit'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-shop">Данные компании</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shopconsumable/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-consumable">Расходники</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shopreport/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-report">Отчеты</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shopbillitem/current_entry'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-bill-item-entry">На въезд</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shopbillitem/current_exit'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-bill-item-exit">На выезд</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shopbillitem/current_relax'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-bill-item-relax">Отдыхают</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shoproom/current_free'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-room-free">Свободные номера</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/hotel/shoprefund/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-refund">Возврат</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php } ?>
                    </li>
                </ul>
            </section>
        </div>
        <div class="ks-content">
            <div class="ks-body">
                <div id="body-modals" class="tab-content">
                    <?php if($siteData->url == '/hotel/shopclient/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-client" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shoppdf/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-pdf" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shopbill/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-bill" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shopbill/index_cancel'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-bill-cancel" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shopoperation/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-operation" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shoppaidtype/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-paid-type" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shoppayment/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-payment" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shopfeast/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-feast" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shoppricelist/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-ricelist" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shopservice/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-service" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shopholiday/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-holiday" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shop/edit'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-shop" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shopconsumable/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-consumable" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shopreport/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-report" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shopbillitem/current_entry'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-bill-item-entry" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shopbillitem/current_exit'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-bill-item-exit" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shopbillitem/current_relax'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-bill-item-relax" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shoproom/current_free'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-room-free" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/hotel/shoprefund/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-refund" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jquery-number/jquery.number.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/responsejs/response.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/loading-overlay/loadingoverlay.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/tether/js/tether.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/jscrollpane/jquery.jscrollpane.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/jscrollpane/jquery.mousewheel.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/flexibility/flexibility.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/assets/scripts/common.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/prism/prism.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/jquery-form-validator/jquery.form-validator.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/select2/js/select2.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/bootstrap-table/bootstrap-table.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/table-export/table-export.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/libs/bootstrap-table/locale/bootstrap-table-ru-RU.min.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>

    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jquery-confirm/jquery.confirm.min.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jquery-hotkeys/jquery.hotkeys.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/js/table.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/hotel/js/main.js"></script>

    <div class="ks-mobile-overlay"></div>
</body>
</html>