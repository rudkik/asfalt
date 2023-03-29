<?php
$panelID = 'my-attorney-item-'.rand(0, 10000);
?>

<div class="col-lg-12">
    <div class="card panel panel-default panel-table">
        <table class="table table-bordered table-items">
            <thead class="thead-default">
            <tr>
                <th>Товар/услуга</th>
                <th style="width: 70px;">Услуга?</th>
                <th style="width: 120px;">Ед. измерения</th>
                <th style="width: 93px;">Кол-во</th>
                <th style="width: 110px;">Цена</th>
                <th style="width: 100px;">Сумма</th>
                <th style="width: 30px;"></th>
            </tr>
            </thead>
            <tbody id="<?php echo $panelID; ?>-table-body" data-index="0">
            <?php
            if (count($data['view::_shop/my/attorney/item/one/index']->childs) > 0) {
                foreach ($data['view::_shop/my/attorney/item/one/index']->childs as $value) {
                    echo $value->str;
                }
            }else{
            ?>
                <tr>
                    <td>
                        <div class="box-typeahead">
                            <input data-name="name" name="shop_my_attorney_items[0][shop_product_name]" class="form-control products typeahead" placeholder="Товар/услуга" type="text">
                        </div>
                    </td>
                    <td class="td-check">
                        <label class="custom-control custom-checkbox">
                            <input data-name="is_service" name="shop_my_attorney_items[0][is_service]" type="checkbox" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                        </label>
                    </td>
                    <td>
                        <input data-name="unit" name="shop_my_attorney_items[0][unit_name]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" type="text">
                    </td>
                    <td>
                        <input data-action="tr-calc-amount" data-decimals="3" data-id="quantity" name="shop_my_attorney_items[0][quantity]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" type="text">
                    </td>
                    <td>
                        <input data-name="price" data-decimals="2" data-action="tr-calc-amount" data-id="price" name="shop_my_attorney_items[0][price]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" placeholder="Цена" type="text">
                    </td>
                    <td data-id="amount" data-total="#my-attorney-new-amount"></td>
                    <td>
                        <button type="button" class="close" aria-label="Close" data-action="tr-delete">
                            <span aria-hidden="true" class="fa fa-close"></span>
                        </button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="card-footer">
            <button class="btn btn-primary" type="button" onclick="addTr('#<?php echo $panelID; ?>-table-tr', '#<?php echo $panelID; ?>-table-body')">Добавить товар/услугу</button>
        </div>
    </div>
</div>
<div id="<?php echo $panelID; ?>-table-tr" data-index="1">
<!--
<tr>
    <td>
        <div class="box-typeahead">
            <input data-name="name" name="shop_my_attorney_items[#index#][shop_product_name]" class="form-control products typeahead" placeholder="Товар/услуга" type="text">
        </div>
    </td>
    <td class="td-check">
        <label class="custom-control custom-checkbox">
            <input data-name="is_service" name="shop_my_attorney_items[#index#][is_service]" type="checkbox" class="custom-control-input">
            <span class="custom-control-indicator"></span>
        </label>
    </td>
    <td>
        <input data-name="unit" name="shop_my_attorney_items[#index#][unit_name]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" type="text">
    </td>
    <td>
        <input data-action="tr-calc-amount" data-decimals="3" data-id="quantity" name="shop_my_attorney_items[#index#][quantity]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" type="text">
    </td>
    <td>
        <input data-name="price" data-decimals="2" data-action="tr-calc-amount" data-id="price" name="shop_my_attorney_items[#index#][price]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" placeholder="Цена" type="text">
    </td>
    <td data-id="amount" data-total="#my-attorney-new-amount"></td>
    <td>
        <button type="button" class="close" aria-label="Close" data-action="tr-delete">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>
-->
</div>