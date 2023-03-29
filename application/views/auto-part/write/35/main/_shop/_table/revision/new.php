<h3>
    <?php echo SitePageData::setPathReplace('type.form_data.shop_table_revision.fields_title.name_one', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
    <small style="margin-right: 10px;">добавление</small>
</h3>
<form action="<?php echo Func::getFullURL($siteData, '/shoptablerevision/save'); ?>" method="post">
    <?php echo trim($data['view::_shop/_table/revision/one/new']); ?>
</form>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
<script>
    $(".select2").select2();
</script>