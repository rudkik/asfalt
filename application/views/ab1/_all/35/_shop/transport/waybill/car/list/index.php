<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-40 text-right">№</th>
        <th class="width-60">ЗП?</th>
        <th class="width-80">Дата</th>
        <th>Пункт отправления</th>
        <th>Пункт назначения</th>
        <th>Наименование груза</th>
        <th>Маршрут</th>
        <th class="width-100">Коэффициент</th>
        <th class="width-110 text-right">Кол-во рейсов</th>
        <th class="width-120 text-right">Расстояние, км</th>
        <th class="width-80 text-right">Масса</th>
        <?php if($isShow || $siteData->operation->getIsAdmin()){ ?>
        <th class="width-130 text-right">Стоимость рейса</th>
        <?php } ?>
        <th class="width-85"></th>
    </tr>
    <tbody id="cars">
    <?php
    $i = 1;
    foreach ($data['view::_shop/transport/waybill/car/one/index']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){ ?>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addElement('new-car', 'cars', true);">Добавить строчку</button>
</div>
<div id="new-car" data-index="0">
    <!--
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <select name="hand_shop_transport_waybill_cars[_#index#][shop_branch_from_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Выберите значение</option>
                <?php echo $siteData->globalDatas['view::_shop/branch/list/list'];?>
            </select>
        </td>
        <td>
            <input name="hand_shop_transport_waybill_cars[_#index#][to_name]" type="text" class="form-control" placeholder="Пункт назначения">
        </td>
        <td>
            <input name="hand_shop_transport_waybill_cars[_#index#][product_name]" type="text" class="form-control" placeholder="Наименование груза">
        </td>
        <td>
            <select name="hand_shop_transport_waybill_cars[_#index#][shop_transport_route_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Выберите значение</option>
                <?php echo $siteData->globalDatas['view::_shop/transport/route/list/list'];?>
            </select>
        </td>
        <td>
            <input data-type="money"name="hand_shop_transport_waybill_cars[_#index#][coefficient]" type="text" class="form-control" placeholder="Коэффициент">
        </td>
        <td>
            <input data-type="money" name="hand_shop_transport_waybill_cars[_#index#][count_trip]" type="text" class="form-control" placeholder="Кол-во рейсов">
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" name="hand_shop_transport_waybill_cars[_#index#][distance]" type="text" class="form-control" placeholder="Расстояние, км">
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" name="hand_shop_transport_waybill_cars[_#index#][quantity]" type="text" class="form-control" placeholder="Масса">
        </td>
        <?php if($isShow || $siteData->operation->getIsAdmin()){ ?>
        <td>
            <input data-type="money" data-fractional-length="2" name="hand_shop_transport_waybill_cars[_#index#][wage]" type="text" class="form-control" placeholder="Стоимость рейса">
        </td>
        <?php } ?>
        <td>
            <ul class="list-inline tr-button delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>  
    </tr>
    -->
</div>
<?php } ?>