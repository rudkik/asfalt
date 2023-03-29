<table id="receive-items" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-40 text-right">№</th>
        <th class="width-70 text-center">Расход</th>
        <th class="width-90 text-center">На складе</th>
        <th class="width-90 text-center">Возврат</th>
        <th class="width-100">№ товара</th>
        <th>Название</th>
        <th class="text-right width-80">Кол-во</th>
        <th class="text-right width-120">Цена закупа</th>
        <th class="text-right width-120">Сумма</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    foreach ($data['view::_shop/receive/item/one/index']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    ?>
    </tbody>
</table>