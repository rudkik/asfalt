<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Автотранспорт</th>
        <th class="width-120">Ед.измерения</th>
        <th class="width-105">Кол-во</th>
        <th class="width-105">Цена</th>
        <th class="width-105">Сумма</th>
        <?php if(!$isShow){ ?>
        <th class="width-90"></th>
        <?php } ?>
    </tr>
    <tbody id="contracts">
    <?php
    foreach ($data['view::_shop/client/contract/item/one/lease-car']->childs as $value) {
        echo $value->str;
    }
    ?>
    <tr data-id="table-total" class="total">
        <td></td>
        <td></td>
        <td id="total-quantity" class="text-center"></td>
        <td class="text-center">x</td>
        <td id="total-amount" class="text-center"></td>
        <?php if(!$isShow){ ?>
            <td></td>
        <?php } ?>
    </tr>
    </tbody>
</table>
<?php if(!$isShow){ ?>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addContract('new-contract', 'contracts', true);">Добавить строчку</button>
</div>
<div id="new-contract" data-index="0">
    <!--
    <tr>
        <td>
            <input name="shop_client_contract_items[_#index#][name]" type="text" class="form-control" placeholder="Название">
        </td>
        <td>
            <input name="shop_client_contract_items[_#index#][unit]" type="text" class="form-control" placeholder="Единица измерения">
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-id="quantity" name="shop_client_contract_items[_#index#][quantity]" type="text" class="form-control" placeholder="Кол-во">
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-id="price" name="shop_client_contract_items[_#index#][price]" type="text" class="form-control" placeholder="Цена">
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-amount="0" data-id="amount" name="shop_client_contract_items[_#index#][amount]" type="text" class="form-control" placeholder="Сумма" readonly>
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>  
    </tr>
    -->
</div>
<script>
    function addContract() {
        addElement('new-contract', 'contracts', true);

        var tr = $('#contracts').last();
        _initCalc(tr.find('input[data-id="quantity"], input[data-id="price"]'));
        _initDelete(tr.find('[data-action="remove-tr"]'));
        __init();
    }

    function _initCalc(elements) {
        elements.on('change', function(){
            var total = 0;
            var totalQuantity = 0;
            $('#contracts tr').each(function (i) {
                var price = $(this).find('input[data-id="price"]').valNumber();
                var quantity = $(this).find('input[data-id="quantity"]').valNumber();

                var amount = price * quantity;
                amount = amount.toFixed(2);
                $(this).find('input[data-id="amount"]').valNumber(amount).attr('data-amount', amount);

                total = total + amount;
                totalQuantity = totalQuantity + quantity;
            });

            $('#amount_total').valNumber(total, 2);
            $('#total-amount').textNumber(total, 2);
            $('#total-quantity').textNumber(totalQuantity, 2);
        });
    }

    function _initDelete(elements) {
        // удаление записи в таблицы
        elements.click(function () {
            var element = $(this).parent().parent().parent().parent().find('input[data-id="amount"]').attr('name');

            var amount = 0;
            $('#contracts input[data-id="amount"]').each(function () {
                amount = amount + $(this).attrNumber('data-amount');
            });

            $('#amount_total').valNumber(amount, 2);
        });
    }

    $(document).ready(function () {
        _initCalc($('input[data-id="quantity"], input[data-id="price"]'));
        _initDelete($('#contracts [data-action="remove-tr"]'));
    });
</script>
<?php } ?>