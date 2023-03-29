<!DOCTYPE html>
<html lang="en">
<head>
    <title>Авторизация</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
    <!--Loading bootstrap css-->
    <link type="text/css"
          href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet"
          href="<?php echo $siteData->urlBasic; ?>/css/smg/vendors/jquery-ui-1.10.3.custom/css/ui-lightness/jquery-ui-1.10.3.custom.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/fonts/font-awesome/v4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <!--Loading style vendors-->
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/smg/vendors/animate.css/animate.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/smg/vendors/iCheck/skins/all.css">
    <!--Loading style-->
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/smg/css/themes/style1/pink-blue.css" class="default-style">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/smg/css/themes/style1/pink-blue.css" id="theme-change"
          class="style-change color-change">
    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/smg/css/style-responsive.css">
    <link rel="shortcut icon" href="images/favicon.ico">
</head>
<body id="signin-page">
<div class="page-form">
    <form action="<?php echo $siteData->urlBasic; ?>/market/shopuser/login" class="form" method="post">
        <div class="header-content"><h1>Авторизация</h1></div>
        <div class="body-content">
            <div class="form-group">
                <div class="input-icon right">
                    <i class="fa fa-user"></i>
                    <input type="text" placeholder="Логин" name="email" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="input-icon right">
                    <i class="fa fa-key"></i>
                    <input type="password" placeholder="Пароль" name="password" class="form-control">
                </div>
            </div>
            <div class="form-group pull-left">
                <div class="checkbox-list">
                    <label><input type="checkbox">&nbsp;Запомнить меня</label>
                </div>
            </div>
            <div class="form-group pull-right">
                <button type="submit" class="btn btn-success">Войти <i class="fa fa-chevron-circle-right"></i></button>
            </div>
            <div class="clearfix"></div>
        </div>
    </form>
</div>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/smg/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/smg/js/jquery-ui.js"></script>
<!--loading bootstrap js-->
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/smg/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/smg/js/html5shiv.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/smg/js/respond.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/smg/vendors/iCheck/icheck.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/smg/vendors/iCheck/custom.min.js"></script>
<script>
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_minimal-grey',
        increaseArea: '20%' // optional
    });
    $('input[type="radio"]').iCheck({
        radioClass: 'iradio_minimal-grey',
        increaseArea: '20%' // optional
    });
</script>
</body>
</html>
