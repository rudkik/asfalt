<table class="table-input table table-hover table-db table-tr-line" data-action="table-select">
    <tr class="bg-light-blue-active">
        <th class="width-30 text-right">№</th>
        <th class="width-115">Дата</th>
        <th class="width-95 text-right">Кол-во</th>
        <th class="width-95 text-right">Цена</th>
        <th class="width-95 text-right">Сумма</th>
        <th>Вид операции</th>
        <th>Примечание</th>
    </tr>
    <tbody id="products">
    <?php
    $i = 0;
    foreach ($data['view::_shop/product/one/history']->childs as $value) {
        $i++;
        echo str_replace('$index$', $i, $value->str);
    }
    ?>
    </tbody>
</table>