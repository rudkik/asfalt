<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th>Клиент</th>
        <th class="width-105">Вид оплаты</th>
        <th class="width-110">Доверенность</th>
        <th class="width-105">Договор</th>
        <th class="text-right width-120">Сумма</th>
        <th class="text-right width-110">Кол-во машин</th>
        <th style="width: 106px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/act/service/one/virtual/index']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>

