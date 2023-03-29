<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-40 text-right">№</th>
        <th>Название</th>
        <th class="text-right width-80">Кол-во</th>
        <th class="text-right width-120">Цена закупа</th>
        <th class="text-right width-120">Сумма</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    foreach ($data['view::_shop/receive/item/one/return']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    ?>
    </tbody>
</table>