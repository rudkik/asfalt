<?php
for ($i = 1; $i <= Model_Shop_Table_Basic_Table::PARAMS_COUNT; $i++){
    if (Func::isShopMenu('shopcar/find/param'.$i.'?type='.$type, $siteData)){ ?>
        <div class="col-md-4">
            <div class="form-group">
                <span for="input-param_<?php echo $i; ?>" class="control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.param'.$i, SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                <div class="input-group input-group-select">
                    <select id="input-param_<?php echo $i; ?>" name="shop_table_param_<?php echo $i; ?>_id" class="form-control select2" style="width: 100%;">
                        <?php $tmp = Request_RequestParams::getParamInt('shop_table_param_'.$i.'_id'); ?>
                        <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>>Без значения</option>
                        <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Значение не выбрано</option>
                        <?php
                        $tmp = 'data-id="'.$tmp.'"';
                        echo trim(str_replace($tmp, $tmp . ' selected', $siteData->replaceDatas['view::_shop/_table/param/'.$i.'/list/list']));
                        ?>
                    </select>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
