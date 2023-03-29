<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
<?php if(Arr::path($data->values['options'], 'is_bitumen', '0') == 0){ ?>
    <tr>
        <td>
            <select name="shop_formula_items[<?php echo $data->id; ?>][shop_material_id]" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
                <option value="0" data-id="0">Без значения</option>
                <?php
                $s = 'data-id="'.$data->values['shop_material_id'].'"';
                echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/material/list/list']);
                ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-id="norm_percent" name="shop_formula_items[<?php echo $data->id; ?>][options][norm_percent]" type="text" class="form-control text-right" placeholder="Расход (%)" required value="<?php echo Arr::path($data->values['options'], 'norm_percent', ''); ?>" readonly>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight" name="shop_formula_items[<?php echo $data->id; ?>][norm_weight]" type="text" class="form-control text-right" placeholder="Расход (вес)" required value="<?php echo Func::getNumberStr($data->values['norm_weight'], false, 10, true); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
        </td>
        <td>
            <input data-type="money" data-action="calc-asphalt" data-id="losses" name="shop_formula_items[<?php echo $data->id; ?>][losses]" type="text" class="form-control text-right" placeholder="Потери (%)" required value="<?php echo Func::getNumberStr($data->values['losses'], false, 10, true); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-id="losses_weight" name="shop_formula_items[<?php echo $data->id; ?>][options][losses_weight]" type="text" class="form-control text-right" placeholder="Потери (кг)" required value="<?php echo Arr::path($data->values['options'], 'losses_weight', ''); ?>" readonly>
        </td>
        <td>
            <input data-type="money" data-id="norm_industrial" name="shop_formula_items[<?php echo $data->id; ?>][options][norm_industrial]" type="text" class="form-control text-right" placeholder="Производственные нормы кг)" required value="<?php echo Arr::path($data->values['options'], 'norm_industrial', ''); ?>" readonly>
        </td>
        <?php if(!$isShow){ ?>
            <td>
                <input data-id="is_bitumen" name="shop_formula_items[<?php echo $data->id; ?>][options][is_bitumen]" value="<?php echo Arr::path($data->values['options'], 'is_bitumen', '0'); ?>" style="display: none">
                <ul class="list-inline tr-button delete">
                    <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                </ul>
            </td>
        <?php } ?>
    </tr>
<?php }else{ ?>
    <tr style="background-color: rgba(97, 106, 168, 0.3);">
        <td>
            <select name="shop_formula_items[<?php echo $data->id; ?>][shop_material_id]" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
                <option value="0" data-id="0">Без значения</option>
                <?php
                $s = 'data-id="'.$data->values['shop_material_id'].'"';
                echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/material/list/list']);
                ?>
            </select>
        </td>
        <td>
            <input data-id="norm_percent" name="shop_formula_items[<?php echo $data->id; ?>][options][norm_percent]" type="text" class="form-control text-right" placeholder="Расход (%)" required value="<?php echo Arr::path($data->values['options'], 'norm_percent', ''); ?>" readonly>
        </td>
        <td>
            <input data-action="calc-asphalt" data-id="norm_weight" name="shop_formula_items[<?php echo $data->id; ?>][norm_weight]" type="text" class="form-control text-right" placeholder="Расход (вес)" required value="<?php echo Func::getNumberStr($data->values['norm_weight'], false, 10, true); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
        </td>
        <td>
            <input data-action="calc-asphalt" data-id="losses" name="shop_formula_items[<?php echo $data->id; ?>][losses]" type="text" class="form-control text-right" placeholder="Потери (%)" required value="<?php echo Func::getNumberStr($data->values['losses'], false, 10, true); ?>" readonly>
        </td>
        <td>
            <input data-id="losses_weight" name="shop_formula_items[<?php echo $data->id; ?>][options][losses_weight]" type="text" class="form-control text-right" placeholder="Потери (кг)" required value="<?php echo Arr::path($data->values['options'], 'losses_weight', ''); ?>" readonly>
        </td>
        <td>
            <input data-id="norm_industrial" name="shop_formula_items[<?php echo $data->id; ?>][options][norm_industrial]" type="text" class="form-control text-right" placeholder="Производственные нормы кг)" required value="<?php echo Arr::path($data->values['options'], 'norm_industrial', ''); ?>" readonly>
        </td>
        <?php if(!$isShow){ ?>
            <td>
                <input data-id="is_bitumen" name="shop_formula_items[<?php echo $data->id; ?>][options][is_bitumen]" value="<?php echo Arr::path($data->values['options'], 'is_bitumen', '1'); ?>" style="display: none">
                <ul class="list-inline tr-button delete">
                    <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                </ul>
            </td>
        <?php } ?>
    </tr>
<?php } ?>