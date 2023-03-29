<input name="shop_transport_driver_tariffs[]" style="display: none">
<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) || !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-110">Действие от</th>
        <th class="width-110">Действие до</th>
        <th>Размер</th>
        <?php if(!$isShow){ ?>
            <th class="width-90"></th>
            <th class="width-90"></th>
        <?php } ?>
    </tr>
    <tbody id="driver-tariffs">
    <?php
    foreach ($data['view::_shop/transport/driver/tariff/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){ ?>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addElement('new-driver-tariff', 'driver-tariffs', true);">Добавить строчку</button>
</div>
<div id="new-driver-tariff" data-index="0">
    <!--
    <tr>
        <td>
            <input name="shop_transport_driver_tariffs[_#index#][date_from]" type="datetime" date-type="date" class="form-control">
        </td>
        <td>
            <input name="shop_transport_driver_tariffs[_#index#][date_to]" type="datetime" date-type="date" class="form-control">
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" name="shop_transport_driver_tariffs[_#index#][quantity]" type="phone" class="form-control">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
        <td></td>
    </tr>
    -->
</div>
<?php } ?>