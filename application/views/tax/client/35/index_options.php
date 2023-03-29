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

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/css/style.css">
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/bloodhound.min.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/typeahead.jquery.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/js/handlebars.js"></script>

    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.css"/>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/tax/css/style.css">
</head>
<!-- END HEAD -->

<body class="ks-navbar-fixed ks-sidebar-default ks-sidebar-fixed ks-theme-primary ks-page-loading">

<!-- BEGIN HEADER -->
<nav class="navbar ks-navbar">
    <!-- BEGIN LOGO -->
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

    <!-- BEGIN MENUS -->
    <div class="ks-wrapper">
        <nav class="nav navbar-nav">
            <div class="ks-navbar-menu"></div>
            <div class="ks-navbar-actions">
                <!-- BEGIN NAVBAR MESSAGES -->
                <div class="nav-item dropdown ks-messages">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-envelope ks-icon" aria-hidden="true">
                            <span class="badge badge-pill badge-info">3</span>
                        </span>
                        <span class="ks-text">Messages</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">
                        <section class="ks-tabs-actions">
                            <a href="#"><i class="fa fa-plus ks-icon"></i></a>
                            <a href="#"><i class="fa fa-search ks-icon"></i></a>
                        </section>
                        <ul class="nav nav-tabs ks-nav-tabs ks-info" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-toggle="tab" data-target="#ks-navbar-messages-inbox" role="tab">Inbox</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="tab" data-target="#ks-navbar-messages-sent" role="tab">Sent</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="tab" data-target="#ks-navbar-messages-archive" role="tab">Archive</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane ks-messages-tab active" id="ks-navbar-messages-inbox" role="tabpanel">
                                <div class="ks-wrapper ks-scrollable">
                                    <a href="#" class="ks-message">
                                        <div class="ks-avatar ks-online">
                                            <img src="assets/img/avatars/avatar-1.jpg" width="36" height="36">
                                        </div>
                                        <div class="ks-info">
                                            <div class="ks-user-name">Emily Carter</div>
                                            <div class="ks-text">In golf, Danny Willett (pictured) wins the M...</div>
                                            <div class="ks-datetime">1 minute ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="ks-message">
                                        <div class="ks-avatar ks-online">
                                            <img src="assets/img/avatars/avatar-5.jpg" width="36" height="36">
                                        </div>
                                        <div class="ks-info">
                                            <div class="ks-user-name">Emily Carter</div>
                                            <div class="ks-text">In golf, Danny Willett (pictured) wins the M...</div>
                                            <div class="ks-datetime">1 minute ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="ks-message">
                                        <div class="ks-avatar ks-offline">
                                            <img src="assets/img/avatars/placeholders/ava-36.png" width="36" height="36">
                                        </div>
                                        <div class="ks-info">
                                            <div class="ks-user-name">Emily Carter</div>
                                            <div class="ks-text">In golf, Danny Willett (pictured) wins the M...</div>
                                            <div class="ks-datetime">1 minute ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="ks-message">
                                        <div class="ks-avatar ks-offline">
                                            <img src="assets/img/avatars/avatar-4.jpg" width="36" height="36">
                                        </div>
                                        <div class="ks-info">
                                            <div class="ks-user-name">Emily Carter</div>
                                            <div class="ks-text">In golf, Danny Willett (pictured) wins the M...</div>
                                            <div class="ks-datetime">1 minute ago</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="ks-view-all">
                                    <a href="#">View all</a>
                                </div>
                            </div>
                            <div class="tab-pane ks-empty" id="ks-navbar-messages-sent" role="tabpanel">
                                There are no messages.
                            </div>
                            <div class="tab-pane ks-empty" id="ks-navbar-messages-archive" role="tabpanel">
                                There are no messages.
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END NAVBAR MESSAGES -->

                <!-- BEGIN NAVBAR NOTIFICATIONS -->
                <div class="nav-item dropdown ks-notifications">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-bell ks-icon" aria-hidden="true">
                            <span class="badge badge-pill badge-info">7</span>
                        </span>
                        <span class="ks-text">Notifications</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">
                        <ul class="nav nav-tabs ks-nav-tabs ks-info" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-toggle="tab" data-target="#navbar-notifications-all" role="tab">All</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="tab" data-target="#navbar-notifications-activity" role="tab">Activity</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="tab" data-target="#navbar-notifications-comments" role="tab">Comments</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane ks-notifications-tab active" id="navbar-notifications-all" role="tabpanel">
                                <div class="ks-wrapper ks-scrollable">
                                    <a href="#" class="ks-notification">
                                        <div class="ks-avatar">
                                            <img src="assets/img/avatars/avatar-3.jpg" width="36" height="36">
                                        </div>
                                        <div class="ks-info">
                                            <div class="ks-user-name">Emily Carter <span class="ks-description">has uploaded 1 file</span></div>
                                            <div class="ks-text"><span class="fa fa-file-text-o ks-icon"></span> logo vector doc</div>
                                            <div class="ks-datetime">1 minute ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="ks-notification">
                                        <div class="ks-action">
                                            <span class="ks-default">
                                                <span class="fa fa-briefcase ks-icon"></span>
                                            </span>
                                        </div>
                                        <div class="ks-info">
                                            <div class="ks-user-name">New project created</div>
                                            <div class="ks-text">Dashboard UI</div>
                                            <div class="ks-datetime">1 minute ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="ks-notification">
                                        <div class="ks-action">
                                            <span class="ks-error">
                                                <span class="fa fa-times-circle ks-icon"></span>
                                            </span>
                                        </div>
                                        <div class="ks-info">
                                            <div class="ks-user-name">File upload error</div>
                                            <div class="ks-text"><span class="fa fa-file-text-o ks-icon"></span> logo vector doc</div>
                                            <div class="ks-datetime">10 minutes ago</div>
                                        </div>
                                    </a>
                                </div>

                                <div class="ks-view-all">
                                    <a href="#">Show more</a>
                                </div>
                            </div>
                            <div class="tab-pane ks-empty" id="navbar-notifications-activity" role="tabpanel">
                                There are no activities.
                            </div>
                            <div class="tab-pane ks-empty" id="navbar-notifications-comments" role="tabpanel">
                                There are no comments.
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END NAVBAR NOTIFICATIONS -->

                <!-- BEGIN NAVBAR USER -->
                <div class="nav-item dropdown ks-user">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-avatar">
                            <img src="assets/img/avatars/avatar-13.jpg" width="36" height="36">
                        </span>
                        <span class="ks-info">
                            <span class="ks-name">Robert Dean</span>
                            <span class="ks-description">Premium User</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">
                        <a class="dropdown-item" href="#">
                            <span class="fa fa-user-circle-o ks-icon"></span>
                            <span>Profile</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <span class="fa fa-wrench ks-icon" aria-hidden="true"></span>
                            <span>Settings</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <span class="fa fa-question-circle ks-icon" aria-hidden="true"></span>
                            <span>Help</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <span class="fa fa-sign-out ks-icon" aria-hidden="true"></span>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
                <!-- END NAVBAR USER -->
            </div>
            <!-- END NAVBAR ACTIONS -->
        </nav>

        <!-- BEGIN NAVBAR ACTIONS TOGGLER -->
        <nav class="nav navbar-nav ks-navbar-actions-toggle">
            <a class="nav-item nav-link" href="#">
                <span class="fa fa-ellipsis-h ks-icon ks-open"></span>
                <span class="fa fa-close ks-icon ks-close"></span>
            </a>
        </nav>
        <!-- END NAVBAR ACTIONS TOGGLER -->

        <!-- BEGIN NAVBAR MENU TOGGLER -->
        <nav class="nav navbar-nav ks-navbar-menu-toggle">
            <a class="nav-item nav-link" href="#">
                <span class="fa fa-th ks-icon ks-open"></span>
                <span class="fa fa-close ks-icon ks-close"></span>
            </a>
        </nav>
        <!-- END NAVBAR MENU TOGGLER -->
    </div>
    <!-- END MENUS -->
    <!-- END HEADER INNER -->
</nav>
<!-- END HEADER -->






<div class="ks-container">

    <!-- BEGIN DEFAULT SIDEBAR -->
    <div class="ks-column ks-sidebar ks-info">
        <div class="ks-wrapper">
            <ul class="nav nav-pills nav-stacked">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span>Документы</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-invoice" data-title="Счета-фактуры" href="<?php echo $siteData->urlBasic; ?>/tax/shopinvoice/index">Счета-фактуры</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-payment-order" data-title="Платежное поручение" href="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentorder/index">Платежное поручение</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span>Отчеты в налоговую</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-tax-return-910" data-title="910 форма" href="<?php echo $siteData->urlBasic; ?>/tax/shoptaxreturn910/index">910 форма</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span>Сотрудники</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-worker-wage" data-title="Зарплаты сотрудников" href="<?php echo $siteData->urlBasic; ?>/tax/shopworkerwage/index">Зарплаты сотрудников</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-worker-wage-month" data-title="Зарплаты по месячно" href="<?php echo $siteData->urlBasic; ?>/tax/shopworkerwagemonth/index">Зарплаты по месячно</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-worker" data-title="Сотрудники" href="<?php echo $siteData->urlBasic; ?>/tax/shopworker/index">Сотрудники</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-person" data-title="Персоны" href="<?php echo $siteData->urlBasic; ?>/tax/shopperson/index">Персоны</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span>Справочники</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-my-attorney" data-title="Мои доверенности" href="<?php echo $siteData->urlBasic; ?>/tax/shopmyattorney/index">Мои доверенности</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-contractor" data-title="Контрагенты" href="<?php echo $siteData->urlBasic; ?>/tax/shopcontractor/index">Контрагенты</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-contract" data-title="Договоры" href="<?php echo $siteData->urlBasic; ?>/tax/shopcontract/index">Договоры</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-attorney" data-title="Доверенности" href="<?php echo $siteData->urlBasic; ?>/tax/shopattorney/index">Доверенности</a>
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-product" data-title="Товары/услуги" href="<?php echo $siteData->urlBasic; ?>/tax/shopproduct/index">Товары/услуги</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-icon fa fa-dashboard"></span>
                        <span>Настройка компании</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-action="add-modal" data-id="tab-shop" data-title="Данные компании" href="<?php echo $siteData->urlBasic; ?>/tax/shop/edit">Данные компании</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="ks-column ks-page">
        <div class="ks-header">
            <section class="ks-title" style="padding: 0 15px;">
                <ul id="tab-modals" class="nav ks-nav-tabs ks-tabs-page-default">
                    <li class="nav-item">
                        <div class="btn-group dropup">
                            <a class="btn btn-primary-outline ks-light" href="#" data-action="tab-open" data-target="#tab-contractor">Контрагенты</a>
                            <a class="btn btn-danger-outline ks-light" href="#" data-action="tab-close"><span class="ks-icon fa fa-remove "></span></a>
                        </div>
                    </li>
                </ul>
            </section>
        </div>

        <div class="ks-content">
            <div class="ks-body">
                <div id="body-modals" class="tab-content">
                    <div class="tab-pane  ks-column-section" id="tab-contractor" role="tabpanel" aria-expanded="false">
                        <?php echo trim($data['view::main']); ?>
                    </div>
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
    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/js/table.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/tax/js/main.js"></script>

    <div class="ks-mobile-overlay"></div>

    <!-- BEGIN SETTINGS BLOCK -->
    <div class="ks-settings-slide-block">
        <a class="ks-settings-slide-control">
            <span class="ks-icon fa fa-cog"></span>
        </a>

        <div class="ks-header">
            <span class="ks-text">Layout Options</span>
            <a class="ks-settings-slide-close-control">
                <span class="ks-icon fa fa-close"></span>
            </a>
        </div>

        <div class="ks-themes-list">
            <a href="../default-primary/index.html" class="ks-theme ks-primary ks-active"></a>
            <a href="../default-primary-dark/index.html" class="ks-theme ks-dark-primary"></a>
            <a href="../default-info/index.html" class="ks-theme ks-info"></a>
            <a href="../default-pink/index.html" class="ks-theme ks-blink-pink-san-marino"></a>
            <a href="../default-bermuda-gray/index.html" class="ks-theme ks-bermuda-gray-malachite"></a>
            <a href="../default-royal-blue/index.html" class="ks-theme ks-royal-blue-orchid"></a>
            <a href="../default-ebony-clay/index.html" class="ks-theme ks-ebony-clay-cerise-red"></a>
            <a href="../default-international-klein-blue/index.html" class="ks-theme ks-international-klein-blue-dixie"></a>
            <a href="../default-jungle-green/index.html" class="ks-theme ks-jungle-green-chambray"></a>
            <a href="../default-voodoo/index.html" class="ks-theme ks-voodoo-medium-purple"></a>
            <a href="../default-cornflower-blue/index.html" class="ks-theme ks-cornflower-blue-ecstasy"></a>
            <a href="../default-purple/index.html" class="ks-theme ks-purple-mandy"></a>
            <a href="../default-oslo-gray/index.html" class="ks-theme ks-oslo-gray-royal-blue"></a>
            <a href="../default-astronaut-blue/index.html" class="ks-theme ks-astronaut-blue-persian-green"></a>
            <a href="../default-old-brick/index.html" class="ks-theme ks-old-brick"></a>
        </div>

        <ul class="ks-settings-list">
            <li>
                <span class="ks-text">Collapsed Sidebar</span>
                <label class="ks-checkbox-slider ks-on-off ks-primary ks-sidebar-checkbox-toggle">
                    <input type="checkbox" value="1">
                    <span class="ks-indicator"></span>
                    <span class="ks-on">On</span>
                    <span class="ks-off">Off</span>
                </label>
            </li>
        </ul>
    </div>
    <!-- END SETTINGS BLOCK -->
</body>
</html>