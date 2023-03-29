<table class="table table-hover table-db table-tr-line" data-action="fixed-table">
    <tr>
        <th>Продукт</th>
        <th class="tr-header-amount">Вес</th>
        <th>Смена</th>
        <th>Место погрузки</th>
        <th class="tr-header-buttom"></th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/plan/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    <?php
    if(empty($data['view::_shop/plan/item/one/index']->childs)){
        for ($i = 0; $i < 6; $i++) {
    ?>
            <tr>
                <td>
                    <select name="shop_plan_items[__<?php echo $i; ?>][shop_product_id]" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
                    </select>
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" name="shop_plan_items[__<?php echo $i; ?>][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="0">
                </td>
                <td>
                    <select name="shop_plan_items[__<?php echo $i; ?>][working_shift]" class="form-control select2" required style="width: 100%;">
                        <option value="1" data-id="1">1 смена</option>
                        <option value="2" data-id="2">2 смена</option>
                    </select>
                </td>
                <td>
                    <select name="shop_plan_items[__<?php echo $i; ?>][shop_turn_place_id]" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::_shop/turn/place/list/list']; ?>
                    </select>
                </td>
                <td>
                    <ul class="list-inline tr-button delete">
                        <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                    </ul>
                </td>
            </tr>
    <?php
        }
    }
    ?>
    </tbody>
</table>
<div class="modal-footer text-center">
    <button type="button" class="btn btn-danger" onclick="addElement('new-product', 'products', true);">Добавить продукт</button>
</div>
<div id="new-product" data-index="0">
    <!--
    <tr>
        <td>
            <select name="shop_plan_items[_#index#][shop_product_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" name="shop_plan_items[_#index#][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="0">
        </td>
        <td>
            <select name="shop_plan_items[_#index#][working_shift]" class="form-control select2" required style="width: 100%;">
                <option value="1" data-id="1">1 смена</option>
                <option value="2" data-id="2">2 смена</option>
            </select>
        </td>
        <td>
            <select name="shop_plan_items[_#index#][shop_turn_place_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/turn/place/list/list']; ?>
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