<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-165">Филиал</th>
        <th>Рубрика</th>
        <th>Доставка</th>
        <th class="width-110">Скидка (тг)</th>
        <th class="width-105">Сумма</th>
        <th class="width-105 text-right">Потрачено</th>
        <th class="width-105 text-right">Остаток</th>
        <?php if(!$isShow){ ?>
        <th style="width: 89px;"></th>
        <?php } ?>
    </tr>
    <tbody id="deliverys">
    <?php
    foreach ($data['view::_shop/delivery/discount/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){ ?>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" onclick="addContract();">Добавить доставку</button>
    </div>
    <div id="new-delivery" data-index="0">
        <!--
        <tr>
            <td>
                <select data-id="delivery_shop_branch_id" name="shop_delivery_discount_items[_#index#][delivery_shop_branch_id]" class="form-control select2" style="width: 100%">
                    <option value="0" data-id="0">Все</option>
                    <?php echo $siteData->globalDatas['view::_shop/branch/list/list'];?>
                </select>
            </td>
            <td>
                <select data-id="shop_delivery_rubric_id" name="shop_delivery_discount_items[_#index#][shop_delivery_rubric_id]" class="form-control select2" style="width: 100%">
                    <option value="0" data-id="0">Все</option>
                    <?php echo $siteData->globalDatas['view::_shop/delivery/rubric/list/list'];?>
                </select>
            </td>
            <td>
                <select data-id="shop_delivery_id" name="shop_delivery_discount_items[_#index#][shop_delivery_id]" class="form-control select2" style="width: 100%">
                    <option value="0" data-id="0">Все</option>
                    <?php echo $siteData->globalDatas['view::_shop/delivery/list/list'];?>
                </select>
            </td>
            <td>
                <input data-type="money" data-fractional-length="2" name="shop_delivery_discount_items[_#index#][discount]" type="text" class="form-control" placeholder="Скидка" value="">
            </td>
            <td>
                <input data-type="money" data-fractional-length="2" name="shop_delivery_discount_items[_#index#][amount]" type="text" class="form-control" placeholder="Сумма">
            </td>
            <td></td>
            <td></td>
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
            addElement('new-delivery', 'deliverys', true);

            var tr = $('#deliverys').last();
            _initCalc(tr.find('input[data-id="quantity"], input[data-id="price"]'));
            _initProduct(tr.find('select[data-id="shop_delivery_id"]'));
            _initBranch(tr.find('select[data-id="delivery_shop_branch_id"]'));
            _initProductRubric(tr.find('select[data-id="shop_delivery_rubric_id"]'));
            _initDelete(tr.find('[data-action="remove-tr"]'));
            __init();
        }

        function _initCalc(elements) {
            elements.on('change', function(){
                var total = 0;
                $('#deliverys tr').each(function (i) {
                    var price = $(this).find('input[data-id="price"]').valNumber();
                    var quantity = $(this).find('input[data-id="quantity"]').valNumber();

                    var amount = price * quantity;
                    amount = amount.toFixed(2);
                    $(this).find('input[data-id="amount"]').val(amount).attr('data-amount', amount);

                    var blockAmount = $(this).find('[data-id="block_amount"]').textNumber();
                    if(isNaN(blockAmount)){
                        blockAmount = 0;
                    }

                    $(this).find('[data-id="balance"]').textNumber(amount - blockAmount, 2);
                });

                $('#amount_total').valNumber(total, 2);
            });
        }

        function _initDelete(elements) {
            // удаление записи в таблицы
            elements.click(function () {
                var element = $(this).parent().parent().parent().parent().find('input[data-id="amount"]').attr('name');

                var amount = 0;
                $('#deliverys input[data-id="amount"]').each(function () {
                    amount = amount + $(this).attrNumber('data-amount');
                });

                $('#amount_total').valNumber(amount, 2);
            });
        }

        function _initProduct(elements) {
            elements.on('change', function(){
                var parent = $(this).parent().parent();
                var element = parent.find('input[data-id="price"]');

                var price = Number($(this).find('option:selected').data('price'));
                if(price > 0) {
                    element.valNumber(price).trigger('change');
                }

                if($(this).val() > 0) {
                    parent.find('select[data-id="shop_delivery_rubric_id"]').val(0).trigger('change');
                    parent.find('select[data-id="delivery_shop_branch_id"]').val(0).trigger('change');
                }
            });
        }

        function _initBranch(elements) {
            elements.on('change', function(){
                var parent = $(this).parent().parent();
                if($(this).val() > 0) {
                    parent.find('select[data-id="shop_delivery_id"]').val(0).trigger('change');
                }
            });
        }

        function _initProductRubric(elements) {
            elements.on('change', function(){
                var parent = $(this).parent().parent();
                if($(this).val() > 0) {
                    parent.find('select[data-id="shop_delivery_id"]').val(0).trigger('change');
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
            _initDelete($('#deliverys [data-action="remove-tr"]'));
            _initProduct($('select[data-id="shop_delivery_id"]'));
            _initBranch($('select[data-id="delivery_shop_branch_id"]'));
            _initProductRubric($('select[data-id="shop_delivery_rubric_id"]'));
            _initCloseDiscount($('[data-action="close-contract-item"]'));
        });
    </script>
<?php } ?>