<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>Рубрика</th>
        <th>Продукт</th>
        <th class="width-110">Скидка (тг)</th>
        <th class="width-105">Сумма</th>
        <th class="width-105 text-right">Потрачено</th>
        <th class="width-105 text-right">Остаток</th>
        <th style="width: 89px;"></th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/product-price/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addElement('new-product', 'products', true);">Добавить продукцию</button>
</div>
<div id="new-product" data-index="0">
    <!--
    <tr>
        <td>
            <select data-id="shop_product_rubric_id" name="shop_pricelist_items[_#index#][shop_product_rubric_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Все</option>
                <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list'];?>
            </select>
        </td>
        <td>
            <select data-id="shop_product_id" name="shop_pricelist_items[_#index#][shop_product_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Все</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/list'];?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" name="shop_pricelist_items[_#index#][discount]" type="text" class="form-control" placeholder="Скидка" value="">
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" name="shop_pricelist_items[_#index#][amount]" type="text" class="form-control" placeholder="Сумма">
        </td>
        <td></td>
        <td></td>
        <td>
            <ul class="list-inline tr-button delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>  
    </tr>
    -->
</div>