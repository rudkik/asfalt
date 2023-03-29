<tr id="<?php echo $data->values['id']; ?>"
    data-name="<?php echo $data->values['name']; ?>"
    data-tarra="<?php echo $data->values['tarra']; ?>"
    data-quantity="<?php if($data->values['quantity'] > 0){echo $data->values['quantity'];}else{echo $data->values['quantity_daughter'];} ?>">
    <td><img data-action="show-big" data-id="<?php echo $data->id; ?>" data-type="<?php echo Model_Ab1_Shop_Car_To_Material::TABLE_ID; ?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
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
    <td class="text-number"><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_material_id', 'name'); ?></td>
    <td class="text-right" <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php
        if($data->values['quantity'] > 0){
            echo Func::getNumberStr($data->values['tarra'] + $data->values['quantity'], false, 3, false);
        }else{
            echo Func::getNumberStr($data->values['tarra'] + $data->values['quantity_daughter'], false, 3, false);
        }
        ?></td>
    <td class="text-right" <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['tarra'], false, 3, false); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], false, 3, false); ?></td>
    <td class="text-right" data-id="quantity_daughter"><?php echo Func::getNumberStr($data->values['quantity_daughter'], false, 3, false); ?></td>
    <td class="text-right" data-id="quantity_invoice"><?php echo Func::getNumberStr($data->values['quantity_invoice'], false, 3, false); ?></td>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.weighted_operation_id.name', ''); ?></td>
    <?php } ?>
</tr>
