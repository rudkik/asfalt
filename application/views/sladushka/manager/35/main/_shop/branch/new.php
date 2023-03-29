<h3>Новая торгова точка</h3>
<form action="<?php echo Func::getFullURL($siteData, '/shopbranch/save'); ?>" method="post">
    <?php echo trim($data['view::_shop/branch/one/new']); ?>
</form>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
<script>
    $(".select2").select2();
</script>

<!--  загрузка файлов -->
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/image.main.css">
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/jquery.jgrowl.css">
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/dmuploader.min.js"></script>
