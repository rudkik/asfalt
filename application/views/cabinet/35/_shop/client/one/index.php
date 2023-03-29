<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopclient/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td><?php echo $data->id; ?></td>
    <?php if (Func::isShopMenu('shopclient/image?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><img data-action="modal-image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopclient/rubric?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php $s = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); if(empty($s)){echo 'Верхнего уровня';}else{echo $s;}  ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopclient/name?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->values['name']; ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopclient/last_name?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->values['last_name']; ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopclient/contacts?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td>
            <?php
            $contacts = $data->values['contacts'];

            $text = '';
            foreach ($contacts as $contactTypes){
                foreach ($contactTypes as $contactType){
                    foreach ($contactType as $contact){
                        $text = $contact . ', ';
                    }
                }
            }

            echo substr($text, 0, -2);
            ?>
        </td>
    <?php } ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopclient/edit', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopclient/clone', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-black text-sm"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclient/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopclient/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
