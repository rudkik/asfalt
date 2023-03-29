<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopaddresscontact/edit', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal">
    </td>
    <td><?php echo $data->id; ?></td>
    <?php if ((Func::isShopMenu('shopaddresscontact/city', $siteData))){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.land_id.name', '').' '.Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.city_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopaddresscontact/rubric', $siteData)){ ?>
        <td><?php $s = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); if(empty($s)){echo 'Верхнего уровня';}else{echo $s;}  ?></td>
    <?php } ?>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.contact_type_id.name', ''); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <?php if ((Func::isShopMenu('shopaddresscontact/text', $siteData))
        || (Func::isShopMenu('shopaddresscontact/text-html', $siteData))){ ?>
        <td><?php echo $data->values['text']; ?></td>
    <?php } ?>
    <td>
        <input data-id="order" name="order[<?php echo $data->id; ?>]" value="<?php echo $data->values['order']; ?>" hidden>
        <ul class="list-inline tr-button sort-btn">
            <li><a data-id="up" href="" class="link-blue text-sm"><i class="fa fa-angle-up margin-r-5"></i> Вверх</a></li>
            <li><a data-id="down" href="" class="link-blue text-sm"><i class="fa fa-angle-down margin-r-5"></i> Вниз</a></li>
        </ul>
        <ul class="list-inline tr-button sort-btn">
            <li><a data-id="up-first"  href="" class="link-blue text-sm"><i class="fa fa-angle-double-up margin-r-5"></i> Начало</a></li>
            <li><a data-id="down-last" href="" class="link-blue text-sm"><i class="fa fa-angle-double-down margin-r-5"></i> Конец</a></li>
        </ul>
    </td>
</tr>