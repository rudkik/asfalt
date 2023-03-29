<table class="table-input table table-hover table-db table-tr-line" data-action="table-select">
    <tr class="bg-light-blue-active">
        <th class="width-30 text-right">№</th>
        <th>Продукт</th>
        <th class="width-80 text-right">Кол-во</th>
        <th class="width-80 text-right">Цена</th>
        <th class="width-80 text-right">Сумма</th>
        <th class="width-80 text-right">Коэф. ревизии</th>
        <th style="width: 162px;">Рубрика</th>
        <th style="width: 162px;">Единица измерения</th>
        <th>Продукция</th>
        <th class="width-80 text-right">Цена</th>
        <th class="width-80 text-right">Вес нетто (кг)</th>
        <th class="width-80 text-right">Коэф. рубрики</th>
        <th class="width-60 text-right">Коэф.</th>
        <th style="width: 162px;">Рубрика</th>
        <th style="width: 162px;">Единица измерения</th>
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