<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th style="width: 91px;">№ талона</th>
        <th style="width: 150px;">Талон клиента</th>
        <th style="width: 91px;">№ машины</th>
        <th>Услуга</th>
        <th class="text-right">Цена</th>
        <th class="text-right">Кол-во</th>
        <th class="text-right">Сумма</th>
        <th style="width: 106px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/act/service/one/virtual/addition-service']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
