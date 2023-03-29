<div class="body-cart-shop">
    <div class="container">
        <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbill/save" method="post" style="padding-right: 5px;">
            <?php echo trim($data['view::shopbill/edit']); ?>
        </form>
    </div>
</div>
<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/datetime/jquery.datetimepicker.css"/>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/datetime/jquery.datetimepicker.js"></script>
<script>
    $('input[type="datetime"]').datetimepicker({
        dayOfWeekStart : 1,
        lang:'ru',
        format:	'd.m.Y H:i',
    });
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
</script>
