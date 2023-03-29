<tr>
    <td>
        <input style="width: 40px" data-action="set-checkbox" <?php if ($data->values['is_wage'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-field="is_wage" data-id="<?php echo $data->id; ?>">
    </td>
    <td>
        <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/edit', ['id' => 'shop_transport_waybill_id'], ['is_show' => true], $data->values); ?>">
            <?php echo $data->getElementValue('shop_transport_waybill_id', 'number');?>
        </a>
    </td>
    <td>
        <?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_transport_id');?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_transport_id', 'number');?>
    </td>
    <td>
        <?php
        if($data->values['shop_daughter_from_id'] > 0){
            echo $data->getElementValue('shop_daughter_from_id');
        }elseif($data->values['shop_branch_from_id'] > 0){
            echo $data->getElementValue('shop_branch_from_id');
        }elseif($data->values['shop_ballast_crusher_from_id'] > 0){
            echo $data->getElementValue('shop_ballast_crusher_from_id');
        }
        ?>
    </td>
    <td>
        <?php
        if($data->values['shop_client_to_id'] > 0){
            echo $data->getElementValue('shop_client_to_id');
        }elseif($data->values['shop_move_client_to_id'] > 0){
            echo $data->getElementValue('shop_move_client_to_id');
        }elseif($data->values['shop_branch_to_id'] > 0){
            echo $data->getElementValue('shop_branch_to_id');
        }elseif($data->values['shop_ballast_crusher_to_id'] > 0){
            echo $data->getElementValue('shop_ballast_crusher_to_id');
        }elseif($data->values['shop_transportation_place_to_id'] > 0){
            echo $data->getElementValue('shop_transportation_place_to_id');
        }elseif($data->values['shop_move_place_to_id'] > 0){
            echo $data->getElementValue('shop_move_place_to_id');
        }elseif($data->values['shop_storage_to_id'] > 0){
            echo $data->getElementValue('shop_storage_to_id');
        }else{
            echo $data->values['to_name'];
        }
        ?>
    </td>
    <td>
        <?php
        if($data->values['shop_material_id'] > 0){
            echo $data->getElementValue('shop_material_id');
        }elseif($data->values['shop_raw_id'] > 0){
            echo $data->getElementValue('shop_raw_id');
        }elseif($data->values['shop_product_id'] > 0){
            echo $data->getElementValue('shop_product_id');
        }elseif($data->values['shop_material_other_id'] > 0){
            echo $data->getElementValue('shop_material_other_id');
        }else{
            echo $data->values['product_name'];
        }
        ?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_transport_route_id');?>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" type="text" class="form-control" placeholder="Коэффициент"
               value="<?php echo htmlspecialchars($data->values['coefficient'], ENT_QUOTES); ?>"
               href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/save_coefficient', array('id' => 'id'), array(), $data->values); ?>"
               data-parent="tr" data-edit-field-1="wage"
               data-action="save-field" data-field="coefficient" data-id="<?php echo $data->id; ?>">
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['count_trip'], true, 0, true); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['distance'], true, 2, false); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?>
    </td>
    <td class="text-right" data-id="wage">
        <?php echo Func::getNumberStr($data->values['wage'], true, 2, false); ?>
    </td>
</tr>