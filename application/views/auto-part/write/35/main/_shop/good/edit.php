<h3>
    <?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.name_one', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
    <small style="margin-right: 10px;">редактирование</small>
</h3>
<form id="form-save" action="<?php echo Func::getFullURL($siteData, '/shopgood/save'); ?>" method="post">
    <?php echo trim($data['view::_shop/good/one/edit']); ?>
</form>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
<script>
    $(".select2").select2();
</script>

<!--  загрузка файлов -->
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/image.main.css">
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/jquery.jgrowl.css">
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/dmuploader.min.js"></script>