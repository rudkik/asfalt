<?php
$editFields = Request_RequestParams::getParamArray('edit_fields', array(), array());

$countFields = 0;
if(in_array('old_id', $editFields)){$countFields++;}

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
if(in_array('info', $editFields)){$countFields++;}
if(in_array('options', $editFields)){$countFields++;}
?>
<tr>
    <td>
        <input name="shop_addresss[<?php echo $data->id; ?>][is_public]" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal is-public">
    </td>
    <td><?php echo $data->id; ?></td>
    <?php if(empty($editFields) || (in_array('shop_table_rubric_id', $editFields))){ ?>
    <?php if (Func::isShopMenu('shopaddress/rubric', $siteData)){ ?>
        <td>
            <div class="input-group">
                <select name="shop_addresss[<?php echo $data->id; ?>][shop_table_rubric_id]" class="form-control select2" style="width: 100%;">
                    <option value="0" data-id="0">Верхнего уровня</option>
                    <?php
                    $s = 'data-id="'.$data->values['shop_table_rubric_id'].'"';
                    echo trim(str_replace($s, $s.' selected',$siteData->replaceDatas['view::_shop/_table/rubric/list/list']));
                    ?>
                </select>
                <span class="input-group-btn"><button data-action="copy-select" class="btn btn-info btn-flat" type="button"><i class="fa fa-fw fa-copy"></i></button></span>
                <span class="input-group-btn"><button data-action="insert-select" class="btn btn-info btn-flat" type="button"><i class="fa fa-fw fa-paste"></i></button></span>
            </div>
        </td>
    <?php } ?>
    <?php } ?>
    <td>
        <input name="shop_addresss[<?php echo $data->id; ?>][name]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_address.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </td>
    <td <?php if($countFields > 0){ echo 'rowspan="2"';}?>>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopaddress/edit', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopaddress/clone', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-black text-sm"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopaddress/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopaddress/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>

<?php if($countFields > 0){?>
<?php
$count = 4;
if(empty($editFields) || (in_array('shop_table_rubric_id', $editFields))){if (Func::isShopMenu('shopaddress/rubric', $siteData)){$count++;}}
?>
<?php if($count > 0) { ?>
        <tr>
            <td colspan="<?php echo $count; ?>">
                <div class="row"style="margin-left: -8px;margin-right: -8px;">
                    <?php if (in_array('old_id', $editFields)) { ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="old_id">ID</label>
                                <input name="shop_addresss[<?php echo $data->id; ?>][old_id]" class="form-control"
                                       id="old_id" placeholder="ID" type="text"
                                       value="<?php echo htmlspecialchars($data->values['old_id'], ENT_QUOTES); ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (in_array('text', $editFields)) { ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="info">Описание</label>
                                <textarea name="shop_addresss[<?php echo $data->id; ?>][text]" placeholder="Описание..."
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