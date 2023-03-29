<?php
for ($i = 1; $i <= Model_Shop_Table_Basic_Table::PARAMS_COUNT; $i++){
    $name = 'param_'.$i.'_int';
    if (Func::isShopMenu('shopcar/find/'.$name.'?type='.$type, $siteData)){ ?>
        <div class="col-md-4">
            <div class="form-group">
                <span for="input-<?php echo $name; ?>" class="control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.'.$name, SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                <input id="input-<?php echo $name; ?>" class="form-control" name="<?php echo $name; ?>" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.'.$name, SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo Arr::path($siteData->urlParams, $name, '');?>" type="text">
            </div>
        </div>
    <?php } ?>
    <?php $name = 'param_'.$i.'_float';
    if (Func::isShopMenu('shopcar/find/'.$name.'?type='.$type, $siteData)){ ?>
        <div class="col-md-4">
            <div class="form-group">
                <span for="input-<?php echo $name; ?>" class="control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.'.$name, SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                <input id="input-<?php echo $name; ?>" class="form-control" name="<?php echo $name; ?>" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.'.$name, SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo Arr::path($siteData->urlParams, $name, '');?>" type="text">
            </div>
        </div>
    <?php } ?>
    <?php $name = 'param_'.$i.'_str';
    if (Func::isShopMenu('shopcar/find/'.$name.'?type='.$type, $siteData)){ ?>
        <div class="col-md-4">
            <div class="form-group">
                <span for="input-<?php echo $name; ?>" class="control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.'.$name, SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                <input id="input-<?php echo $name; ?>" class="form-control" name="<?php echo $name; ?>" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.'.$name, SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo Arr::path($siteData->urlParams, $name, '');?>" type="text">
            </div>
        </div>
    <?php } ?>
<?php } ?>
