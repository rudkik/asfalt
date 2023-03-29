<table class="table-input table table-hover table-db table-tr-line" data-action="table-select">
    <tr class="bg-light-blue-active">
        <th class="width-30 text-right">№</th>
        <th>Продукт</th>
        <th class="width-80 text-right">Кол-во</th>
        <th class="width-80 text-right">Цена</th>
        <th class="width-80 text-right">Сумма</th>
        <th>Продукция</th>
        <th class="width-80 text-right">Цена</th>
        <th class="width-110 text-right">Коэффициент</th>
    </tr>
    <tbody id="products">
    <?php
    $i = 0;
    foreach ($data['view::_shop/receive/item/one/production']->childs as $value) {
        $i++;
        echo str_replace('$index$', $i, $value->str);
    }
    ?>
    </tbody>
</table>