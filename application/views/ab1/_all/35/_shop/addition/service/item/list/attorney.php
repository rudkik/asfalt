<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Услуга</th>
        <th class="tr-header-amount">Вес</th>
        <th class="width-120">Сумма</th>
        <th>Доверенность</th>
        <th class="tr-header-buttom"></th>
    </tr>
    <tbody id="addition_services">
    <?php
    foreach ($data['view::_shop/addition/service/item/one/attorney']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div id="new-addition-service" data-index="0">
    <!--
    <tr>
        <td>
            <select data-action="calc-addition-service" name="shop_addition_service_items[_#index#][shop_product_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/addition-service']; ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-action="calc-addition-service" name="shop_addition_service_items[_#index#][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="0">
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-id="amount" data-amount="0" name="shop_addition_service_items[_#index#][amount]" disabled type="text" class="form-control" value="0">
        </td>
        <td>
            <select data-action="calc-addition-service" name="shop_addition_service_items[_#index#][shop_client_attorney_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/client/attorney/list/list']; ?>
            </select>
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>