<input name="shop_bill_items[]" style="display: none">
<table class="table table-striped table-bordered table-hover">
    <tr>
        <th>Продукт</th>
        <th class="width-120">Цена</th>
        <th class="width-120">Кол-во</th>
        <th class="width-110">Сумма</th>
        <th class="width-110">Коммисия источника</th>
        <th class="width-100"></th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/bill/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div class="modal-footer text-center">
    <button type="button" class="btn btn-green" onclick="addElement('new-product', 'products', true);">Добавить товар</button>
</div>
<div id="new-product" data-index="0">
    <!--
    <tr>
        <td>
            <select data-basic-url="market" data-type="select2" data-action="product" name="shop_bill_items[_#index#][shop_product_id]" class="form-control select2" required style="width: 100%;">
            </select>
        </td>
        <td>
            <input data-action="price-edit" data-id="price" name="shop_bill_items[_#index#][price]" type="text" class="form-control" placeholder="Цена" required value="">
        </td>
        <td>
            <input data-action="quantity-edit" data-id="quantity" name="shop_bill_items[_#index#][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="">
        </td>
        <td>
            <input data-id="amount" name="shop_bill_items[_#index#][amount]" type="text" class="form-control" readonly value="">
        </td>
        <td>
            <input name="shop_bill_items[_#index#][commission_source]" type="text" class="form-control" placeholder="Коммисия источника">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" href="#" data-parent-count="4" class="link-red text-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>