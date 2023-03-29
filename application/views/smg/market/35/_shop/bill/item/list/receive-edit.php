<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-40 text-right">№</th>
        <th class="width-130">Дата заказа</th>
        <th class="width-100">№ товара</th>
        <th class="width-100">№ заказа</th>
        <th class="width-70">
            Фото
        </th>
        <th>Название</th>
        <th class="text-right width-80">Кол-во</th>
        <th class="text-right width-120">Цена закупа</th>
        <th class="text-right width-120">Сумма</th>
    </tr>
    </thead>
    <tbody id="receive-edit">
    <?php
    $i = 1;
    foreach ($data['view::_shop/bill/item/one/receive-edit']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    ?>
    </tbody>
</table>