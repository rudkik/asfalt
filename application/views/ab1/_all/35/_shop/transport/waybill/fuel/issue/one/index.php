<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<tr>
    <td>
        <select name="shop_transport_waybill_fuel_issues[<?php echo $data->id; ?>][fuel_id]" class="form-control select2" style="width: 100%" required <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Выберите значение</option>
            <?php
            $tmp = 'data-id="'.$data->values['fuel_id'].'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::fuel/list/list']));
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" data-id="quantity" name="shop_transport_waybill_fuel_issues[<?php echo $data->id; ?>][quantity]" type="phone" class="form-control" placeholder="Кол-во" value="<?php echo $data->values['quantity'];?>" required <?php if($isShow){?>readonly<?php }?>>
    </td>
    <td>
        <select name="shop_transport_waybill_fuel_issues[<?php echo $data->id; ?>][fuel_issue_id]" class="form-control select2" style="width: 100%" required <?php if($isShow){?>readonly="" <?php }?>>
            <option value="0" data-id="0">Выберите значение</option>
            <?php
            $tmp = 'data-id="'.$data->values['fuel_issue_id'].'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::fuel/issue/list/list']));
            ?>
        </select>
    </td>
    <?php if(!$isShow){?>
        <td>
            <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    <?php }?>
</tr>