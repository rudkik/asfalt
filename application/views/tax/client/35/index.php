<!DOCTYPE html>
<html lang="en">

<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8">
    <title><?php echo $siteData->shop->getName(); ?> - кабинет</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/libs/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/assets/fonts/open-sans/styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/libs/tether/css/tether.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/libs/jscrollpane/jquery.jscrollpane.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/libs/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/assets/styles/common.min.css">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/assets/styles/themes/primary.min.css">
    <!-- END THEME STYLES -->

    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/jquery/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/libs/prism/prism.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/assets/styles/libs/bootstrap-notify/bootstrap-notify.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/libs/bootstrap-table/bootstrap-table.min.css"> <!-- Original -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/assets/styles/libs/bootstrap-table/bootstrap-table.min.css"> <!-- Customization -->

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/libs/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/assets/styles/libs/select2/select2.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/libs/bootstrap-daterange-picker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/assets/styles/libs/bootstrap-daterange-picker/daterangepicker.min.css">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/css/style.css">
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/bloodhound.min.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/typeahead.jquery.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/js/handlebars.js"></script>

    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.css"/>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/css/style.css">
</head>
<body class="ks-navbar-fixed ks-sidebar-default ks-sidebar-fixed ks-theme-primary ks-page-loading">
<nav class="navbar ks-navbar">
    <div href="<?php echo $siteData->urlBasic; ?>/tax/site/main" class="navbar-brand">
        <a href="#" class="ks-sidebar-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
        <a href="#" class="ks-sidebar-mobile-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
        <a href="<?php echo $siteData->urlBasic; ?>/tax/site/main" class="ks-logo"><?php echo $siteData->shop->getName(); ?></a>
        <!--<span class="nav-item dropdown ks-dropdown-grid">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>
            <div class="dropdown-menu ks-info ks-scrollable" aria-labelledby="Preview" data-height="260">
                <div class="ks-scroll-wrapper">
                    <a href="#" class="ks-grid-item">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span class="ks-text">Справочники</span>
                    </a>
                </div>
            </div>
        </span> -->
    </div>
    <div class="ks-wrapper">
        <nav class="nav navbar-nav">
            <div class="ks-navbar-menu"></div>
            <div class="ks-navbar-actions">
                <?php
                $accessTypeID = Arr::path($siteData->shop->getOptionsArray(), 'access_type_id',0);
                $diff = Helpers_DateTime::diffDays($siteData->shop->getValidityAt(), date('Y-m-d'));
                if ($siteData->shop->getValidityAt() !== NULL){
                ?>
                <div class="nav-item dropdown ks-user">
                    <span class="nav-item nav-link" style="text-align: center">
                        Подписка до: <?php echo Helpers_DateTime::getDateFormatRus($siteData->shop->getValidityAt()); ?>
                        <br>
                        <?php
                        if($diff < 1){
                            $accessTypeID = -1;
                        }elseif(($accessTypeID === 0) && ($diff > 7)){
                            $accessTypeID = Api_Tax_Access::ACCESS_VIP;
                        }
                        switch ($accessTypeID){
                            case Api_Tax_Access::ACCESS_PREMIUM:
                                echo 'Премиум пакет';
                                break;
                            case Api_Tax_Access::ACCESS_PREMIUM:
                                echo 'Старт пакет';
                                break;
                            case Api_Tax_Access::ACCESS_VIP:
                                echo 'Вип пакет';
                                break;
                            case -1:
                                echo 'Доступ закрыт';
                                break;
                            default:
                                echo 'Тестовый период';
                        }
                        ?>
                    </span>
                </div>
                <?php } ?>
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
                    <a class="nav-item nav-link" href="<?php echo $siteData->urlBasic; ?>/tax/shopuser/unlogin">
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
                    <a class="nav-link" data-title="Главная" data-id="tab-main" href="<?php echo $siteData->urlBasic; ?>/tax/site/main" role="button" aria-expanded="false">
                        <span class="ks-icon fa fa-briefcase "></span>
                        <span>Главная</span>
                    </a>
                </li>
                <?php if (($accessTypeID !== -1)){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-bars"></span>
                        <span>Документы</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-invoice-proforma" data-title="Счета на оплату" href="<?php echo $siteData->urlBasic; ?>/tax/shopinvoiceproforma/index">Счета на оплату</a>

                        <a class="dropdown-item" data-action="add-modal" data-id="tab-invoice-сommercial" data-title="Счета-фактуры реализации" href="<?php echo $siteData->urlBasic; ?>/tax/shopinvoicecommercial/index">Счета-фактуры реализации</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-attorney" data-title="Доверенности клиентов" href="<?php echo $siteData->urlBasic; ?>/tax/shopattorney/index">Доверенности клиентов</a>

                        <a class="dropdown-item" data-action="add-modal" data-id="tab-my-invoice" data-title="Счета-фактуры поступления" href="<?php echo $siteData->urlBasic; ?>/tax/shopmyinvoice/index">Счета-фактуры поступления</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-my-attorney" data-title="Мои доверенности" href="<?php echo $siteData->urlBasic; ?>/tax/shopmyattorney/index">Мои доверенности</a>

                        <a class="dropdown-item" data-action="add-modal" data-id="tab-act-revise" data-title="Акты сверки" href="<?php echo $siteData->urlBasic; ?>/tax/shopactrevise/index">Акты сверки</a>

                        <a class="dropdown-item" data-action="add-modal" data-id="tab-contract" data-title="Договоры" href="<?php echo $siteData->urlBasic; ?>/tax/shopcontract/index">Договоры</a>
                    </div>
                </li>
                <?php } ?>
                <?php if (($accessTypeID !== -1)){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-university"></span>
                        <span>Банк</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-payment-order" data-title="Платежное поручение исходящие" href="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentorder/index?is_cash=0&is_coming=0">Платежное поручение исходящие</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-money-cash-0-coming-1" data-title="Платежное поручение входящие" href="<?php echo $siteData->urlBasic; ?>/tax/shopmoney/index?is_cash=0&is_coming=1">Платежное поручение входящие</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-money" data-title="Денежные операции" href="<?php echo $siteData->urlBasic; ?>/tax/shopmoney/index">Денежные операции</a>
                    </div>
                </li>
                <?php } ?>
                <?php if (($accessTypeID !== -1)){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-money"></span>
                        <span>Касса</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-money-cash-1-coming-0" data-title="Расход" href="<?php echo $siteData->urlBasic; ?>/tax/shopmoney/index?is_cash=1&is_coming=0">Расход</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-money-cash-1-coming-1" data-title="Приход" href="<?php echo $siteData->urlBasic; ?>/tax/shopmoney/index?is_cash=1&is_coming=1">Приход</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-money" data-title="Денежные операции" href="<?php echo $siteData->urlBasic; ?>/tax/shopmoney/index">Денежные операции</a>
                    </div>
                </li>
                <?php } ?>
                <?php if (($accessTypeID !== -1)){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-handshake-o"></span>
                        <span>Зарплата</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-worker-wage" data-title="Зарплаты сотрудников" href="<?php echo $siteData->urlBasic; ?>/tax/shopworkerwage/index">Зарплаты сотрудников</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-worker-wage-month" data-title="Зарплаты по месячно" href="<?php echo $siteData->urlBasic; ?>/tax/shopworkerwagemonth/index">Зарплаты по месячно</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-work-time" data-title="Табель учета времени" href="<?php echo $siteData->urlBasic; ?>/tax/shopworktime/index">Табель учета времени</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-worker" data-title="Сотрудники" href="<?php echo $siteData->urlBasic; ?>/tax/shopworker/index">Сотрудники</a>

                    </div>
                </li>
                <?php } ?>
                <?php if (($accessTypeID > 0)){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-database"></span>
                        <span>Налоги</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-tax-return-910" data-title="910 форма" href="<?php echo $siteData->urlBasic; ?>/tax/shoptaxreturn910/index">910 форма</a>
                    </div>
                </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-cog"></span>
                        <span>Справочники</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-contractor" data-title="Контрагенты" href="<?php echo $siteData->urlBasic; ?>/tax/shopcontractor/index">Контрагенты</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-product" data-title="Товары/услуги" href="<?php echo $siteData->urlBasic; ?>/tax/shopproduct/index">Товары/услуги</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-bank-account" data-title="Банковские счета" href="<?php echo $siteData->urlBasic; ?>/tax/shopbankaccount/index">Банковские счета</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-cogs"></span>
                        <span>Настройка компании</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-shop" data-title="Данные компании" href="<?php echo $siteData->urlBasic; ?>/tax/shop/edit">Данные компании</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-ecp" data-title="ЭЦП для сдачи отчетностей" href="<?php echo $siteData->urlBasic; ?>/tax/shopecp/edit">ЭЦП для сдачи отчетностей</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-credit-card-alt"></span>
                        <span>Подписка (абоненская плата)</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-site-access" data-title="Подписка" href="<?php echo $siteData->urlBasic; ?>/tax/site/access">Подписка</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-bill" data-title="Платежи" href="<?php echo $siteData->urlBasic; ?>/tax/shopbill/index">Платежи</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-payment-book" data-title="История баланса" href="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentbook/index">История баланса</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-site-referral" data-title="Реферальная ссылка" href="<?php echo $siteData->urlBasic; ?>/tax/site/referral">Реферальная ссылка</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-shop-referral" data-title="Подписанные партнеры" href="<?php echo $siteData->urlBasic; ?>/tax/shop/referral">Подписанные партнеры</a>
                    </div>
                </li>
                <?php if (($siteData->shopID == $siteData->shopMainID)){ ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="ks-icon fa fa-database"></span>
                            <span>Компании</span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" data-action="add-modal" data-id="tab-branch" data-title="Компании" href="<?php echo $siteData->urlBasic; ?>/tax/shopbranch/index">Компании</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="my-pages ks-column ks-page">
        <div class="ks-header"style="width: 100%;">
            <section class="ks-title" style="padding: 0 15px;">
                <ul id="tab-modals" class="nav ks-nav-tabs ks-tabs-page-default">
                    <li class="nav-item">
                        <?php if($siteData->url == '/tax/shopworkerwage/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-worker-wage">Зарплаты сотрудников</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopcalendar/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-calendar">Производственный календарь</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shoptaxreturn910/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-tax-return-910">910 форма</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shoptaxreturn200/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-tax-return-200">200 форма</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shoppaymentorder/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-payment-order">Платежное поручение</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopmyinvoice/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-my-invoice">Счета-фактуры поступления</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopinvoicecommercial/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-invoice-сommercial">Счета-фактуры реализации</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopinvoiceproforma/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-invoice-proforma">Счета на оплату</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopcontractor/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-contractor">Контрагенты</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopbankaccount/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-bank-account">Банковские счета</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopmyattorney/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-my-attorney">Мои доверенности</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopworker/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-worker">Сотрудники</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopworkerwagemonth/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-worker-wage-month">Зарплаты по месячно</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopworktime/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-work-time">Табель учета времени</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopecp/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-ecp">ЭЦП для сдачи отчетностей</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shop/edit'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-shop">Данные компании</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopproduct/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-product">Товары/услуги</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopattorney/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-attorney">Доверенности</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopcontract/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-contract">Договоры</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopmoney/index'){ ?>
                        <?php
                            $isCash = Request_RequestParams::getParamBoolean('is_cash');
                            $isComing = Request_RequestParams::getParamBoolean('is_coming');
                            if (($isCash === FALSE) && ($isComing === TRUE)){ ?>
                                <div class="btn-group dropup">
                                    <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-money-cash-0-coming-1">Безналичные приход</a>
                                    <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                                </div>
                            <?php }elseif (($isCash === TRUE) && ($isComing === TRUE)){ ?>
                                <div class="btn-group dropup">
                                    <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-money-cash-1-coming-1">Наличные приход</a>
                                    <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                                </div>
                            <?php }elseif (($isCash === TRUE) && ($isComing === FALSE)){ ?>
                                <div class="btn-group dropup">
                                    <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-money-cash-1-coming-0">Наличные расход</a>
                                    <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                                </div>
                            <?php }elseif (($isCash === NULL) && ($isComing === NULL)){ ?>
                                <div class="btn-group dropup">
                                    <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-money">Денежные операции</a>
                                    <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                                </div>
                            <?php } ?>
                        <?php }elseif ($siteData->url == '/tax/site/access'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-site-access">Подписка</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/site/pays'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-site-pays">Способ оплаты</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopbill/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-bill">Платежи</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopactrevise/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-act-revise">Акты сверки</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shoppaymentbook/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-payment-book">История баланса</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/site/main'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-site-main">Главная</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shop/referral'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-shop-referral">Подписанные партнеры</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/site/referral'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-site-referral">Реферальная ссылка</a>
                                <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                            </div>
                        <?php }elseif ($siteData->url == '/tax/shopbranch/index'){ ?>
                            <div class="btn-group dropup">
                                <a class="btn btn-primary-outline ks-light active" href="#" data-action="tab-open" data-target="#tab-branch">Компании</a>
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
                    <?php if($siteData->url == '/tax/shopecp/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-ecp" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shop/edit'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-shop" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopproduct/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-product" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopattorney/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-attorney" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopcontract/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-contract" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopcontractor/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-contractor" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopbankaccount/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-bank-account" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopmyattorney/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-my-attorney" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopworker/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-worker" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopworkerwagemonth/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-worker-wage-month" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopworktime/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-work-time" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopworkerwage/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-worker-wage" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopcalendar/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-calendar" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shoptaxreturn910/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-tax-return-910" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shoptaxreturn200/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-tax-return-200" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shoppaymentorder/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-payment-order" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopmyinvoice/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-my-invoice" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopinvoicecommercial/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-invoice-commercial" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopinvoiceproforma/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-invoice-proforma" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif ($siteData->url == '/tax/shopmoney/index'){ ?>
                        <?php
                        $isCash = Request_RequestParams::getParamBoolean('is_cash');
                        $isComing = Request_RequestParams::getParamBoolean('is_coming');
                        if (($isCash === FALSE) && ($isComing === TRUE)){ ?>
                            <div class="tab-pane ks-column-section active" id="tab-money-cash-0-coming-1" role="tabpanel" aria-expanded="false">
                                <?php echo trim($data['view::main']); ?>
                            </div>
                        <?php }elseif (($isCash === TRUE) && ($isComing === TRUE)){ ?>
                            <div class="tab-pane ks-column-section active" id="tab-money-cash-1-coming-1" role="tabpanel" aria-expanded="false">
                                <?php echo trim($data['view::main']); ?>
                            </div>
                        <?php }elseif (($isCash === TRUE) && ($isComing === FALSE)){ ?>
                            <div class="tab-pane ks-column-section active" id="tab-money-cash-1-coming-0" role="tabpanel" aria-expanded="false">
                                <?php echo trim($data['view::main']); ?>
                            </div>
                        <?php }elseif (($isCash === NULL) && ($isComing === NULL)){ ?>
                            <div class="tab-pane ks-column-section active" id="tab-money" role="tabpanel" aria-expanded="false">
                                <?php echo trim($data['view::main']); ?>
                            </div>
                        <?php } ?>
                    <?php }elseif($siteData->url == '/tax/site/access'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-site-access" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/site/pays'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-site-pays" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopbill/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-bill" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopactrevise/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-act-revise" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shoppaymentbook/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-payment-book" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/site/main'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-site-main" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shop/referral'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-shop-referral" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/site/referral'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-site-referral" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>
                    <?php }elseif($siteData->url == '/tax/shopbranch/index'){ ?>
                        <div class="tab-pane ks-column-section active" id="tab-branch" role="tabpanel" aria-expanded="false">
                            <?php echo trim($data['view::main']); ?>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jquery-number/jquery.number.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/responsejs/response.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/loading-overlay/loadingoverlay.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/tether/js/tether.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/jscrollpane/jquery.jscrollpane.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/jscrollpane/jquery.mousewheel.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/flexibility/flexibility.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/assets/scripts/common.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/prism/prism.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/jquery-form-validator/jquery.form-validator.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/select2/js/select2.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/bootstrap-table/bootstrap-table.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/table-export/table-export.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/bootstrap-table/locale/bootstrap-table-ru-RU.min.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/momentjs/moment-with-locales.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/libs/bootstrap-daterange-picker/daterangepicker.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/js/table.js?cache=1"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/js/main.js"></script>

    <div class="ks-mobile-overlay"></div>
</body>
</html>