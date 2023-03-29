<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<tr>
    <td>
        <select name="shop_transport_sample_fuel_items[<?php echo $data->id; ?>][fuel_id]" class="form-control select2" required style="width: 100%;" <?php if($isShow){?>disabled<?php }?>>
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['fuel_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::fuel/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" name="shop_transport_sample_fuel_items[<?php echo $data->id; ?>][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" <?php if($isShow){?>disabled<?php }?>>
    </td>
    <td>
        <input name="shop_transport_sample_fuel_items[<?php echo $data->id; ?>][unit]" type="text" class="form-control" placeholder="Ед. измерения" required value="<?php echo htmlspecialchars($data->values['unit'], ENT_QUOTES);?>" <?php if($isShow){?>disabled<?php }?>>
    </td>
    <td>
        <?php if(!$isShow){?>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
        <?php }?>
    </td>
</tr>


