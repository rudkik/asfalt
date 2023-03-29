<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Рубрика</th>
        <th>Продукт</th>
        <th style="width: 112px;">Кол-во</th>
        <th style="width: 112px;">Цена</th>
        <th style="width: 112px;">Сумма</th>
        <th style="width: 89px;"></th>
    </tr>
    <tbody id="guarantees">
    <?php
    foreach ($data['view::_shop/client/guarantee/item/one/item']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addContract('new-guarantee', 'guarantees', true);">Добавить продукцию</button>
</div>
<div id="new-guarantee" data-index="0">
    <!--
    <tr>
        <td>
            <select data-id="shop_product_rubric_id" name="shop_client_guarantee_items[_#index#][shop_product_rubric_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Все</option>
                <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list'];?>
            </select>
        </td>
        <td>
            <select data-id="shop_product_id" name="shop_client_guarantee_items[_#index#][shop_product_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Все</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/list'];?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-id="quantity" name="shop_client_guarantee_items[_#index#][quantity]" type="text" class="form-control" placeholder="Кол-во">
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-id="price" name="shop_client_guarantee_items[_#index#][price]" type="text" class="form-control" placeholder="Цена">
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-amount="0" data-id="amount" name="shop_client_guarantee_items[_#index#][amount]" type="text" class="form-control" placeholder="Сумма" readonly>
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
        addElement('new-guarantee', 'guarantees', true);

        var tr = $('#guarantees').last();
        _initCalc(tr.find('input[data-id="quantity"], input[data-id="price"]'));
        _initProduct(tr.find('select[data-id="shop_product_id"]'));
        _initProductRubric(tr.find('select[data-id="shop_product_rubric_id"]'));
        _initDelete(tr.find('li.tr-remove a'));
    }

    function _initCalc(elements) {
        elements.on('change', function(){
            var total = 0;
            $('#guarantees tr').each(function (i) {
                var price = $(this).find('input[data-id="price"]').valNumber();
                var quantity = $(this).find('input[data-id="quantity"]').valNumber();

                var amount = price * quantity;
                $(this).find('input[data-id="amount"]').valNumber(amount, 2);

                total = total + amount;
            });

            $('#amount_total').valNumber(total, 2);
        });
    }

    function _initDelete(elements) {
        // удаление записи в таблицы
        elements.click(function () {
            var element = $(this).parent().parent().parent().parent().find('input[data-id="amount"]').attr('name');

            var amount = 0;
            $('#guarantees input[data-id="amount"]').each(function () {
                amount = amount + $(this).attrNumber('data-amount');
            });

            $('#amount_total').valNumber(amount, 2);
        });
    }

    function _initProduct(elements) {
        elements.on('change', function(){
            var parent = $(this).parent().parent();
            var element = parent.find('input[data-id="price"]');

            var clientID = $('#shop_client_id').val();
            var productID = $(this).val();
            var date = $('[name="from_at"]').val();
            jQuery.ajax({
                url: '/<?php echo $siteData->actionURLName;?>/shopproduct/get_price',
                data: ({
                    'shop_product_id': productID,
                    'shop_client_id': clientID,
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

    $(document).ready(function () {
        _initCalc($('input[data-id="quantity"], input[data-id="price"]'));
        _initDelete($('#guarantees [data-action="remove-tr"]'));
        _initProduct($('select[data-id="shop_product_id"]'));
        _initProductRubric($('select[data-id="shop_product_rubric_id"]'));
    });
</script>