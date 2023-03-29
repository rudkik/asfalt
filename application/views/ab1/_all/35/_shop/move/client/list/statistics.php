<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Продукция</th>
        <th class="width-120 text-right">Сегодня (т)</th>
        <th class="width-120 text-right">Вчера (т)</th>
        <th class="width-120 text-right">Неделя (т)</th>
        <th class="width-120 text-right">Месяц (т)</th>
        <th class="width-120 text-right">Прошлый месяц (т)</th>
        <th class="width-120 text-right">Год (т)</th>
    </tr>
    <?php
    foreach ($data['view::_shop/move/client/one/statistics']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>

