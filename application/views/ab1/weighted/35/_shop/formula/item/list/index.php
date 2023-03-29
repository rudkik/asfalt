<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>Материал</th>
        <th class="tr-header-amount">Норма</th>
        <th class="tr-header-buttom"></th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/formula/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div id="new-product" data-index="0">
    <!--
    <tr>
        <td>
            <select data-action="calc" name="shop_formula_items[_#index#][shop_material_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-action="calc" name="shop_formula_items[_#index#][norm]" type="text" class="form-control" placeholder="Норма" required value="0">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>