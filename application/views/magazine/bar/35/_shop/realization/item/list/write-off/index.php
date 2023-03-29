<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<table class="table-input table table-hover table-db table-tr-line" data-action="table-select">
    <tr class="bg-light-blue-active b-purple">
        <th class="width-30 text-right">№</th>
        <th>Продукция</th>
        <th class="tr-quantity-price text-center">Кол-во / Цена</th>
        <th class="width-70 text-right">Сумма</th>
        <?php if(!$isShow){ ?>
            <th style="width: 64px;"></th>
        <?php }?>
    </tr>
    <tbody id="products">
    <?php
    $i = 0;
    foreach ($data['view::_shop/realization/item/one/write-off/index']->childs as $value) {
        $i++;
        echo str_replace('#index#', $i, $value->str);
    }
    ?>
    </tbody>
</table>
<div id="new-product" data-index="0">
    <!--
    <tr data-barcode="#barcode#" data-action="tr">
        <td data-id="index" class="text-right"></td>
        <td>
            <span data-id="shop_product_name">Продукт</span>
            <input data-id="shop_product_id" name="shop_realization_items[_#index#][shop_production_id]" value="0" hidden>
        </td>
        <td class="text-center">
            <div class="box-quantity">
                <input data-round="1" data-keywords="virtual" data-id="quantity" data-keywords="virtual" data-action="tr-multiply" data-total="#total" data-parent-count="3" name="shop_realization_items[_#index#][quantity]" type="tel" class="form-control text-center" placeholder="Кол-во" required value="1">
            </div>
            <div class="box-price">
                <input data-round="1" data-keywords="virtual" data-id="price_average" data-keywords="virtual" data-action="tr-multiply" data-parent-count="3" name="shop_realization_items[_#index#][price]" type="tel" class="form-control text-center" placeholder="Цена" required>
            </div>
        </td>
        <td data-id="total" class="text-right">0</td>
        <td class="text-center">
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>