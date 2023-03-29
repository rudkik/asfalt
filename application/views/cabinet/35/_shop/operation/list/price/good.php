<table class="table table-hover table-db">
    <tr>
        <th class="tr-header-id">ID</th>
        <th>Оператор</th>
        <th class="tr-header-amount">Цена</th>
    </tr>
    <?php
    foreach ($data['view::_shop/operation/one/price/good']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>