<table class="table table-hover table-db table-tr-line" style="max-width: 565px">
    <tr>
        <th rowspan="2" class="width-80">День</th>
        <th colspan="2" class="text-center">Итоги дня</th>
        <th colspan="2" class="text-center">Без накладной</th>
        <th rowspan="2" class="width-125"></th>
    </tr>
    <tr>
        <th class="width-80 text-right">Кол-во</th>
        <th class="width-100 text-right">Сумма</th>
        <th class="width-80 text-right">Кол-во</th>
        <th class="width-100 text-right">Сумма</th>
    </tr>
    <?php
    foreach ($data['view::_shop/invoice/one/days']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>

