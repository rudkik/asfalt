    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th class="width-30 text-right">№</th>
            <th class="width-120">Начало</th>
            <th class="width-120">Окончание</th>
            <th>Куда</th>
            <th>Адрес</th>
            <th>Прочее</th>
            <th class="width-110 text-right">Время</th>
            <th class="width-130 text-right">Расстояние (км)</th>
        </tr>
    <?php
    $i = 1;
    foreach ($data['view::_shop/courier/route/item/one/index']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    ?>
</table>