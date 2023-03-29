<table class="table table-hover table-db table-tr-line" data-action="table-select">
    <tr class="bg-light-blue-active">
        <th class="width-80">Дата</th>
        <th>Продукция</th>
        <th style="width: 140px;" class="text-center">Кол-во</th>
        <th style="width: 64px;"></th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/move/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div id="new-product" data-index="0">
    <!--
    <tr>
        <td></td>
        <td>
            <span data-id="shop_product_name">Продукт</span>
            <input data-id="shop_product_id" name="shop_move_items[_#index#][shop_production_id]" value="0" hidden>
        </td>
        <td>
            <div class="input-group">
                <div class="input-group-btn">
                    <button data-action="count-plus" data-value="-1" data-count="count" data-parent-count="2" type="button" class="btn bg-green btn-flat">-</button>
                </div>
                <input data-id="count" name="shop_move_items[_#index#][quantity]" type="tel" class="form-control text-center" placeholder="Кол-во" required value="1">
                <div class="input-group-btn">
                    <button data-action="count-plus"data-count="count" data-parent-count="2" type="button" class="btn bg-green btn-flat">+</button>
                </div>
            </div>
        </td>
        <td class="text-center">
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>