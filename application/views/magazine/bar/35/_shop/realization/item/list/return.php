<table class="table-input table table-hover table-db table-tr-line" data-action="table-select" style="position: inherit;">
    <tr class="bg-light-blue-active">
        <th class="width-30 text-right">№</th>
        <th>Продукция</th>
        <th class="tr-quantity-price text-center">Кол-во / Цена</th>
        <th class="width-70 text-right">Сумма</th>
    </tr>
    <tbody id="products">
    <?php
    $i = 0;
    foreach ($data['view::_shop/realization/item/one/return']->childs as $value) {
        $i++;
        echo str_replace('#index#', $i, $value->str);
    }
    ?>
    </tbody>
</table>