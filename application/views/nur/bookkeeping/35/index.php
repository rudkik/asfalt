<!DOCTYPE html>
<html lang="en">

<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8">
    <title><?php echo $siteData->shop->getName(); ?> - кабинет</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/libs/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/pages/flag-icon/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/pages/menu-search/css/component.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/pages/dashboard/horizontal-timeline/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/pages/dashboard/amchart/css/amchart.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/pages/flag-icon/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/libs/bootstrap-table/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/assets/styles/libs/bootstrap-table/bootstrap-table.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/libs/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/assets/styles/libs/select2/select2.min.css">

    <script src="<?php echo $siteData->urlBasic; ?>/css/nur/libs/jquery/jquery.min.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bookkeeping-panel/server/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/jquery-ui/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/select2/dist/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/multiselect/css/multi-select.css" />
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>

    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.css"/>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/nur/css/style.css?cache=4">
</head>

<body class="menu-static">
<nav class="navbar header-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="ti-menu"></i>
            </a>
            <a class="mobile-search morphsearch-search" href="#">
                <i class="ti-search"></i>
            </a>
            <a href="index.html">
                <img class="img-fluid" src="<?php echo $siteData->urlBasic; ?>/css/nur/img/logo.png" alt="Александр Губенко" />
            </a>
            <a class="mobile-options">
                <i class="ti-more"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <div>
                <ul class="nav-left">
                    <li>
                        <a id="collapse-menu" href="#">
                            <i class="ti-menu"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#!" onclick="javascript:toggleFullScreen()">
                            <i class="ti-fullscreen"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav-right">
                    <li class="user-profile header-notification">
                        <a href="#!">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/nur/img/user.png" alt="Пользователь">
                            <span><?php echo $siteData->operation->getName(); ?></span>
                            <i class="ti-angle-down"></i>
                        </a>
                        <ul class="show-notification profile-notification">
                            <li>
                                <a href="<?php echo $siteData->urlBasic; ?>/nur-bookkeeping/shopuser/unlogin">
                                    <i class="ti-layout-sidebar-left"></i> Выход
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="main-menu">
    <div class="main-menu-content">
        <ul class="main-navigation">
            <li class="nav-item single-item <?php if(strpos($siteData->url, '/nur-bookkeeping/shopbranch/') !== FALSE){echo 'has-class';} ?>">
                <a href="/nur-bookkeeping/shopbranch/index">
                    <i class="ti-user"></i>
                    <span data-i18n="nav.animations.main">Клиенты</span>
                </a>
            </li>
            <li class="nav-item has-class">
                <a href="#!" style="background: none">
                    <i class="ti-money"></i>
                    <span data-i18n="nav.dash.main">Задачи</span>
                </a>
                <ul class="tree-1">
                    <li class="nav-item single-item <?php if(strpos($siteData->url, '/nur-bookkeeping/shoptaskcurrent/run') !== FALSE){echo 'has-class';} ?>"><a href="/nur-bookkeeping/shoptaskcurrent/run" data-i18n="nav.dash.default"> Выполняются</a></li><li>
                    <li class="nav-item single-item <?php if((strpos($siteData->url, '/nur-bookkeeping/shoptaskcurrent/new') !== FALSE) && (Request_RequestParams::getParamStr('period') == 'day')){echo 'has-class';} ?>"><a href="/nur-bookkeeping/shoptaskcurrent/new?period=day" data-i18n="nav.dash.default"> Новые на три дня</a></li><li>
                    <li class="nav-item single-item <?php if((strpos($siteData->url, '/nur-bookkeeping/shoptaskcurrent/new') !== FALSE) && (Request_RequestParams::getParamStr('period') == 'week')){echo 'has-class';} ?>"><a href="/nur-bookkeeping/shoptaskcurrent/new?period=week" data-i18n="nav.dash.ecommerce"> Новые на одну неделю</a></li>
                    <li class="nav-item single-item <?php if((strpos($siteData->url, '/nur-bookkeeping/shoptaskcurrent/new') !== FALSE) && (Request_RequestParams::getParamStr('period') == 'month')){echo 'has-class';} ?>"><a href="/nur-bookkeeping/shoptaskcurrent/new?period=month" data-i18n="nav.dash.crm"> Новые на один месяц</a></li>
                    <li class="nav-item single-item <?php if(strpos($siteData->url, '/nur-bookkeeping/shoptaskcurrent/index') !== FALSE){echo 'has-class';} ?>"><a href="/nur-bookkeeping/shoptaskcurrent/index" data-i18n="nav.dash.default"> Выполненные</a></li><li>
                    <li class="nav-item single-item <?php if(strpos($siteData->url, '/nur-bookkeeping/shoptaskcurrent/calendar') !== FALSE){echo 'has-class';} ?>"><a href="/nur-bookkeeping/shoptaskcurrent/calendar" data-i18n="nav.dash.default"> Календарь</a></li><li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<div class="main-body">
    <div class="page-wrapper">
        <?php echo trim($data['view::main']); ?>
    </div>
</div>



<script src="<?php echo $siteData->urlBasic; ?>/css/nur/libs/bootstrap-table/bootstrap-table.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/nur/libs/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/nur/libs/table-export/table-export.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/nur/libs/bootstrap-table/locale/bootstrap-table-ru-RU.min.js"></script>



<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/tether/dist/js/tether.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/bootstrap/dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/jquery-slimscroll/jquery.slimscroll.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/modernizr/modernizr.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/modernizr/feature-detects/css-scrollbars.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/classie/classie.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/d3/d3.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/raphael/raphael.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/morris.js/morris.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/pages/dashboard/horizontal-timeline/js/main.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/pages/dashboard/amchart/js/amcharts.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/pages/dashboard/amchart/js/serial.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/pages/dashboard/amchart/js/light.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/pages/dashboard/amchart/js/custom-amchart.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/i18next/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/components/jquery-i18next/jquery-i18next.min.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/nur/new/assets/js/script.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/_component/basic.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/nur/js/table.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/nur/js/main.js"></script>

</body>

</html>