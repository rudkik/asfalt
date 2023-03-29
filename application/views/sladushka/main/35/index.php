<!DOCTYPE html>
<html lang="en">

<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8">
    <title><?php echo $siteData->shop->getName(); ?> - кабинет</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/assets/fonts/open-sans/styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/tether/css/tether.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/jscrollpane/jquery.jscrollpane.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/assets/styles/common.min.css">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/assets/styles/themes/primary.min.css">
    <!-- END THEME STYLES -->

    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/jquery/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/prism/prism.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/assets/styles/libs/bootstrap-notify/bootstrap-notify.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/bootstrap-table/bootstrap-table.min.css"> <!-- Original -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/assets/styles/libs/bootstrap-table/bootstrap-table.min.css"> <!-- Customization -->

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/assets/styles/libs/select2/select2.min.css">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/css/style.css">
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/bloodhound.min.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/typeahead.jquery.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/js/handlebars.js"></script>

    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.css"/>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/sladushka/css/style.css">
</head>
<body class="ks-navbar-fixed ks-sidebar-default ks-sidebar-fixed ks-theme-primary ks-page-loading">
<nav class="navbar ks-navbar">
    <div href="<?php echo $siteData->urlBasic; ?>/sladushka" class="navbar-brand">
        <a href="#" class="ks-sidebar-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
        <a href="#" class="ks-sidebar-mobile-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
        <a href="<?php echo $siteData->urlBasic; ?>/sladushka" class="ks-logo"><?php echo $siteData->shop->getName(); ?></a>
    </div>
    <div class="ks-wrapper">
        <nav class="nav navbar-nav">
            <div class="ks-navbar-menu"></div>
            <div class="ks-navbar-actions"></div>
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
                        <span class="ks-icon fa fa-briefcase "></span>
                        <span>Главная</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-worker-good" data-title="Заявки" href="<?php echo $siteData->urlBasic; ?>/sladushka/shopworkergood/index">Заявки</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-cog"></span>
                        <span>Справочники</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-worker" data-title="Сотрудники" href="<?php echo $siteData->urlBasic; ?>/sladushka/shopworker/index">Сотрудники</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-operation" data-title="Пользователи" href="<?php echo $siteData->urlBasic; ?>/sladushka/shopoperation/index">Пользователи</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-good" data-title="Продукция" href="<?php echo $siteData->urlBasic; ?>/sladushka/shopgood/index">Продукция</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="my-pages ks-column ks-page">
        <div class="ks-header">
            <section class="ks-title" style="padding: 0 15px;">
                <ul id="tab-modals" class="nav ks-nav-tabs ks-tabs-page-default">
                    <li class="nav-item">
                        <?php if($siteData->url == '/sladushka/shopgood/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-good">Продукция</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif($siteData->url == '/sladushka/shopoperation/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-operation">Пользователи</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif($siteData->url == '/sladushka/shopworker/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-worker">Сотрудники</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif($siteData->url == '/sladushka/shopworkergood/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-worker-good">Заявки</a>
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
                    <?php if($siteData->url == '/sladushka/shopgood/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-good" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/sladushka/shopoperation/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-operation" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/sladushka/shopworkern/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-worker" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/sladushka/shopworkergood/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-worker-good" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jquery-number/jquery.number.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/responsejs/response.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/loading-overlay/loadingoverlay.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/tether/js/tether.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/jscrollpane/jquery.jscrollpane.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/jscrollpane/jquery.mousewheel.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/flexibility/flexibility.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/assets/scripts/common.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/prism/prism.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/jquery-form-validator/jquery.form-validator.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/select2/js/select2.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/bootstrap-table/bootstrap-table.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/table-export/table-export.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/libs/bootstrap-table/locale/bootstrap-table-ru-RU.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/js/table.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/sladushka/js/main.js"></script>

    <div class="ks-mobile-overlay"></div>
</body>
</html>