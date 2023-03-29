<?php
$panelID = 'my-invoice-item-'.rand(0, 10000);
?>

<div class="col-lg-12">
    <div class="card panel panel-default panel-table">
        <table class="table table-bordered table-items">
            <thead class="thead-default">
            <tr>
                <th>Товар/услуга</th>
                <th style="width: 70px;">Услуга?</th>
                <th style="width: 120px;">Ед. измерения</th>
                <th style="width: 80px;">Кол-во</th>
                <th style="width: 110px;">Цена</th>
                <th data-id="price-nds" style="width: 110px; display: none">Цена с НДС</th>
                <th style="width: 100px;">Сумма</th>
                <th style="width: 30px;"></th>
            </tr>
            </thead>
            <tbody id="<?php echo $panelID; ?>-table-body" data-index="0">
            <?php
            if (count($data['view::_shop/my/invoice/item/one/index']->childs) > 0) {
                foreach ($data['view::_shop/my/invoice/item/one/index']->childs as $value) {
                    echo $value->str;
                }
            }else{
            ?>
                <tr>
                    <td>
                        <div class="box-typeahead">
                            <input data-name="name" name="shop_my_invoice_items[0][shop_product_name]" class="form-control products typeahead" placeholder="Товар/услуга" type="text">
                        </div>
                    </td>
                    <td class="td-check">
                        <label class="custom-control custom-checkbox">
                            <input data-name="is_service" name="shop_my_invoice_items[0][is_service]" type="checkbox" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                        </label>
                    </td>
                    <td>
                        <input data-name="unit" name="shop_my_invoice_items[0][unit_name]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" type="text">
                    </td>
                    <td>
                        <input data-action="tr-calc-amount" data-decimals="3" data-id="quantity" name="shop_my_invoice_items[0][quantity]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" type="text">
                    </td>
                    <td>
                        <input data-name="price" data-decimals="2" data-action="tr-calc-amount" data-id="price" name="shop_my_invoice_items[0][price]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" placeholder="Цена" type="text">
                    </td>
                    <td data-nds="0" data-id="price-nds" style="display: none"></td>
                    <td data-id="amount" data-total="#my-invoice-new-amount"></td>
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
            <button class="btn btn-primary" type="button" onclick="addMyInvoiceItem('#<?php echo $panelID; ?>-table-tr', '#<?php echo $panelID; ?>-table-body')">Добавить товар/услугу</button>
        </div>
    </div>
</div>
<div id="<?php echo $panelID; ?>-table-tr" data-index="1">
<!--
<tr>
    <td>
        <div class="box-typeahead">
            <input data-name="name" name="shop_my_invoice_items[#index#][shop_product_name]" class="form-control products typeahead" placeholder="Товар/услуга" type="text">
        </div>
    </td>
    <td class="td-check">
        <label class="custom-control custom-checkbox">
            <input data-name="is_service" name="shop_my_invoice_items[#index#][is_service]" type="checkbox" class="custom-control-input">
            <span class="custom-control-indicator"></span>
        </label>
    </td>
    <td>
        <input data-name="unit" name="shop_my_invoice_items[#index#][unit_name]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" type="text">
    </td>
    <td>
        <input data-nds="0" data-action="tr-calc-amount" data-decimals="3" data-id="quantity" name="shop_my_invoice_items[#index#][quantity]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" type="text">
    </td>
    <td>
        <input data-name="price" data-decimals="2" data-nds="0" data-action="tr-calc-amount" data-id="price" name="shop_my_invoice_items[#index#][price]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" placeholder="Цена" type="text">
    </td>
    <td data-id="price-nds" style="display: none"></td>
    <td data-id="amount" data-total="#my-invoice-new-amount"></td>
    <td>
        <button type="button" class="close" aria-label="Close" data-action="tr-delete">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>
-->
</div>
<script>
    function addMyInvoiceItem(from, to) {
        var form = $(from);
        var index = form.data('index');
        form.data('index', Number(index) + 1);

        var tmp = $.trim(form.html().replace('<!--', '').replace('-->', '').replace(/#index#/g, '_' + index));

        tmp = $(to).append(tmp);

        if ($('#my-invoice-new-is_nds').val() == 1){
            tmp.css('display', 'block');
            tmp.find('data-action="tr-calc-amount"').data('nds', $('#my-invoice-new-is_nds').data('nds'));
        }
        tmp.css();

        __initTr();
    }

    $('#my-invoice-new-is_nds').trigger('change');
</script>