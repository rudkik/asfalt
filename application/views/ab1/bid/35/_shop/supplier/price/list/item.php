<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Продукт</th>
        <th class="width-110">Цена</th>
        <th class="tr-header-buttom"></th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/supplier/price/one/item']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div id="new-product" data-index="0">
    <!--
    <tr>
        <td>
            <select name="shop_supplier_prices[_#index#][shop_product_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
            </select>
        </td>
        <td>
            <input name="shop_supplier_prices[_#index#][price]" type="text" class="form-control" placeholder="Цена" required value="0">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>