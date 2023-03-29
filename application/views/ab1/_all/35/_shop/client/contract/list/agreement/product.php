<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th style="width: 50%">Продукт</th>
        <th class="width-105">Кол-во</th>
        <th class="width-105">Цена</th>
        <th class="width-105">Сумма</th>
        <th class="width-105">Скидка (тг)</th>
        <th style="width: 88px;">Фикс. цена</th>
        <th class="width-105">Дата старта</th>
        <th class="width-110 text-right">Потрачено</th>
        <th class="width-110 text-right">Остаток</th>
    </tr>
    <tbody>
    <?php
    foreach ($data['view::_shop/client/contract/one/agreement/product']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>