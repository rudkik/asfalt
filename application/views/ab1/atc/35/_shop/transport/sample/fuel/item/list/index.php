<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>Тип топлива</th>
        <th class="width-120">Кол-во</th>
        <th class="tr-header-amount" style="width: 10%">Ед. измерения</th>
        <th class="width-85"></th>
    </tr>
    <tbody id="fuels">
    <?php
    foreach ($data['view::_shop/transport/sample/fuel/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div id="new-fuel" data-index="0">
    <!--
    <tr>
        <td>
            <select name="shop_transport_sample_fuel_items[_#index#][fuel_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::fuel/list/list']; ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" name="shop_transport_sample_fuel_items[_#index#][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="0">
        </td>
        <td>
            <input name="shop_transport_sample_fuel_items[_#index#][unit]" type="text" class="form-control" placeholder="Ед. измерения" required value="">
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>