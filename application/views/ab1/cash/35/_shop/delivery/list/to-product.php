<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Доставка</th>
        <th class="tr-header-amount">Связь?</th>
    </tr>
    <?php
    foreach ($data['view::_shop/delivery/one/to-product']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
