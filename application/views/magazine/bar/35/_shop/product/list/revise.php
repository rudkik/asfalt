<table class="table table-hover table-db table-tr-line table-input" data-action="table-select">
    <tr class="bg-light-blue-active">
        <th class="width-30 text-right">№</th>
        <th>Продукт</th>
        <th style="width: 142px;" class="text-center">Фактическое</th>
        <th class="width-80 text-right">Текущее</th>
        <th class="width-80 text-right">Разница</th>
        <th style="width: 64px;"></th>
    </tr>
    <tbody id="products">
    <?php
    $i = 0;
    foreach ($data['view::_shop/product/one/revise']->childs as $value) {
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
        <td>
            <span data-id="shop_product_name">Продукт</span>
            <input data-id="shop_product_id" name="shop_revise_items[_#index#][shop_product_id]" value="0" hidden>
        </td>
        <td>
            <div class="input-group">
                <div class="input-group-btn">
                    <button data-action="count-plus" data-value="-1" data-count="count" data-parent-count="4" type="button" class="btn bg-green btn-flat">-</button>
                </div>
                <input data-action="diff" data-parent-count="3" data-id="count" name="shop_revise_items[_#index#][quantity_actual]" type="tel" class="form-control text-center" placeholder="Кол-во" required value="1">
                <div class="input-group-btn">
                    <button data-action="count-plus" data-count="count" data-parent-count="4" type="button" class="btn bg-green btn-flat">+</button>
                </div>
            </div>
        </td>
        <td data-id="quantity" class="text-right" value="0">0</td>
        <td data-id="diff" class="text-bold text-right"></td>
        <td class="text-center">
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>