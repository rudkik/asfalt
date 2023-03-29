<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<tr>
    <td class="text-right">#index#</td>
    <td>
        <input data-action="set-checkbox" <?php if ($data->values['is_wage'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-field="is_wage" data-id="<?php echo $data->id; ?>">
    </td>
    <?php if($data->values['is_hand'] && !$isShow){ ?>
        <td>
            <?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>
        </td>
        <td>
            <select name="hand_shop_transport_waybill_cars[<?php echo $data->id; ?>][shop_branch_from_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Выберите значение</option>
                <?php
                $tmp = 'data-id="'.$data->values['shop_branch_from_id'].'"';
                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                ?>
            </select>
        </td>
        <td>
            <input name="hand_shop_transport_waybill_cars[<?php echo $data->id; ?>][to_name]" type="text" class="form-control" placeholder="Пункт назначения" value="<?php echo htmlspecialchars($data->values['to_name'], ENT_QUOTES); ?>">
        </td>
        <td>
            <input name="hand_shop_transport_waybill_cars[<?php echo $data->id; ?>][product_name]" type="text" class="form-control" placeholder="Наименование груза" value="<?php echo htmlspecialchars($data->values['product_name'], ENT_QUOTES); ?>">
        </td>
        <td>
            <select name="hand_shop_transport_waybill_cars[<?php echo $data->id; ?>][shop_transport_route_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Выберите значение</option>
                <?php
                $tmp = 'data-id="'.$data->values['shop_transport_route_id'].'"';
                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/transport/route/list/list']));
                ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" name="hand_shop_transport_waybill_cars[<?php echo $data->id; ?>][coefficient]" type="text" class="form-control" placeholder="Коэффициент" value="<?php echo htmlspecialchars($data->values['coefficient'], ENT_QUOTES); ?>">
        </td>
        <td>
            <input data-type="money" data-fractional-length="0" name="hand_shop_transport_waybill_cars[<?php echo $data->id; ?>][count_trip]" type="text" class="form-control" placeholder="Кол-во рейсов" value="<?php echo htmlspecialchars($data->values['count_trip'], ENT_QUOTES); ?>">
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" name="hand_shop_transport_waybill_cars[<?php echo $data->id; ?>][distance]" type="text" class="form-control" placeholder="Расстояние, км" value="<?php echo htmlspecialchars($data->values['distance'], ENT_QUOTES); ?>">
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" name="hand_shop_transport_waybill_cars[<?php echo $data->id; ?>][quantity]" type="text" class="form-control" placeholder="Масса" value="<?php echo htmlspecialchars($data->values['quantity'], ENT_QUOTES); ?>">
        </td>
        <?php if($isShow || $siteData->operation->getIsAdmin()){ ?>
            <td>
                <input name="hand_shop_transport_waybill_cars[<?php echo $data->id; ?>][wage]" type="text" class="form-control" placeholder="Стоимость рейса" value="<?php echo htmlspecialchars($data->values['wage'], ENT_QUOTES); ?>">
            </td>
        <?php } ?>
        <td>
            <ul class="list-inline tr-button delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    <?php }else{ ?>
        <td>
            <?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>
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
        <?php if($isShow || $siteData->operation->getIsAdmin()){ ?>
            <td class="text-right" data-id="wage">
                <?php echo Func::getNumberStr($data->values['wage'], true, 2, false); ?>
            </td>
        <?php } ?>
        <td></td>
    <?php } ?>
</tr>