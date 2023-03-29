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
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/css/skins/_all-skins.min.css">

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

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/css/base.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/calendar/css/style.css">

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


    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/server/jquery-ui.min.js"></script>

    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/datetime_v2/build/jquery.datetimepicker.min.css"/>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/moment/moment.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/moment/locale/ru.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/datetime_v2/build/jquery.datetimepicker.full.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
    <!-- Select2 -->
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/select4/js/select2.full.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/select4/js/i18n/ru.js"></script>

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/css/style.css">


    <link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css"/>
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/css/jquery.fileupload.css" />
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/css/jquery.fileupload-ui.css" />
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/css/jquery.fileupload-noscript.css"/></noscript>
    <noscript><link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css"/></noscript>


</head>
<body class="hold-transition fixed ">
<div class="wrapper">
    <div class="content-wrapper" style="margin-left: 0px;">
        <header class="main-header" style="position: relative;">
            <a href="<?php echo $siteData->urlBasic; ?>/calendar/shoptask/index" class="logo">
                <?php if($siteData->shopID > 0){ ?>
                    <span class="logo-mini"><b><?php echo Func::trimTextNew($siteData->shop->getName(), 3, FALSE); ?></b></span>
                    <span class="logo-lg"><b><?php echo Func::trimTextNew($siteData->shop->getName(), 20, FALSE); ?></b></span>
                <?php } ?>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
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
                                            <a href="<?php echo $siteData->urlBasic; ?>/calendar/shopuser/unlogin" class="btn btn-default btn-flat">Выход</a>
                                        </div>
                                    </li>
                                </ul>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <?php echo trim($data['view::main']); ?>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Версия</b> 2.0.0.2
        </div>
        <strong>Авторские права &copy; 2014-<?php echo date('Y'); ?> Все права защищены.</strong>
    </footer>
</div>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>


<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- InputMask -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jquery-number/jquery.number.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.extensions.js"></script>

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
<!-- datepicker -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/fastclick/fastclick.min.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/dmuploader.min.js"></script>

<script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/bloodhound.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/dist/typeahead.jquery.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/typeahead/js/handlebars.js"></script>

<link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>


<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/_component/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/_component/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
    $(function() {
        moment.locale('ru');

        <?php
        $d = Request_RequestParams::getParamDate('period_from') ;
        if($d === NULL){
            echo 'var start = null;';
        }else{
            echo 'var start = moment(\''.$d.'\');';
        }
        ?>

        <?php
        $d = Request_RequestParams::getParamDate('period_to') ;
        if($d === NULL){
            echo 'var end = null;';
        }else{
            echo 'var end = moment(\''.$d.'\');';
        }
        ?>


        function cb(start, end) {
            $('#period span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

            start = start.format('DD.MM.YYYY');
            $('#period_from').val(start).attr('value', start);

            end = end.format('DD.MM.YYYY');
            $('#period_to').val(end).attr('value', end);
        }


        if(start != null && end != null) {
            $('#period').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Сегодня': [moment(), moment()],
                    'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
                    'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                    'Текущий месяц': [moment().startOf('month'), moment().endOf('month')],
                    'Предыдущий месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Очистить': [moment().subtract(12 * 10, 'month'), moment().subtract(-12 * 10, 'month')],
                },
                "locale": {
                    "format": "MM/DD/YYYY",
                    "separator": " - ",
                    "applyLabel": "Применить",
                    "cancelLabel": "Отмена",
                    "fromLabel": "От",
                    "toLabel": "До",
                    "customRangeLabel": "Свой",
                    "daysOfWeek": [
                        "Вс",
                        "Пн",
                        "Вт",
                        "Ср",
                        "Чт",
                        "Пт",
                        "Сб"
                    ],
                    "monthNames": [
                        "Январь",
                        "Февраль",
                        "Март",
                        "Апрель",
                        "Май",
                        "Июнь",
                        "Июль",
                        "Август",
                        "Сентябрь",
                        "Октябрь",
                        "Ноябрь",
                        "Декабрь"
                    ],
                    "firstDay": 1
                }

            }, cb);

            cb(start, end);
        }else{
            $('#period').daterangepicker({
                ranges: {
                    'Сегодня': [moment(), moment()],
                    'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
                    'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                    'Текущий месяц': [moment().startOf('month'), moment().endOf('month')],
                    'Предыдущий месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Очистить': [moment().subtract(12 * 10, 'month'), moment().subtract(-12 * 10, 'month')],
                },
                "locale": {
                    "format": "MM/DD/YYYY",
                    "separator": " - ",
                    "applyLabel": "Применить",
                    "cancelLabel": "Отмена",
                    "fromLabel": "От",
                    "toLabel": "До",
                    "customRangeLabel": "Свой",
                    "daysOfWeek": [
                        "Вс",
                        "Пн",
                        "Вт",
                        "Ср",
                        "Чт",
                        "Пт",
                        "Сб"
                    ],
                    "monthNames": [
                        "Январь",
                        "Февраль",
                        "Март",
                        "Апрель",
                        "Май",
                        "Июнь",
                        "Июль",
                        "Август",
                        "Сентябрь",
                        "Октябрь",
                        "Ноябрь",
                        "Декабрь"
                    ],
                    "firstDay": 1
                }

            }, cb).on('apply.daterangepicker', function(ev, picker) {
                console.log('changed');
            });;
        }

    });
</script>

<script src="<?php echo $siteData->urlBasic; ?>/css/_component/basic.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/calendar/js/main.js?cache=5"></script>




<!-- The Templates plugin is included to render the upload/download listings -->
<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!-- blueimp Gallery script -->
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/js/demo.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/jQuery-File-Upload/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->



</body>
</html>
