<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
<tr>
    <td>
        <select data-id="material" name="shop_formula_sides[<?php echo $data->id; ?>][shop_material_id]" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
            <option value="0" data-id="0">Без значения</option>
            <?php
            $s = 'data-id="'.$data->values['shop_material_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/material/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" name="shop_formula_sides[<?php echo $data->id; ?>][norm]" type="text" class="form-control" placeholder="Норма (%)" required value="<?php echo Func::getNumberStr($data->values['norm'], FALSE); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" name="shop_formula_sides[<?php echo $data->id; ?>][norm_weight]" type="text" class="form-control" placeholder="Вес (кг)" required value="<?php echo Func::getNumberStr($data->values['norm_weight'], FALSE); ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <?php if(!$isShow){ ?>
        <td>
            <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    <?php } ?>
</tr>
