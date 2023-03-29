<?php $isWeighted = Request_RequestParams::getParamBoolean('is_weighted'); ?>
<tr id="<?php echo $data->values['id']; ?>"
    data-name="<?php echo $data->values['name']; ?>"
    data-tarra="<?php echo $data->values['tarra']; ?>"
    data-quantity="<?php if($data->values['quantity'] > 0){echo $data->values['quantity'];}else{echo $data->values['quantity_daughter'];} ?>">
    <td><img data-action="show-big" data-id="<?php echo $data->id; ?>" data-type="<?php echo Model_Ab1_Shop_Car_To_Material::TABLE_ID; ?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_document']); ?></td>
    <td>
        <?php
        echo $data->getElementValue(
            'shop_branch_daughter_id',
            'name',
            $data->getElementValue(
                'shop_daughter_id',
                'name'
            )
        );
        ?><br>
        <?php echo $data->getElementValue('shop_subdivision_daughter_id', 'name'); ?><br>
        <?php echo $data->getElementValue('shop_heap_daughter_id', 'name'); ?>
    </td>
    <td>
        <?php
        echo $data->getElementValue(
            'shop_branch_receiver_id',
            'name',
            $data->getElementValue(
                'shop_client_material_id',
                'name'
            )
        );
        ?><br>
        <?php echo $data->getElementValue('shop_subdivision_receiver_id', 'name'); ?><br>
        <?php echo $data->getElementValue('shop_heap_receiver_id', 'name'); ?>
    </td>
    <?php if($isWeighted){ ?>
    <td>
        <?php echo $data->getElementValue('shop_transport_company_id', 'name'); ?>
    </td>
    <td class="text-number"><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_driver_id', 'name'); ?></td>
    <?php } ?>
    <td><?php echo $data->getElementValue('shop_material_id', 'name'); ?></td>
    <?php if($data->values['is_weighted'] == 1){ ?>
        <td class="text-right" <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>>
            <?php
            if($data->values['quantity'] > 0){
                echo Func::getNumberStr($data->values['tarra'] + $data->values['quantity'], true, 3, false);
            }else{
                echo Func::getNumberStr($data->values['tarra'] + $data->values['quantity_daughter'], true, 3, false);
            }
            ?>
        </td>
        <td <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['tarra'], true, 3, false); ?></td>
    <?php } ?>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <?php if($data->values['is_weighted'] == 1){ ?>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity_daughter'], true, 3, false); ?></td>
    <?php } ?>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.weighted_operation_id.name', ''); ?></td>
    <?php } ?>
    <?php if(!$isWeighted){ ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
    <?php } ?>
</tr>
