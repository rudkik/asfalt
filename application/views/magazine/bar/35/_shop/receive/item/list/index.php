<table class="table-input table table-hover table-db table-tr-line" data-action="table-select">
    <tr class="bg-light-blue-active">
        <th class="width-30 text-right">№</th>
        <th class="width-30"></th>
        <th>Продукт</th>
        <th class="tr-quantity-price text-center">Кол-во / Цена</th>
        <th class="width-70 text-right">Сумма</th>
        <th style="width: 90px;"></th>
    </tr>
    <tbody id="products">
    <?php
    $i = 0;
    foreach ($data['view::_shop/receive/item/one/index']->childs as $value) {
        $i++;
        echo str_replace('$index$', $i, $value->str);
    }
    ?>
    </tbody>
</table>
<div id="new-product" data-index="0">
    <!--
    <tr data-barcode="#barcode#" data-action="tr">
        <td data-id="index" class="text-right"></td>
        <td class="relative">
            <i data-action="load-photo-click" class="fa fa-fw fa-camera" style="font-size: 20px;"></i>
            <i data-id="img-status" class="fa fa-fw fa-check is-image" data-img="true"></i>
            <input data-id="#shop_product_id#" data-action="load-photo" data-id="file" type="file" multiple="multiple" accept=".txt,image/*" style="display: none">
        </td>
        <td>
            <a target="_blank" href="/bar/shopproduction/index?shop_product_id=#shop_product_id#">
                <span data-id="shop_product_name">Продукт</span>
            </a>
            <br><span data-id="barcode"></span>
            <input data-id="shop_product_id" name="shop_receive_items[_#index#][shop_product_id]" value="0" hidden>
        </td>
        <td>
            <div class="box-quantity">
                <input <?php if($siteData->action == 'new') { ?>data-active-save="receive"<?php } ?> data-id="quantity" data-keywords="virtual" data-action="tr-multiply" data-total="#total" data-parent-count="3" name="shop_receive_items[_#index#][quantity]" type="tel" class="form-control text-center" placeholder="Кол-во" required value="1">
            </div>
            <div class="box-price">
                <input <?php if($siteData->action == 'new') { ?>data-active-save="receive"<?php } ?> data-keywords="virtual" data-id="price_purchase" data-action="tr-multiply" data-total="#total" data-parent-count="3" name="shop_receive_items[_#index#][price]" type="tel" class="form-control money-format text-right" placeholder="Цена" required>
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