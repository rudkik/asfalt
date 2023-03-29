<?php
$view = View::factory($siteData->shopShablonPath.'/35/find');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>

<link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/datetime/jquery.datetimepicker.css"/>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/datetime/jquery.datetimepicker.js"></script>
<?php echo trim($data['view::shopcarts/index']); ?>
<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>
<script>
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
</script>
<!--[if !IE]><!-->
<style>
    @media only screen and (max-width: 720px),(max-device-width: 720px)  {
        .table-column-5 td {
            padding-left: 100px !important;
        }

        .table-column-5 td:first-child{
            background-color: #ddd;
        }
        .table-column-5 td:nth-of-type(1):before { content: "Товар"; }
        .table-column-5 td:nth-of-type(2):before { content: "Кол-во"; }
        .table-column-5 td:nth-of-type(3):before { content: "Цена"; }
        .table-column-5 td:nth-of-type(4):before { content: "Итого"; }
        .table-column-5 td:nth-of-type(5):before { content: ""; }
    }
</style>
<!--<![endif]-->