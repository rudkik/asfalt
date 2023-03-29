<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th style="width: 91px;">№ талона</th>
        <th style="width: 150px;">Талон клиента</th>
        <th style="width: 91px;">№ машины</th>
        <th>Доставка</th>
        <th class="text-right width-120">КМ</th>
        <th class="text-right width-120">Кол-во</th>
        <th class="text-right width-120">Сумма</th>
        <?php if(Request_RequestParams::getParamBoolean('is_all')){ ?>
        <th style="width: 106px;"></th>
        <?php } ?>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/act/service/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>

