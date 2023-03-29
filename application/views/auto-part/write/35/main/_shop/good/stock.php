<h3>
    <?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.name_one', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
    <small style="margin-right: 10px;">размещение</small>
</h3>
<form id="form-save" action="<?php echo Func::getFullURL($siteData, '/shopgood/save_stock'); ?>" method="post">
    <?php echo trim($data['view::_shop/good/one/stock']); ?>
</form>
