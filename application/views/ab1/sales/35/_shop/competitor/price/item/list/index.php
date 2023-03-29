<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th>Продукт</th>
        <th class="width-110">Цена</th>
        <th class="tr-header-amount">Доставка</th>
        <th style="width: 124px;">Доставка ЖД</th>
        <th class="tr-header-amount">Мощность</th>
        <th class="width-85"></th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/competitor/price/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div class="modal-footer text-center">
    <button type="button" class="btn btn-danger" onclick="addElement('new-product', 'products', true);">Добавить продукт</button>
</div>
<div id="new-product" data-index="0">
    <!--
    <tr>
        <td>
            <select name="shop_competitor_price_items[_#index#][shop_product_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" name="shop_competitor_price_items[_#index#][price]" type="text" class="form-control" placeholder="Цена" required value="0">
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" name="shop_competitor_price_items[_#index#][delivery]" type="text" class="form-control" placeholder="Доставка" required value="0">
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" name="shop_competitor_price_items[_#index#][delivery_zhd]" type="text" class="form-control" placeholder="Доставка ЖД" required value="0">
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" name="shop_competitor_price_items[_#index#][product_capacity]" type="text" class="form-control" placeholder="Производственная мощность" required value="0">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>