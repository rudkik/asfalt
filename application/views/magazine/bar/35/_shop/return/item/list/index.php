<table class="table table-hover table-db table-tr-line" data-action="table-select">
    <tr class="bg-light-blue-active">
        <th class="width-30 text-right">№</th>
        <th class="width-80">Дата</th>
        <th>Продукт</th>
        <th class="tr-header-amount text-right">Цена</th>
        <th style="width: 140px;" class="text-center">Кол-во</th>
        <th class="tr-header-amount text-right">Сумма</th>
        <th style="width: 64px;"></th>
    </tr>
    <tbody id="products">
    <?php
    $i = 0;
    foreach ($data['view::_shop/return/item/one/index']->childs as $value) {
        $i++;
        echo str_replace('$index$', $i, $value->str);
    }
    ?>
    </tbody>
</table>
<div id="new-product" data-index="0">
    <!--
    <tr data-action="tr">
        <td data-id="index" class="text-right"></td>
        <td></td>
        <td>
            <span data-id="shop_product_name">Продукт</span>
            <input data-id="shop_product_id" name="shop_return_items[_#index#][shop_product_id]" value="0" hidden>
        </td>
        <td>
            <input data-action="tr-multiply" data-total="#total" data-parent-count="2" name="shop_return_items[_#index#][price]" type="tel" class="form-control money-format text-right" placeholder="Цена" required>
        </td>
        <td>
            <div class="input-group">
                <div class="input-group-btn">
                    <button data-action="count-plus" data-value="-1" data-count="count" data-parent-count="2" type="button" class="btn bg-green btn-flat">-</button>
                </div>
                <input data-id="count" data-action="tr-multiply" data-total="#total" data-parent-count="3" name="shop_return_items[_#index#][quantity]" type="tel" class="form-control text-center" placeholder="Кол-во" required value="1">
                <div class="input-group-btn">
                    <button data-action="count-plus"data-count="count" data-parent-count="2" type="button" class="btn bg-green btn-flat">+</button>
                </div>
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