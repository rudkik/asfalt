<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Продукт</th>
        <th class="tr-header-amount">Вес</th>
        <th class="width-120">Сумма</th>
        <th>Доверенность</th>
        <th class="width-240">Договор</th>
        <th class="width-85"></th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/piece/item/one/attorney']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div id="new-product" data-index="0">
    <!--
    <tr>
        <td>
            <select data-action="calc-piece" name="shop_piece_items[_#index#][shop_product_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-action="calc-piece" name="shop_piece_items[_#index#][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="0">
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-id="amount" data-amount="0" name="shop_piece_items[_#index#][amount]" disabled type="text" class="form-control" value="0">
        </td>
        <td>
            <select data-action="calc-piece" name="shop_piece_items[_#index#][shop_product_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
            </select>
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>