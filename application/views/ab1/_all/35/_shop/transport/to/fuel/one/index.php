<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<tr>
    <td>
        <select name="shop_transport_to_fuels[<?php echo $data->id; ?>][fuel_type_id]" class="form-control select2" style="width: 100%">
            <option value="0" data-id="0">Выберите значение</option>
            <?php
            $tmp = 'data-id="'.$data->values['fuel_type_id'].'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::fuel/type/list/list']));
            ?>
        </select>
    </td>
    <td>
        <select data-id="shop_transport_indicator_formula_id" name="shop_transport_to_fuels[<?php echo $data->id; ?>][shop_transport_indicator_formula_id]" class="form-control select2" style="width: 100%">
            <option value="0" data-id="0">Выберите значение</option>
            <?php
            $tmp = 'data-id="'.$data->values['shop_transport_indicator_formula_id'].'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/transport/indicator/formula/list/list']));
            ?>
        </select>
    </td>
    <td>
        <ul class="list-inline tr-button delete">
            <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>