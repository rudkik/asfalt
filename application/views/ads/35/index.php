<!DOCTYPE html>
<html lang="en">

<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8">
    <title><?php echo $siteData->shop->getName(); ?> - кабинет</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/assets/fonts/open-sans/styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/tether/css/tether.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/jscrollpane/jquery.jscrollpane.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/assets/styles/common.min.css">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/assets/styles/themes/primary.min.css">
    <!-- END THEME STYLES -->

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/jquery-2.1.4.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/prism/prism.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/assets/styles/libs/bootstrap-notify/bootstrap-notify.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/bootstrap-table/bootstrap-table.min.css"> <!-- Original -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/assets/styles/libs/bootstrap-table/bootstrap-table.min.css"> <!-- Customization -->

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/assets/styles/libs/select2/select2.min.css">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/css/style.css">
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/bloodhound.min.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/typeahead.jquery.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/js/handlebars.js"></script>

    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.css"/>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/admin-panel/server/jquery-ui.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/adsgs/css/style.css">
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
                    <a class="nav-item nav-link" href="<?php echo $siteData->urlBasic; ?>/ads/shopuser/unlogin">
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span>Посылки</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-parcel" data-title="Посылки" href="<?php echo $siteData->urlBasic; ?>/ads/shopparcel/index">Посылки</a>
                        <?php if ($siteData->operation->getShopTableRubricID() != 2){ ?>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-client" data-title="Клиенты" href="<?php echo $siteData->urlBasic; ?>/ads/shopclient/index">Клиенты</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-invoice" data-title="Счета" href="<?php echo $siteData->urlBasic; ?>/ads/shopinvoice/index">Счета</a>
                        <?php } ?>
                    </div>
                </li>
                <?php if ($siteData->operation->getShopTableRubricID() == 1){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span>Справочники</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-shop" data-title="Стоимость доставки" href="<?php echo $siteData->urlBasic; ?>/ads/shop/edit">Стоимость доставки</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-operation" data-title="Операторы" href="<?php echo $siteData->urlBasic; ?>/ads/shopoperation/index">Операторы</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-city" data-title="Города" href="<?php echo $siteData->urlBasic; ?>/ads/city/index">Города</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-region" data-title="Области" href="<?php echo $siteData->urlBasic; ?>/ads/region/index">Области</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-land" data-title="Страны" href="<?php echo $siteData->urlBasic; ?>/ads/land/index">Страны</a>
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
                        <?php if($siteData->url == '/ads/shopclient/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-client">Клиенты</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/ads/shopparcel/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-parcel">Посылки</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/ads/shopoperation/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-operation">Оператор</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/ads/shopinvoice/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-invoice">Счета</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/ads/land/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-land">Страны</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/ads/region/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-region">Области</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/ads/city/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-city">Города</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/ads/shop/edit'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-shop">Стоимость доставки</a>
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
                    <?php if($siteData->url == '/ads/shopclient/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-client" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/ads/shopparcel/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-parcel" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/ads/shopoperation/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-operation" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/ads/shopinvoice/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-invoice" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/ads/land/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-land" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/ads/region/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-region" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/ads/city/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-city" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/ads/shop/edit'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-shop" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jquery-number/jquery.number.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/responsejs/response.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/loading-overlay/loadingoverlay.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/tether/js/tether.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/jscrollpane/jquery.jscrollpane.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/jscrollpane/jquery.mousewheel.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/flexibility/flexibility.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/assets/scripts/common.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/prism/prism.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/jquery-form-validator/jquery.form-validator.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/select2/js/select2.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/bootstrap-table/bootstrap-table.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/table-export/table-export.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/libs/bootstrap-table/locale/bootstrap-table-ru-RU.min.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>


    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jquery-confirm/jquery.confirm.min.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jquery-hotkeys/jquery.hotkeys.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/js/table.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/adsgs/js/main.js"></script>

    <div class="ks-mobile-overlay"></div>
</body>
</html>