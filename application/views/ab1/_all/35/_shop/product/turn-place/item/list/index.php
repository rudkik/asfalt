<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>Продукт</th>
        <th class="width-120 text-right">Норма времени на единицу</th>
        <th class="width-120 text-right">Расценка на единицу</th>
        <?php if(!$isShow){?>
            <th style="width: 89px;"></th>
        <?php }?>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/product/turn-place/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){?>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" onclick="addElement('new-product', 'products', true);">Добавить продукцию</button>
    </div>
    <div id="new-product" data-index="0">
        <!--
        <tr>
            <td>
                <select data-id="shop_product_id" name="shop_product_turn_place_items[_#index#][shop_product_id]" class="form-control select2" style="width: 100%">
                    <option value="0" data-id="0">Все</option>
                    <?php echo $siteData->globalDatas['view::_shop/product/list/list'];?>
                </select>
            </td>
            <td>
                <input data-type="money" name="shop_product_turn_place_items[_#index#][norm]" type="text" class="form-control" placeholder="Норма времени на единицу" value="">
            </td>
            <td>
                <input data-type="money" data-fractional-length="2" name="shop_product_turn_place_items[_#index#][price]" type="text" class="form-control" placeholder="Расценка на единицу">
            </td>
            <td>
                <ul class="list-inline tr-button delete">
                    <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                </ul>
            </td>
        </tr>
        -->
    </div>
<?php }?>