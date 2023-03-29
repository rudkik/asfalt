<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="width-165">Филиал</th>
        <th style="width: 50%">Рубрика</th>
        <th style="width: 50%">Продукт</th>
        <th class="width-105">Кол-во</th>
        <th class="width-105">Цена</th>
        <th class="width-110">Сумма</th>
        <th class="width-105">Скидка (тг)</th>
        <th style="min-width: 88px;">Фикс. цена</th>
        <th class="width-105">Дата старта</th>
        <th class="width-110 text-right">Потрачено</th>
        <th class="width-110 text-right">Остаток</th>
        <?php if(!$isShow){ ?>
            <th class="width-90"></th>
        <?php } ?>
    </tr>
    <tbody id="contracts">
    <?php
    foreach ($data['view::_shop/client/contract/item/one/product']->childs as $value) {
        echo $value->str;
    }
    ?>
    <tr data-id="table-total" class="total">
        <td></td>
        <td></td>
        <td></td>
        <td id="total-quantity" class="text-center"></td>
        <td class="text-center">x</td>
        <td id="total-amount" class="text-center"></td>
        <td></td>
        <td class="text-center"></td>
        <td></td>
        <td></td>
        <td class="text-right"></td>
        <td></td>
    </tr>
    </tbody>
</table>
<?php if(!$isShow){ ?>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addContract('new-contract', 'contracts', true);">Добавить продукцию</button>
</div>
<div id="new-contract" data-index="0">
    <!--
    <tr>
        <td>
            <select data-id="product_shop_branch_id" name="shop_client_contract_items[_#index#][product_shop_branch_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Все</option>
                <?php echo $siteData->globalDatas['view::_shop/branch/list/list'];?>
            </select>
        </td>
        <td>
            <select data-id="shop_product_rubric_id" name="shop_client_contract_items[_#index#][shop_product_rubric_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Все</option>
                <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list'];?>
            </select>
        </td>
        <td>
            <select data-id="shop_product_id" name="shop_client_contract_items[_#index#][shop_product_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Все</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/list'];?>
            </select>
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
            <input data-type="money" data-fractional-length="2" name="shop_client_contract_items[_#index#][discount]" type="text" class="form-control" placeholder="Скидка" value="">
        </td>
        <td class="text-center">
            <input name="shop_client_contract_items[_#index#][is_fixed_price]" value="0" type="checkbox" class="minimal" style="width: 20px;">
        </td>
        <td>
            <input name="shop_client_contract_items[_#index#][from_at]" type="datetime" date-type="date" class="form-control">
        </td>
        <td data-id="block_amount"></td>
        <td data-id="balance"></td>
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
        addElement('new-contract', 'contracts', true, true);

        var tr = $('#contracts').last();
        _initCalc(tr.find('input[data-id="quantity"], input[data-id="price"], input[data-id="agreement_number"]'));
        _initProduct(tr.find('select[data-id="shop_product_id"]'));
        _initBranch(tr.find('select[data-id="product_shop_branch_id"]'));
        _initProductRubric(tr.find('select[data-id="shop_product_rubric_id"]'));
        _initDelete(tr.find('[data-action="remove-tr"]'));
        _initCloseDiscount(tr.find('[data-action="close-contract-item"]'));
        __init();
    }

    function _initCalc(elements) {
        elements.on('change', function(){
            var total = 0;
            var totalQuantity = 0;
            $('#contracts tr').each(function () {
                if($(this).attr('class') == 'total'){
                    return true;
                }

                var price = $(this).find('input[data-id="price"]').valNumber();
                var quantity = $(this).find('input[data-id="quantity"]').valNumber();

                var amount = price * quantity;
                amount = amount.toFixed(2);
                $(this).find('input[data-id="amount"]').valNumber(amount).attr('data-amount', amount);

                total = total + amount;
                totalQuantity = totalQuantity + quantity;

                var blockAmount = $(this).find('[data-id="block_amount"]').textNumber();
                blockAmount = Number(blockAmount);
                if(isNaN(blockAmount)){
                    blockAmount = 0;
                }

                $(this).find('[data-id="balance"]').textNumber(amount - blockAmount, 2);
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

    function _initProduct(elements) {
        elements.on('change', function(){
            var parent = $(this).parent().parent();
            var element = parent.find('input[data-id="price"]');

            var productID = $(this).val();
            var date = $('[name="from_at"]').val();
            jQuery.ajax({
                url: '/<?php echo $siteData->actionURLName;?>/shopproduct/get_price',
                data: ({
                    'shop_product_id': productID,
                    'shop_client_id': 0,
                    'shop_client_contract_id': 0,
                    'is_charity': false,
                    'quantity': 0,
                    'date': date,
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    var price = obj.price * 1;

                    if(price > 0) {
                        element.valNumber(price).trigger('change');
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            if($(this).val() > 0) {
                parent.find('select[data-id="shop_product_rubric_id"]').val(0).trigger('change');
                parent.find('select[data-id="product_shop_branch_id"]').val(0).trigger('change');
            }
        });
    }

    function _initBranch(elements) {
        elements.on('change', function(){
            var parent = $(this).parent().parent();
            if($(this).val() > 0) {
                parent.find('select[data-id="shop_product_id"]').val(0).trigger('change');
            }
        });
    }

    function _initProductRubric(elements) {
        elements.on('change', function(){
            var parent = $(this).parent().parent();
            if($(this).val() > 0) {
                parent.find('select[data-id="shop_product_id"]').val(0).trigger('change');
            }
        });
    }

    function _initCloseDiscount(elements) {
        elements.on('click', function(e){
            e.preventDefault();
            var parent = $(this).closest('tr');

            var amount = parent.find('[data-id="block_amount"]').textNumber();
            amount = Number(amount);

            var price = parent.find('[data-id="price"]').valNumber();
            price = Number(price);

            parent.find('[data-id="quantity"]').val((amount / price).toFixed(3)).trigger('change');
        });
    }

    $(document).ready(function () {
        _initCalc($('input[data-id="quantity"], input[data-id="price"], input[data-id="agreement_number"]'));
        _initDelete($('#contracts [data-action="remove-tr"]'));
        _initProduct($('select[data-id="shop_product_id"]'));
        _initBranch($('select[data-id="product_shop_branch_id"]'));
        _initProductRubric($('select[data-id="shop_product_rubric_id"]'));
        _initCloseDiscount($('[data-action="close-contract-item"]'));

        $('input[data-id="quantity"]').trigger('change');
    });
</script>
<?php } ?>
<style>
    .icheckbox_minimal-blue.disabled.checked {
        background-position: -40px 0 !important;
    }
</style>