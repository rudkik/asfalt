<?php
$editFields = Request_RequestParams::getParamArray('edit_fields', array(), array());

$countFields = 0;
if(in_array('price', $editFields)){$countFields++;}

$objOptions = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.options', array());
if (!is_array($objOptions)){
    $objOptions = array();
}

foreach($objOptions as $objOption) {
    $field = 'options.'.$objOption['field'];
    if(in_array($field, $editFields)){
        $countFields++;
    }
}
if(in_array('text', $editFields)){$countFields++;}
if(in_array('options', $editFields)){$countFields++;}
?>
<tr>
    <td>
        <input name="shop_goods[<?php echo $data->id; ?>][is_public]" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal is-public">
    </td>
    <td><?php echo $data->id; ?></td>
    <?php if (Func::isShopMenu('shopdeliverytype/image?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
    <td><img class="table-preview" data-action="modal-image" data-id="<?php echo $data->id; ?>" data-href="<?php echo Func::getFullURL($siteData, '/shopdeliverytype/addimg');?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <?php } ?>
    <td>
        <input name="shop_goods[<?php echo $data->id; ?>][name]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </td>
    <td>
        <input name="shop_goods[<?php echo $data->id; ?>][price]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.price', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo htmlspecialchars(Func::getNumberStr($data->values['price'], FALSE)); ?>">
    </td>
    <td <?php if($countFields > 0){ echo 'rowspan="2"';}?>>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopdeliverytype/edit', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopdeliverytype/clone', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-black text-sm"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopdeliverytype/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopdeliverytype/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>

<?php if($countFields > 0){?>
<?php
$count = 4;
if (Func::isShopMenu('shopdeliverytype/image?type='.$data->values['shop_table_catalog_id'], $siteData)){$count++;}
if(empty($editFields) || (in_array('article', $editFields))){$count++;}
if(empty($editFields) || (in_array('shop_table_rubric_id', $editFields))){if (Func::isShopMenu('shopdeliverytype/rubric?type='.$data->values['shop_table_catalog_id'], $siteData)){$count++;}}
?>
<?php if($count > 0) { ?>
        <tr>
            <td colspan="<?php echo $count; ?>">
                <div class="row"style="margin-left: -8px;margin-right: -8px;">
                    <?php if (in_array('old_id', $editFields)) { ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="old_id">ID</label>
                                <input name="shop_goods[<?php echo $data->id; ?>][old_id]" class="form-control"
                                       id="old_id" placeholder="ID" type="text"
                                       value="<?php echo htmlspecialchars($data->values['old_id'], ENT_QUOTES); ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (in_array('price_old', $editFields)) { ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="price_old">Старая цена</label>
                                <input name="shop_goods[<?php echo $data->id; ?>][price_old]" class="form-control"
                                       id="price_old" placeholder="Старая цена" type="text"
                                       value="<?php echo Func::getPrice($siteData->currency, $data->values['price_old']); ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                    if (in_array('options', $editFields)) {
                        $objOptions = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_table_catalog_id.options', array());
                        if (!is_array($objOptions)) {
                            $objOptions = array();
                        }

                        $options = $data->values['options'];

                        foreach ($objOptions as $objOption) {
                            $field = $objOption['field'];
                            $value = Arr::path($options, $field, '');

                            if (key_exists($field, $options)) {
                                unset($options[$field]);
                            }

                            if((key_exists($field, $options)) || (in_array('options.'.$field, $editFields))) {
                                ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label
                                            for="options.<?php echo $field; ?>"><?php echo $objOption['title']; ?></label>
                                        <input
                                            name="shop_goods[<?php echo $data->id; ?>][options][<?php echo $field; ?>]"
                                            class="form-control" id="options.<?php echo $field; ?>"
                                            placeholder="<?php echo $objOption['title']; ?>" type="text"
                                            value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>">
                                    </div>
                                </div>
                                <?php
                            }
                        }

                        foreach ($options as $field => $value){
                            ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="options.<?php echo $field; ?>"><?php echo $field ?></label>
                                    <input
                                        name="shop_goods[<?php echo $data->id; ?>][options][<?php echo $field; ?>]"
                                        class="form-control" id="options.<?php echo $field; ?>"
                                        placeholder="<?php echo $field; ?>" type="text"
                                        value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>">
                                </div>
                            </div>
                            <?php
                        }

                    }else {
                        $objOptions = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_table_catalog_id.options', array());
                        if (!is_array($objOptions)) {
                            $objOptions = array();
                        }
                        foreach ($objOptions as $objOption) {
                            $field = 'options.' . $objOption['field'];
                            if (in_array($field, $editFields)) {
                                ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="<?php echo $field; ?>"><?php echo $objOption['title']; ?></label>
                                        <input
                                            name="shop_goods[<?php echo $data->id; ?>][options][<?php echo $objOption['field']; ?>]"
                                            class="form-control" id="<?php echo $field; ?>"
                                            placeholder="<?php echo $objOption['title']; ?>" type="text"
                                            value="<?php echo htmlspecialchars(Arr::path($data->values['options'], $objOption['field'], ''), ENT_QUOTES); ?>">
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                    <?php if (in_array('info', $editFields)) { ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="info">Описание</label>
                                <textarea name="shop_goods[<?php echo $data->id; ?>][info]" placeholder="Описание..."
                                          rows="3" class="form-control"><?php echo $data->values['text']; ?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </td>
        </tr>
        <?php
    }
}
?>