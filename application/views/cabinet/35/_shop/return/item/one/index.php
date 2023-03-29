<tr>
    <td><?php echo $data->values['shop_good_id']; ?></td>
    <td><img src="<?php echo Helpers_Image::getPhotoPath(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.image_path', ''), 68, 52); ?>"></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.article', ''); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.name', ''); ?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['price']);?></td>
    <td><input id="count-<?php echo $data->id;?>" name="shop_return_items[<?php echo $data->values['id']; ?>][count]" value="<?php echo Func::getNumberStr($data->values['count']); ?>" style="max-width: 107px;" autocomplete="off"></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></td>
    <td>
        <ul class="list-inline tr-button delete">
            <li><a href="javascript:saveShopBillItem(<?php echo $data->values['shop_id'];?>, <?php echo $data->id;?>)" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Сохранить</a></li>
            <li class="tr-remove"><a href="javascript:delShopBillItem(<?php echo $data->values['shop_id'];?>, <?php echo $data->id;?>)" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
<?php if(!empty($data->values['options'])){ ?>
<tr>
    <td colspan="8">
        <div class="row">
    <?php
    $optionsName = 'options';
    $fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_return_catalog_id.return_item_options', array());

    $values = Arr::path($data->values, $optionsName, array());
    if(! is_array($values)){
        $values = array();
    }
    foreach ($fields as $field){
        $value = Arr::path($values, $field['field'], '');

        if(key_exists($field['field'], $values)){
            unset($values[$field['field']]);
        }

        ?>
        <div class="col-md-<?php
        switch(count($fields)){
            case 1: echo 12; break;
            case 2: echo 6; break;
            case 3: echo 4; break;
            default:
                echo 3;
        }
        ?>">
            <div class="form-group">
                <label>
                    <?php echo $field['title']; ?>
                    <?php if(!Func::_empty(Arr::path($field, 'hint', ''))){ ?>
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    <?php } ?>
                </label>
                <?php switch(intval(Arr::path($field, 'type', 0))){
                case (Model_Shop_Basic_Options::OPTIONS_TYPE_CHECKBOX): ?>
                    <span class="span-checkbox" style="padding-top: 7px;"><input name="shop_return_items[<?php echo $data->values['id']; ?>][<?php echo $optionsName; ?>][<?php echo $field['field']; ?>]"  type="checkbox" class="minimal" <?php if($value == 1){echo 'checked value="1"';}else{echo 'value="0"';} ?>> <?php echo $field['title']; ?></span>
                <?php break;
                case (Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA): ?>
                    <textarea name="shop_return_items[<?php echo $data->values['id']; ?>][<?php echo $optionsName; ?>][<?php echo $field['field']; ?>]" placeholder="<?php echo htmlspecialchars($field['title'], ENT_QUOTES);?>" rows="<?php echo Arr::path($field, 'options.rows', 2) *1 ;?>" class="form-control"><?php echo $value; ?></textarea>
                <?php break;
                case (Model_Shop_Basic_Options::OPTIONS_TYPE_FILE): ?>
                    <div class="file-upload" data-text="Выберите файл" placeholder="Выберите файл">
                        <input type="file" name="shop_return_items[<?php echo $data->values['id']; ?>][<?php echo $optionsName; ?>][<?php echo $field['field']; ?>]">
                    </div>
                <?php break;
                case (Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA_HTML): ?>
                    <textarea name="shop_return_items[<?php echo $data->values['id']; ?>][<?php echo $optionsName; ?>][<?php echo $field['field']; ?>]" placeholder="<?php echo htmlspecialchars($field['title'], ENT_QUOTES);?>" rows="<?php echo Arr::path($field, 'options.rows', 7) *1 ;?>" class="form-control"><?php echo $value; ?></textarea>
                    <script>
                        CKEDITOR.replace('<?php echo $optionsName; ?>[<?php echo $field['field']; ?>]');
                    </script>
                <?php
                break;
                default: ?>
                <input name="shop_return_items[<?php echo $data->values['id']; ?>][<?php echo $optionsName; ?>][<?php echo $field['field']; ?>]" type="text" class="form-control" placeholder="<?php echo htmlspecialchars($field['title'], ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>">
                <?php } ?>
            </div>
        </div>
    <?php }?>
    <?php
    // выводим оставшиеся
    foreach ($values as $name => $value){
        ?>
        <div class="col-md-<?php
        switch(count($fields) + count($values)){
            case 1: echo 12; break;
            case 2: echo 6; break;
            case 3: echo 4; break;
            default:
                echo 3;
        }
        ?>">
            <div class="form-group">
                <label><?php echo $name; ?></label>
                <input name="shop_return_items[<?php echo $data->values['id']; ?>][<?php echo $optionsName; ?>][<?php echo $name; ?>]" type="text" class="form-control" placeholder="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($value, ENT_QUOTES); ?>">
            </div>
        </div>
    <?php }?>
        </div>
    </td>
</tr>
<?php } ?>
