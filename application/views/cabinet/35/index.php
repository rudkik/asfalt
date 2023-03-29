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
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/css/skins/_all-skins.min.css">
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

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.css"/>

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/css/base.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/cabinet/css/style.css">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/image.main.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/jquery.jgrowl.css">

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Редактирование HTML -->
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/ckeditor/ckeditor.js" type="text/javascript"
            charset="utf-8"></script>

    <!--  загрузка файлов -->
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/css/style.css"  />
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.knob.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.ui.widget.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.iframe-transport.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/jquery.fileupload.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadfile/js/script.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/server/jquery-ui.min.js"></script>
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">
    <header class="main-header" style="position: relative;">
        <a href="<?php echo $siteData->urlBasic; ?>/cabinet/shop/edit" class="logo">
            <?php if($siteData->shopID > 0){ ?>
                <span class="logo-mini"><b><?php echo Func::trimTextNew($siteData->shop->getName(), 3, FALSE); ?></b></span>
                <span class="logo-lg"><b><?php echo Func::trimTextNew($siteData->shop->getName(), 15, FALSE); ?></b></span>
            <?php } ?>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav" id="bills-menu">
                    <?php echo trim($siteData->replaceDatas['view::_shop/bill/list/menu']); ?>
                    <li class="dropdown user user-menu">
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
                                        <a href="<?php echo $siteData->urlBasic; ?>/cabinet/shopuser/unlogin" class="btn btn-default btn-flat">Выход</a>
                                    </div>
                                </li>
                            </ul>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </nav>
        <?php  if(key_exists('view::menu-top', $data)){echo trim($data['view::menu-top']);} ?>
    </header>

    <aside class="main-sidebar" style="padding-top: 83px; position: absolute;">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li class="header">Меню</li>
                <?php if(key_exists('view::menu', $data)){echo trim($data['view::menu']);} ?>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <?php echo trim($data['view::main']); ?>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Версия</b> 2.0.0.2
        </div>
        <strong>Авторские права &copy; 2014-<?php echo date('Y'); ?> Все права защищены.</strong>
    </footer>
    <div class="control-sidebar-bg"></div>
</div>
<div id="modal-image" class="modal fade modal-image">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть" style="margin: -40px -40px 0px 0px;"><span aria-hidden="true">×</span></button>
                <div class="modal-fields">
                    <div class="row">
                        <form enctype="multipart/form-data" action="" method="post">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="file-upload" data-text="Выберите файл" placeholder="Выберите файл">
                                        <input type="file" name="file">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input name="file_url" type="text" class="form-control" placeholder="Введите адрес картинки">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div hidden>
                                    <input name="id" value="0">
                                    <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
                                    <?php if($siteData->branchID > 0){ ?>
                                        <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                                    <?php } ?>
                                    <?php if($siteData->superUserID > 0){ ?>
                                        <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
                                    <?php } ?>
                                </div>
                                <button type="submit" class="btn btn-primary">Загрузить</button>
                            </div>
                        </form>
                    </div>
                    <div class="row margin-t-15">
                        <div class="col-md-12">
                            <img id="modal-img" src="" class="img-responsive" style="margin: 0 auto; max-height: 700px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/cabinet/js/main.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Select2 -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.js"></script>

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
<!-- FastClick -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/fastclick/fastclick.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/js/demo.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/dmuploader.min.js"></script>

<script>
    $('input[type="local-date"]').datetimepicker({
        dayOfWeekStart : 1,
        lang:'ru',
        format:	'd.m.Y',
        timepicker:false,
    });
    $('input[type="time"]').datetimepicker({
        dayOfWeekStart : 1,
        lang:'ru',
        format:	'H:i',
        datepicker:false,
    });
</script>
</body>
</html>
