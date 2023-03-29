<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Поставщик</th>
        <th>Сырье</th>
        <th>Тоннаж с начала месяца</th>
        <th>Тоннаж c начала года</th>
    </tr>
    <?php
    foreach ($data['view::_shop/boxcar/one/statistics']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>

