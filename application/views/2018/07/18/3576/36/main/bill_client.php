<header class="header-reserve">
    <div class="container">
        <?php echo trim($siteData->globalDatas['view::View_Hotel_Shop_Bill\bill_client']); ?>
    </div>
</header>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
<script>
    $('input[type="phone"]').inputmask({
        mask: "+9 (999) 999 99 99"
    });
</script>