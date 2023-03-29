<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th>Спецтранспорт</th>
        <th class="width-120">Кол-во</th>
        <th>Подразделение</th>
        <th>Смена</th>
        <th class="tr-header-buttom"></th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/plan/transport/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    <?php
    if(empty($data['view::_shop/plan/transport/item/one/index']->childs)){
        for ($i = 0; $i < 6; $i++) {
            ?>

            <?php
        }
    }
    ?>
    </tbody>
</table>
<div class="modal-footer text-center">
    <button type="button" class="btn btn-danger" onclick="addElement('new-product', 'products', true);">Добавить транспорт</button>
</div>
<div id="new-product" data-index="0">
    <!--
    <tr>
        <td>
            <select name="shop_plan_transport_items[_#index#][shop_special_transport_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/special/transport/list/list']; ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="0" name="shop_plan_transport_items[_#index#][count]" type="text" class="form-control" placeholder="Кол-во" required value="0">
        </td>
        <td>
            <select name="shop_plan_transport_items[_#index#][is_bsu]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">АБиНБ</option>
                <option value="1" data-id="1">БСУ</option>
            </select>
        </td>
        <td>
            <select name="shop_plan_transport_items[_#index#][working_shift]" class="form-control select2" required style="width: 100%;">
                <option value="1" data-id="1">1 смена</option>
                <option value="2" data-id="2">2 смена</option>
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