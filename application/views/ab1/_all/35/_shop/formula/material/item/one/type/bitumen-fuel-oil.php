<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
<tr>
    <td>
        <select name="shop_formula_items[<?php echo $data->id; ?>][shop_raw_id]" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_raw_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/raw/list/list']);
            ?>
        </select>
    </td>
    <td colspan="2">
        <input data-type="money" data-fractional-length="2" name="shop_formula_items[<?php echo $data->id; ?>][options][norm_percent]" type="text" class="form-control text-right" placeholder="Расход (%)" required value="<?php echo Arr::path($data->values['options'], 'norm_percent', ''); ?>" readonly>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" name="shop_formula_items[<?php echo $data->id; ?>][options][norm_weight_from]" type="text" class="form-control text-right" placeholder="Расход (вес)" required value="<?php echo Arr::path($data->values['options'], 'norm_weight_from', ''); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" name="shop_formula_items[<?php echo $data->id; ?>][options][norm_weight_to]" type="text" class="form-control text-right" placeholder="Расход (вес)" required value="<?php echo Arr::path($data->values['options'], 'norm_weight_to', ''); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" name="shop_formula_items[<?php echo $data->id; ?>][norm_weight]" type="text" class="form-control text-right" placeholder="Расход (вес)" required value="<?php echo $data->values['norm_weight']; ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td></td>
</tr>