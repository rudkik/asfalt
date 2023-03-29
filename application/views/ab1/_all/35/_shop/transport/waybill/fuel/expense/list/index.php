<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<input name="shop_transport_waybill_fuel_expenses[_zero_]" value="" style="display: none">
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>ГСМ</th>
        <th>Расход по норме</th>
        <th>Количество к списанию</th>
        <?php if(!$isShow){ ?>
        <th class="width-90"></th>
        <?php } ?>
    </tr>
    <tbody id="fuel-expenses">
    <?php
    foreach ($data['view::_shop/transport/waybill/fuel/expense/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){ ?>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addFuelExpense('new-fuel-expense', 'fuel-expenses', true);">Добавить строчку</button>
    <?php if(Request_RequestParams::getParamInt('id') > 0){ ?>
    <button type="button" class="btn btn-primary pull-right" onclick="addFuelExpenseCalc('new-fuel-expense', 'fuel-expenses', true);">Расcчитать</button>
    <?php } ?>
</div>
<div id="new-fuel-expense" data-index="0">
    <!--
    <tr>
        <td>
            <select data-id="fuel_id" name="shop_transport_waybill_fuel_expenses[_#index#][fuel_id]" class="form-control select2" style="width: 100%" required>
                <option value="0" data-id="0">Выберите значение</option>
                <?php echo $siteData->globalDatas['view::fuel/list/list'];?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-id="quantity_norm" name="shop_transport_waybill_fuel_expenses[_#index#][quantity_norm]" type="phone" class="form-control" placeholder="Кол-во по норме" required>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-id="quantity" name="shop_transport_waybill_fuel_expenses[_#index#][quantity]" type="phone" class="form-control" placeholder="Кол-во к списанию" required>
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
        <?php if(Request_RequestParams::getParamInt('id') > 0){ ?>
        function addFuelExpenseCalc(from, to, isLast) {
            jQuery.ajax({
                url: '/<?php echo $siteData->actionURLName; ?>/shoptransportwaybill/calc_fuel',
                data: ({
                    'id': (<?php echo Request_RequestParams::getParamInt('id'); ?>),
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data))[0];
                    $('#'+to+' > *').html('');
                    addElement(from, to, isLast);

                    var tr = $('#'+to+' > *').last();
                    _initDeleteIssue(tr.find('[data-action="remove-tr"]'));
                    _initCalcIssue(tr.find('[data-id="quantity"]'));
                    __init();

                    tr.find('[data-id="fuel_id"]').val(obj.fuel_id).trigger('change');
                    tr.find('[data-id="quantity_norm"]').val(obj.quantity_norm).trigger('change');
                    tr.find('[data-id="quantity"]').val(obj.quantity_norm).trigger('change');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }
        <?php } ?>

        function addFuelExpense(from, to, isLast) {
            addElement(from, to, isLast);

            var tr = $('#'+to+' > *').last();
            _initDeleteExpense(tr.find('[data-action="remove-tr"]'));
            _initCalcExpense(tr.find('[data-id="quantity"]'));
            __init();
        }

        function _initCalcExpense(elements) {
            elements.on('change', function(){
                $('[name="fuel_quantity_from"]').trigger('change');
            });
        }

        function _initDeleteExpense(elements) {
            // удаление записи в таблицы
            elements.click(function () {
                $('[name="milage"]').trigger('change');
            });
        }

        $(document).ready(function () {
            _initCalcExpense($('#fuel-expenses input[data-id="quantity"]'));
            _initDeleteExpense($('#fuel-expenses [data-action="remove-tr"]'));
        });
    </script>
<?php } ?>