<!DOCTYPE html>
<html lang="en">

<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8">
    <title><?php echo $siteData->shop->getName(); ?> - кабинет</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/libs/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/pages/flag-icon/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/pages/menu-search/css/component.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/pages/dashboard/horizontal-timeline/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/pages/dashboard/amchart/css/amchart.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/pages/flag-icon/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/libs/bootstrap-table/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/assets/styles/libs/bootstrap-table/bootstrap-table.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/libs/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/assets/styles/libs/select2/select2.min.css">

    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.css"/>

    <script src="<?php echo $siteData->urlBasic; ?>/css/pyramid/libs/jquery/jquery.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/admin-panel/server/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/css/style.css?cache=2">
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
                <img class="img-fluid" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/img/logo.png" alt="Александр Губенко" />
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
                    <li class="header-notification lng-dropdown">
                        <a href="#" id="dropdown-active-item">
                            <i class="flag-icon flag-icon-ru m-r-5"></i> Русский
                        </a>
                        <ul class="show-notification">
                            <li>
                                <a href="#" data-lng="en">
                                    <i class="flag-icon flag-icon-ru m-r-5"></i> Русский
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="header-notification">
                        <a href="#!">
                            <i class="ti-bell"></i>
                            <span class="badge">5</span>
                        </a>
                        <ul class="show-notification">
                            <li>
                                <h6>Notifications</h6>
                                <label class="label label-danger">New</label>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="d-flex align-self-center" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/img/user.png" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <h5 class="notification-user">John Doe</h5>
                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                        <span class="notification-time">30 minutes ago</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="d-flex align-self-center" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/img/user.png" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <h5 class="notification-user">Joseph William</h5>
                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                        <span class="notification-time">30 minutes ago</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="d-flex align-self-center" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/img/user.png" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <h5 class="notification-user">Sara Soudein</h5>
                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                        <span class="notification-time">30 minutes ago</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="user-profile header-notification">
                        <a href="#!">
                            <img src="<?php echo $siteData->urlBasic; ?>/css/pyramid/img/user.png" alt="Пользователь">
                            <span><?php echo $siteData->operation->getName(); ?></span>
                            <i class="ti-angle-down"></i>
                        </a>
                        <ul class="show-notification profile-notification">
                            <li>
                                <a href="<?php echo $siteData->urlBasic; ?>/pyramid/shopuser/unlogin">
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
    <div class="main-menu-header">
        <img class="img-40" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/img/user.png" alt="User-Profile-Image">
        <div class="user-details">
            <span><?php echo $siteData->operation->getName(); ?></span>
            <span id="more-details">Пользователь<i class="ti-angle-down"></i></span>
        </div>
    </div>
    <div class="main-menu-content">
        <ul class="main-navigation">
            <li class="more-details">
                <a href="<?php echo $siteData->urlBasic; ?>/pyramid/shopuser/unlogin"><i class="ti-layout-sidebar-left"></i>Выход</a>
            </li>
            <li class="nav-item has-class">
                <a href="#!">
                    <i class="ti-volume"></i>
                    <span data-i18n="nav.dash.main">Мои тренинги</span>
                </a>
                <ul class="tree-1 has-class">
                    <?php echo trim($siteData->globalDatas['view::_shop/payment/list/menu-product']); ?>
                </ul>
            </li>
            <li class="nav-item single-item">
                <a href="/pyramid/shoppayment/index">
                    <i class="ti-user"></i>
                    <span data-i18n="nav.animations.main"> Оплаты за тренинги</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#!">
                    <i class="ti-money"></i>
                    <span data-i18n="nav.dash.main">Мой заработок</span>
                </a>
                <ul class="tree-1">
                    <li><a href="/pyramid/shopclient/index" data-i18n="nav.dash.default"> Моя струтура</a></li><li>
                    <li><a href="/pyramid/shopcoming/index" data-i18n="nav.dash.ecommerce"> Прирост денег</a></li>
                    <li><a href="/pyramid/shopexpense/index" data-i18n="nav.dash.crm">Вывод денег</a></li>
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

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/jquery-ui/jquery-ui.min.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/pyramid/libs/bootstrap-table/bootstrap-table.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/pyramid/libs/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/pyramid/libs/table-export/table-export.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/pyramid/libs/bootstrap-table/locale/bootstrap-table-ru-RU.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/pyramid/js/table.js"></script>


<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/tether/dist/js/tether.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/bootstrap/dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/jquery-slimscroll/jquery.slimscroll.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/modernizr/modernizr.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/modernizr/feature-detects/css-scrollbars.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/classie/classie.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/d3/d3.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/rickshaw/rickshaw.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/raphael/raphael.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/morris.js/morris.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/pages/dashboard/horizontal-timeline/js/main.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/pages/dashboard/amchart/js/amcharts.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/pages/dashboard/amchart/js/serial.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/pages/dashboard/amchart/js/light.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/pages/dashboard/amchart/js/custom-amchart.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/i18next/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/components/jquery-i18next/jquery-i18next.min.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/pages/dashboard/custom-dashboard.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/pyramid/new/assets/js/script.js"></script>


</body>

</html>