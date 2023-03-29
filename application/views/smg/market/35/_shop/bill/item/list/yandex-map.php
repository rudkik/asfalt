<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="text-right width-40">№</th>
        <th>Адрес</th>
        <th class="width-170">Вид адреса</th>
        <th>Товар</th>
        <th>Комментарий</th>
        <th>Ошибка</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    foreach ($data['view::_shop/bill/item/one/yandex-map']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    ?>
    </tbody>
</table>