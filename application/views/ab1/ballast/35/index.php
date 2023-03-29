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

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/fonts/font-awesome/v4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/server/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/datepicker/datepicker3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/datatables/dataTables.bootstrap.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/css/base.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/ab1/css/style.css?cache=<?php echo Controller_Ab1_Version::VERSION;?>">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/image.main.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/jquery.jgrowl.css">

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Редактирование HTML -->
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/ckeditor/ckeditor.js" type="text/javascript"
            charset="utf-8"></script>

    <!--  загрузка файлов -->
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/css/style.css"  />
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.knob.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.ui.widget.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.iframe-transport.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.fileupload.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/script.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/server/jquery-ui.min.js"></script>

    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.css"/>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
</head>
<body class="hold-transition fixed" style="font-size: 16px">
<div class="wrapper">
    <div class="content-wrapper" style="margin-left: 0px;">
        <header class="main-header" style="position: relative;">
            <nav class="navbar navbar-static-top" role="navigation" style="margin: 0px">
                <div class="navbar-custom-menu" style="width: 100%">
                    <ul class="nav navbar-nav" style="width: 100%">
                        <?php
                        $view = View::factory('ab1/admin/35/menu-branch');
                        $view->siteData = $siteData;
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <li class="dropdown user user-menu pull-right">
                            <?php if($siteData->operationID > 0){ ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo Helpers_Image::getPhotoPath($siteData->user->getImagePath(), 25, 25); ?>" class="user-image" alt="<?php echo $siteData->operation->getName(); ?>">
                                    <span class="hidden-xs"><?php echo $siteData->operation->getName(); ?></span>
                                </a>
                                <ul class="dropdown-menu" style="top: 82px;">
                                    <li class="user-header">
                                        <img src="<?php echo Helpers_Image::getPhotoPath($siteData->user->getImagePath(), 90, 90); ?>" class="img-circle" alt="<?php echo $siteData->operation->getName(); ?>">
                                        <p>
                                            <?php echo $siteData->operation->getName(); ?>
                                            <small><?php echo Helpers_DateTime::getDateTimeFormatRusMonthStr($siteData->operation->getCreatedAt()); ?></small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopuser/unlogin" class="btn btn-default btn-flat">Выход</a>
                                        </div>
                                    </li>
                                </ul>
                            <?php } ?>
                        </li>
                        <?php
                        $view = View::factory('ab1/admin/35/menu-user');
                        $view->siteData = $siteData;
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </ul>
                </div>
            </nav>
        </header>
        <?php echo trim($data['view::main']); ?>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Версия</b> 3.0.0.1
        </div>
        <strong>Авторские права &copy; 2014-<?php echo date('Y'); ?> Все права защищены.</strong>
    </footer>
</div>
<a id="toTop" href="#" class="box-up" style="display: none">
    <img src="<?php echo $siteData->urlBasic; ?>/css/ab1/img/up.png">
</a>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.extensions.js"></script>


<!-- bootstrap time picker -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/server/raphael-min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/server/moment.min.js"></script>
<!-- datepicker -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/fastclick/fastclick.min.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/dmuploader.min.js"></script>


<script src="<?php echo $siteData->urlBasic; ?>/css/_component/format-money.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/ab1/js/main.js?cache=<?php echo Controller_Ab1_Version::VERSION;?>"></script>
</body>
</html>
