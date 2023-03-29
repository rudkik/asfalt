<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Материал</th>
        <th class="width-120">Ед.измерения</th>
        <th class="width-105">Кол-во</th>
        <th class="width-105">Цена</th>
        <th class="width-105">Сумма</th>
    </tr>
    <tbody id="contracts">
    <?php
    foreach ($data['view::_shop/client/contract/one/agreement/material']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>