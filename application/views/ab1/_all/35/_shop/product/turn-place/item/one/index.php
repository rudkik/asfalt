<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<tr>
    <td>
        <select data-id="shop_product_id" name="shop_product_turn_place_items[<?php echo $data->values['id'];?>][shop_product_id]" class="form-control select2" style="width: 100%">
            <option value="0" data-id="0">Все</option>
            <?php
            $s = 'data-id="'.$data->values['shop_product_id'].'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/product/list/list']);
            ?>
        </select>
    </td>
    <td>
        <input data-type="money" name="shop_product_turn_place_items[<?php echo $data->values['id'];?>][norm]" type="text" class="form-control" placeholder="Норма времени на единицу" value="<?php echo $data->values['norm']; ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <td>
        <input data-type="money" data-fractional-length="2" name="shop_product_turn_place_items[<?php echo $data->id; ?>][price]" type="text" class="form-control" placeholder="Расценка на единицу" value="<?php echo $data->values['price']; ?>" <?php if($isShow){ ?>readonly<?php } ?>>
    </td>
    <?php if(!$isShow){?>
        <td>
            <ul class="list-inline tr-button delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    <?php }?>
</tr>