<!DOCTYPE html>
<html lang="en">
<head>
    <?php if($siteData->shopID > 0){ ?>
        <title><?php echo $siteData->shop->getName(); ?> - кабинет</title>
    <?php }else{ ?>
        <title>Кабинет компании</title>
    <?php } ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
    <link rel="shortcut icon" href="<?php echo $siteData->urlBasic; ?>/images/icons/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo $siteData->urlBasic; ?>/images/icons/favicon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $siteData->urlBasic; ?>/images/icons/favicon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $siteData->urlBasic; ?>/images/icons/favicon-114x114.png">
    <!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet"
          href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/bootstrap/css/bootstrap.min.css">
    <!--LOADING STYLESHEET FOR PAGE-->
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/intro.js/introjs.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/calendar/zabuto_calendar.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/sco.message/sco.message.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/intro.js/introjs.css">
    <!--Loading style vendors-->
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/animate.css/animate.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/jquery-pace/pace.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/iCheck/skins/all.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/jquery-notific8/jquery.notific8.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/bootstrap-daterangepicker/daterangepicker-bs3.css">
    <!--Loading style-->
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/css/themes/style1/orange-blue.css" class="default-style">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/css/themes/style1/orange-blue.css" id="theme-change" class="style-change color-change">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/css/style-responsive.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/vendors/DataTables/media/css/jquery.dataTables.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">

    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/config/css/style.css">

    <script src="<?php echo $siteData->urlBasic; ?>/css/config/js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/config/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/config/js/jquery-ui.js"></script>
    <!--loading bootstrap js-->
    <script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js"></script>
</head>
<body class=" ">
<div>
    <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
    <div id="header-topbar-option-demo" class="page-header-topbar">
        <nav id="topbar" role="navigation" style="margin-bottom: 0; z-index: 2;"
             class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span>
                    <span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
                <a id="logo" href="<?php echo $siteData->urlBasic; ?>/market" class="navbar-brand">
                    <span class="fa fa-rocket"></span>
                    <span class="logo-text"><?php echo Func::trimTextNew($siteData->shop->getName(), 20, FALSE); ?></span>
                    <span style="display: none" class="logo-text-icon"><?php echo Func::trimTextNew($siteData->shop->getName(), 2, FALSE); ?></span>
                </a>
            </div>
            <div class="topbar-main">
                <a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.html">Dashboard</a></li>
                    <li><a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle">Layouts
                            &nbsp;<i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="layout-left-sidebar.html">Left Sidebar</a></li>
                            <li><a href="layout-right-sidebar.html">Right Sidebar</a></li>
                            <li><a href="layout-left-sidebar-collapsed.html">Left Sidebar Collasped</a></li>
                            <li><a href="layout-right-sidebar-collapsed.html">Right Sidebar Collasped</a></li>
                            <li class="dropdown-submenu"><a href="javascript:;" data-toggle="dropdown"
                                                            class="dropdown-toggle">More Options</a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Second level link</a></li>
                                    <li class="dropdown-submenu"><a href="javascript:;" data-toggle="dropdown"
                                                                    class="dropdown-toggle">More Options</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Third level link</a></li>
                                            <li><a href="#">Third level link</a></li>
                                            <li><a href="#">Third level link</a></li>
                                            <li><a href="#">Third level link</a></li>
                                            <li><a href="#">Third level link</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Second level link</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="mega-menu-dropdown"><a href="javascript:;" data-toggle="dropdown"
                                                      class="dropdown-toggle">UI Elements
                            &nbsp;<i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="mega-menu-content">
                                    <div class="row">
                                        <ul class="col-md-4 mega-menu-submenu">
                                            <li><h3>Neque porro quisquam</h3></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Lorem ipsum dolor sit amet</a>
                                            </li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Consectetur adipisicing
                                                    elit</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Sed ut perspiciatis unde
                                                    omnis</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>At vero eos et accusamus et
                                                    iusto</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Nam libero tempore cum
                                                    soluta</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Et harum quidem rerum
                                                    facilis est</a></li>
                                        </ul>
                                        <ul class="col-md-4 mega-menu-submenu">
                                            <li><h3>Neque porro quisquam</h3></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Lorem ipsum dolor sit amet</a>
                                            </li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Consectetur adipisicing
                                                    elit</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Sed ut perspiciatis unde
                                                    omnis</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>At vero eos et accusamus et
                                                    iusto</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Nam libero tempore cum
                                                    soluta</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Et harum quidem rerum
                                                    facilis est</a></li>
                                        </ul>
                                        <ul class="col-md-4 mega-menu-submenu">
                                            <li><h3>Neque porro quisquam</h3></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Lorem ipsum dolor sit amet</a>
                                            </li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Consectetur adipisicing
                                                    elit</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Sed ut perspiciatis unde
                                                    omnis</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>At vero eos et accusamus et
                                                    iusto</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Nam libero tempore cum
                                                    soluta</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i>Et harum quidem rerum
                                                    facilis est</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="mega-menu-dropdown mega-menu-full"><a href="javascript:;" data-toggle="dropdown"
                                                                     class="dropdown-toggle">Extras
                            &nbsp;<i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="mega-menu-content">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <ul class="col-md-4 mega-menu-submenu">
                                                <li><h3>Neque porro quisquam</h3></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Lorem ipsum dolor sit
                                                        amet</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Consectetur adipisicing
                                                        elit</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Sed ut perspiciatis
                                                        unde omnis</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>At vero eos et
                                                        accusamus et iusto</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Nam libero tempore cum
                                                        soluta</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Et harum quidem rerum
                                                        facilis est</a></li>
                                            </ul>
                                            <ul class="col-md-4 mega-menu-submenu">
                                                <li><h3>Neque porro quisquam</h3></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Lorem ipsum dolor sit
                                                        amet</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Consectetur adipisicing
                                                        elit</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Sed ut perspiciatis
                                                        unde omnis</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>At vero eos et
                                                        accusamus et iusto</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Nam libero tempore cum
                                                        soluta</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Et harum quidem rerum
                                                        facilis est</a></li>
                                            </ul>
                                            <ul class="col-md-4 mega-menu-submenu">
                                                <li><h3>Neque porro quisquam</h3></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Lorem ipsum dolor sit
                                                        amet</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Consectetur adipisicing
                                                        elit</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Sed ut perspiciatis
                                                        unde omnis</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>At vero eos et
                                                        accusamus et iusto</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Nam libero tempore cum
                                                        soluta</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i>Et harum quidem rerum
                                                        facilis est</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-5 document-demo">
                                            <ul class="col-md-4 mega-menu-submenu">
                                                <li><a href="#"><i
                                                            class="fa fa-info-circle"></i><span>Introduction</span></a></li>
                                                <li><a href="#"><i class="fa fa-download"></i><span>Installation</span></a>
                                                </li>
                                            </ul>
                                            <ul class="col-md-4 mega-menu-submenu">
                                                <li><a href="#"><i class="fa fa-cog"></i><span>T3 Settings</span></a>
                                                </li>
                                                <li><a href="#"><i class="fa fa-desktop"></i><span>Layout System</span></a>
                                                </li>
                                            </ul>
                                            <ul class="col-md-4 mega-menu-submenu">
                                                <li><a href="#"><i
                                                            class="fa fa-magic"></i><span>Customization</span></a></li>
                                                <li><a href="#"><i
                                                            class="fa fa-question-circle"></i><span>FAQs</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <form id="topbar-search" action="#" method="GET" class="hidden-xs">
                    <div class="input-group">
                        <input type="text" placeholder="Search..." class="form-control"/>
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit">
                                <i class="fa fa-search"></i>
                            </a>
                        </span>
                    </div>
                </form>
                <ul class="nav navbar navbar-top-links navbar-right mbn">
                    <li class="dropdown">
                        <a data-hover="dropdown" href="#" class="dropdown-toggle">
                            <i class="fa fa-bell fa-fw"></i><span class="badge badge-green">3</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li><p>You have 14 new notifications</p></li>
                            <li>
                                <div class="dropdown-slimscroll">
                                    <ul>
                                        <li><a href="extra-user-list.html" target="_blank"><span
                                                    class="label label-blue"><i class="fa fa-comment"></i></span>New Comment<span
                                                    class="pull-right text-muted small">4 mins ago</span></a></li>
                                        <li><a href="extra-user-list.html" target="_blank"><span
                                                    class="label label-violet"><i class="fa fa-twitter"></i></span>3 New
                                                Followers<span class="pull-right text-muted small">12 mins ago</span></a>
                                        </li>
                                        <li><a href="extra-user-list.html" target="_blank"><span
                                                    class="label label-pink"><i class="fa fa-envelope"></i></span>Message
                                                Sent<span class="pull-right text-muted small">15 mins ago</span></a></li>
                                        <li><a href="extra-user-list.html" target="_blank"><span
                                                    class="label label-green"><i class="fa fa-tasks"></i></span>New
                                                Task<span class="pull-right text-muted small">18 mins ago</span></a></li>
                                        <li><a href="extra-user-list.html" target="_blank"><span
                                                    class="label label-yellow"><i class="fa fa-upload"></i></span>Server
                                                Rebooted<span class="pull-right text-muted small">19 mins ago</span></a>
                                        </li>
                                        <li><a href="extra-user-list.html" target="_blank"><span
                                                    class="label label-green"><i class="fa fa-tasks"></i></span>New
                                                Task<span class="pull-right text-muted small">2 days ago</span></a></li>
                                        <li><a href="extra-user-list.html" target="_blank"><span
                                                    class="label label-pink"><i class="fa fa-envelope"></i></span>Message
                                                Sent<span class="pull-right text-muted small">5 days ago</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="last"><a href="extra-user-list.html" class="text-right">See all alerts</a></li>
                        </ul>
                    </li>
                    <?php if($siteData->operationID > 0){ ?>
                    <li class="dropdown topbar-user">
                        <a data-hover="dropdown" href="#" class="dropdown-toggle">
                            <img src="<?php echo Helpers_Image::getPhotoPath($siteData->user->getImagePath(), 90, 90); ?>" alt=""
                                class="img-responsive img-circle"/>&nbsp;
                            <span class="hidden-xs"><?php echo $siteData->operation->getName(); ?></span>&nbsp;
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-user pull-right">
                            <li><a href="<?php echo $siteData->urlBasic; ?>/config/shopoperation/edit?id=<?php echo $siteData->operationID; ?>"><i class="fa fa-user"></i>Сменя пароля</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo $siteData->urlBasic; ?>/config/shopuser/unlogin"><i class="fa fa-key"></i>Выход</a></li>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <!--BEGIN MODAL CONFIG PORTLET-->
        <div id="modal-config" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                        <h4 class="modal-title">Modal title</h4></div>
                    <div class="modal-body"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend et
                            nisl eget porta. Curabitur elementum sem molestie nisl varius, eget tempus odio molestie. Nunc
                            vehicula sem arcu, eu pulvinar neque cursus ac. Aliquam ultricies lobortis magna et aliquam.
                            Vestibulum egestas eu urna sed ultricies. Nullam pulvinar dolor vitae quam dictum condimentum.
                            Integer a sodales elit, eu pulvinar leo. Nunc nec aliquam nisi, a mollis neque. Ut vel felis
                            quis tellus hendrerit placerat. Vivamus vel nisl non magna feugiat dignissim sed ut nibh. Nulla
                            elementum, est a pretium hendrerit, arcu risus luctus augue, mattis aliquet orci ligula eget
                            massa. Sed ut ultricies felis.</p></div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--END MODAL CONFIG PORTLET--></div>
    <div id="wrapper">
        <nav id="sidebar" role="navigation" class="navbar-default navbar-static-side">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">
                    <li></li>
                    <?php
                    $view = View::factory('config/35/main/menu');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    echo Helpers_View::viewToStr($view);
                    ?>
                </ul>
            </div>
        </nav>
        <div id="chat-form" class="fixed">
            <div class="chat-inner"><h2 class="chat-header"><a href="javascript:;" class="chat-form-close pull-right"><i
                            class="glyphicon glyphicon-remove"></i></a><i class="fa fa-user"></i>&nbsp;
                    Chat
                    &nbsp;<span class="badge badge-info">3</span></h2>

                <div id="group-1" class="chat-group"><strong>Favorites</strong><a href="#"><span
                            class="user-status is-online"></span>
                        <small>Verna Morton</small>
                        <span class="badge badge-info">2</span></a><a href="#"><span class="user-status is-online"></span>
                        <small>Delores Blake</small>
                        <span class="badge badge-info is-hidden">0</span></a><a href="#"><span
                            class="user-status is-busy"></span>
                        <small>Nathaniel Morris</small>
                        <span class="badge badge-info is-hidden">0</span></a><a href="#"><span
                            class="user-status is-idle"></span>
                        <small>Boyd Bridges</small>
                        <span class="badge badge-info is-hidden">0</span></a><a href="#"><span
                            class="user-status is-offline"></span>
                        <small>Meredith Houston</small>
                        <span class="badge badge-info is-hidden">0</span></a></div>
                <div id="group-2" class="chat-group"><strong>Office</strong><a href="#"><span
                            class="user-status is-busy"></span>
                        <small>Ann Scott</small>
                        <span class="badge badge-info is-hidden">0</span></a><a href="#"><span
                            class="user-status is-offline"></span>
                        <small>Sherman Stokes</small>
                        <span class="badge badge-info is-hidden">0</span></a><a href="#"><span
                            class="user-status is-offline"></span>
                        <small>Florence Pierce</small>
                        <span class="badge badge-info">1</span></a></div>
                <div id="group-3" class="chat-group"><strong>Friends</strong><a href="#"><span
                            class="user-status is-online"></span>
                        <small>Willard Mckenzie</small>
                        <span class="badge badge-info is-hidden">0</span></a><a href="#"><span
                            class="user-status is-busy"></span>
                        <small>Jenny Frazier</small>
                        <span class="badge badge-info is-hidden">0</span></a><a href="#"><span
                            class="user-status is-offline"></span>
                        <small>Chris Stewart</small>
                        <span class="badge badge-info is-hidden">0</span></a><a href="#"><span
                            class="user-status is-offline"></span>
                        <small>Olivia Green</small>
                        <span class="badge badge-info is-hidden">0</span></a></div>
            </div>
            <div id="chat-box" style="top:400px">
                <div class="chat-box-header"><a href="#" class="chat-box-close pull-right"><i
                            class="glyphicon glyphicon-remove"></i></a><span class="user-status is-online"></span><span
                        class="display-name">Willard Mckenzie</span>
                    <small>Online</small>
                </div>
                <div class="chat-content">
                    <ul class="chat-box-body">
                        <li><p><img src="https://s3.amazonaws.com/uifaces/faces/twitter/kolage/128.jpg"
                                    class="avt"/><span class="user">John Doe</span><span class="time">09:33</span></p>

                            <p>Hi Swlabs, we have some comments for you.</p></li>
                        <li class="odd"><p><img src="https://s3.amazonaws.com/uifaces/faces/twitter/alagoon/48.jpg"
                                                class="avt"/><span class="user">Swlabs</span><span
                                    class="time">09:33</span></p>

                            <p>Hi, we're listening you...</p></li>
                    </ul>
                </div>
                <div class="chat-textarea"><input placeholder="Type your message" class="form-control"/></div>
            </div>
        </div>
        <div id="page-wrapper">
            <?php if(!empty($siteData->titleTop)){ ?>
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left">
                        <div class="page-title"><?php echo $siteData->titleTop; ?></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php } ?>
            <div class="page-content">
                <div class="panel">
                    <div class="panel-body">
                        <?php echo trim($data['view::main']); ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
            <div class="copyright">Авторские права &copy; 2021-<?php echo date('Y'); ?> Все права защищены.</div>
        </div>
    </div>
</div>


<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/config/js/html5shiv.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/js/respond.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/slimScroll/jquery.slimscroll.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/jquery-cookie/jquery.cookie.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/iCheck/icheck.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/iCheck/custom.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/jquery-notific8/jquery.notific8.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/jquery-highcharts/highcharts.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/js/jquery.menu.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/jquery-pace/pace.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/holder/holder.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/responsive-tabs/responsive-tabs.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/jquery-news-ticker/jquery.newsTicker.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/moment/moment.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<!--CORE JAVASCRIPT-->
<script src="<?php echo $siteData->urlBasic; ?>/css/config/main.js"></script>
<!--LOADING SCRIPTS FOR PAGE-->
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/intro.js/intro.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/flot-chart/jquery.flot.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/flot-chart/jquery.flot.categories.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/flot-chart/jquery.flot.pie.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/flot-chart/jquery.flot.tooltip.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/flot-chart/jquery.flot.resize.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/flot-chart/jquery.flot.fillbetween.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/flot-chart/jquery.flot.stack.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/flot-chart/jquery.flot.spline.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/calendar/zabuto_calendar.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/sco.message/sco.message.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/vendors/intro.js/intro.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/config/js/index.js"></script>
</body>
</html>