<table class="table table-hover table-db">
    <tr>
        <th class="tr-header-id">ID</th>
        <th class="tr-header-photo">Фото</th>
        <th>Товар</th>
        <th class="tr-header-amount">Цена</th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/one/price/operation']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>