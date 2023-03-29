<table class="table table-hover table-db table-tr-line">
    <tr>
        <th style="width: 91px;">№ талона</th>
        <th style="width: 150px;">Талон клиента</th>
        <th style="width: 91px;">№ машины</th>
        <th>Услуга</th>
        <th class="text-right width-120">Цена</th>
        <th class="text-right width-120">Кол-во</th>
        <th class="text-right width-120">Сумма</th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/act/service/item/one/addition-service']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>

