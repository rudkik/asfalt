<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Поставщик</th>
        <th>Сырье</th>
        <th class="width-120">Дата отгрузки</th>
        <th class="width-80">№ вагона</th>
        <th class="width-80 text-right">Тоннаж</th>
        <th class="width-120">Дата подачи</th>
        <th class="width-138">Дата начала слива</th>
    </tr>
    <?php
    foreach ($data['view::_shop/boxcar/one/unload']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>

