<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th>Клиент</th>
        <th class="width-105">Вид оплаты</th>
        <th class="width-110">Доверенность</th>
        <th class="width-120">Договор</th>
        <th class="width-100">Доставка</th>
        <th class="width-120">Вид продукции</th>
        <th class="text-right width-120">Сумма заказов</th>
        <th class="text-right width-110">Кол-во машин</th>
        <th class="text-right width-120">Остаток</th>
        <th class="text-right width-140">Наличные</th>
        <th class="width-105"></th>
        <th class="width-110"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/invoice/one/virtual/index']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>

