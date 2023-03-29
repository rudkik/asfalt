<table class="table-input table table-hover table-db table-tr-line" data-action="table-select">
    <tr class="bg-light-blue-active">
        <th class="width-75">Приемка</th>
        <th class="width-30 text-right">№</th>
        <th>Продукция</th>
        <th class="width-100 text-right">Приход</th>
        <th class="width-100 text-right">Кол-во</th>
        <th class="width-100 text-right">Цена</th>
        <th class="width-100 text-right">Сумма</th>
    </tr>
    <tbody id="products">
    <?php
    $i = 0;
    foreach ($data['view::_shop/realization/item/one/invoice']->childs as $value) {
        $i++;
        echo str_replace('#index#', $i, $value->str);
    }
    ?>
    </tbody>
</table>
<style>
    .icheckbox_minimal-blue.checked.disabled {
        background-position: -40px 0 !important;
    }
</style>