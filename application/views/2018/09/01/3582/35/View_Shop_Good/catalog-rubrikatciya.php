<?php
if (Request_RequestParams::getParamInt('rubric_id') == $data->values['id']) {
    Helpers_SEO::setSEOHeader(Model_Shop_Table_Rubric::TABLE_NAME, $data, $siteData);
    $siteData->siteImage = $data->values['image_path'];
}
?>
<div class="catalog__switch__radio">
    <?php if($data->values['is_public'] != 1){?>
	<label class="catalog__switch__radio__text btn btn--disabled" for="radio-<?php echo $data->values['id']; ?>">
		<?php echo $data->values['name']; ?>
	</label>
    <?php }else{?>
        <label class="catalog__switch__radio__text btn" for="radio-<?php echo $data->values['id']; ?>">
            <a href="<?php echo $siteData->urlBasic; ?>/catalog<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
        </label>
    <?php }?>
</div>