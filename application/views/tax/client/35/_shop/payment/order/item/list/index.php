<?php
$rand = rand(0, 10000);
$panelID = 'payment-order-item-'.$rand;
?>

<div class="col-lg-12">
    <div class="card panel panel-default panel-table">
        <table class="table table-bordered table-items">
            <thead class="thead-default">
            <tr>
                <th style="width: 135px;">ИНН</th>
                <th>ФИО</th>
                <th style="width: 123px;">Дата рождения</th>
                <th style="width: 131px;">Период платежа</th>
                <th style="width: 100px;">Сумма</th>
                <th style="width: 30px;"></th>
            </tr>
            </thead>
            <tbody id="<?php echo $panelID; ?>-table-body" data-index="0">
            <?php
            if (count($data['view::_shop/payment/order/item/one/index']->childs) > 0) {
                foreach ($data['view::_shop/payment/order/item/one/index']->childs as $value) {
                    echo $value->str;
                }
            }else{
            ?>
                <tr>
                    <td>
                        <div class="box-typeahead">
                            <input data-name="iin" name="shop_payment_order_items[0][shop_worker_iin]" data-validation="length" data-validation-length="12" maxlength="12"  class="form-control workers_iin typeahead" placeholder="ИИН" type="text">
                        </div>
                    </td>
                    <td>
                        <div class="box-typeahead">
                            <input data-name="name" name="shop_payment_order_items[0][shop_worker_name]" data-validation="length" data-validation-length="max250" maxlength="250"  class="form-control workers_name typeahead" placeholder="ФИО" type="text">
                        </div>
                    </td>
                    <td>
                        <input data-name="date_of_birth" name="shop_payment_order_items[0][shop_worker_date_of_birth]" class="form-control valid" type="datetime" autocomplete="off">
                    </td>
                    <td>
                        <input name="shop_payment_order_items[0][date]" data-validation="length" data-validation-length="6" maxlength="6" class="form-control valid" placeholder="012018" type="text">
                    </td>
                    <td>
                        <input data-action="sum-amount" name="shop_payment_order_items[0][amount]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" type="text">
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="card-footer">
            <button class="btn btn-primary" type="button" onclick="addTrPayment<?php echo $rand; ?>('#<?php echo $panelID; ?>-table-tr', '#<?php echo $panelID; ?>-table-body')">Добавить товар/услугу</button>
        </div>
    </div>
</div>
<div id="<?php echo $panelID; ?>-table-tr" data-index="1">
<!--
<tr>
    <td>
        <div class="box-typeahead">
            <input data-name="iin" name="shop_payment_order_items[#index#][shop_worker_iin]" data-validation="length" data-validation-length="12" maxlength="12"  class="form-control workers_iin typeahead" placeholder="ИИН" type="text">
        </div>
    </td>
    <td>
        <div class="box-typeahead">
            <input data-name="name" name="shop_payment_order_items[#index#][shop_worker_name]" data-validation="length" data-validation-length="max250" maxlength="250"  class="form-control workers_name typeahead" placeholder="ФИО" type="text">
        </div>
    </td>
    <td>
        <input data-name="date_of_birth" name="shop_payment_order_items[#index#][shop_worker_date_of_birth]" class="form-control valid" type="datetime" autocomplete="off">
    </td>
    <td>
        <input name="shop_payment_order_items[#index#][date]" data-validation="length" data-validation-length="6" maxlength="6" class="form-control valid" placeholder="012018" type="text">
    </td>
    <td>
        <input data-action="sum_amount" name="shop_payment_order_items[#index#][amount]" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control money-format valid" type="text">
    </td>
    <td>
        <button type="button" class="close" aria-label="Close" data-action="tr-delete">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>
-->
</div>
<script>
    function __initTrPayment<?php echo $rand; ?>(parent) {
        __initTr();

        $('[data-action="sum-amount"]').change(function () {
            var parent = $(this).parents('table');

            var total = 0;
            parent.find('[data-action="sum-amount"]').each(function (i) {
                total = total + Number($(this).val());
            });
            $(this).parents('.modal-dialog').find('[data-id="sum-total"]').val(total);

            return false;
        });
    }
    function addTrPayment<?php echo $rand; ?>(from, to) {
        var form = $(from);
        var index = form.data('index');
        form.data('index', Number(index) + 1);

        var tmp = $.trim(form.html().replace('<!--', '').replace('-->', '').replace(/#index#/g, '_' + index));

        var el = $(to).append(tmp);

        __initTrPayment<?php echo $rand; ?>(el);
    }

    __initTrPayment<?php echo $rand; ?>('#<?php echo $panelID; ?>-table-body');
</script>