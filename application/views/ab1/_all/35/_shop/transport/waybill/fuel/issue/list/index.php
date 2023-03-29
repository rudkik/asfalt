<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<input name="shop_transport_waybill_fuel_issues[_zero_]" value="" style="display: none">
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>ГСМ</th>
        <th>Выдано</th>
        <th>Способ выдачи ГСМ</th>
        <?php if(!$isShow){ ?>
        <th class="width-90"></th>
        <?php } ?>
    </tr>
    <tbody id="fuel-issues">
    <?php
    foreach ($data['view::_shop/transport/waybill/fuel/issue/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){ ?>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addFuelIssue('new-fuel-issue', 'fuel-issues', true);">Добавить строчку</button>
    <div class="pull-right" id="add-fuel-issue">
    </div>
</div>
<div id="new-fuel-issue" data-index="0">
    <!--
    <tr>
        <td>
            <select data-id="issue-fuel_id" name="shop_transport_waybill_fuel_issues[_#index#][fuel_id]" class="form-control select2" style="width: 100%" required>
                <option value="0" data-id="0">Выберите значение</option>
                <?php echo $siteData->globalDatas['view::fuel/list/list'];?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-id="quantity" name="shop_transport_waybill_fuel_issues[_#index#][quantity]" type="phone" class="form-control" placeholder="Кол-во" required>
        </td>
        <td>
            <select data-id="issue-fuel_issue_id" name="shop_transport_waybill_fuel_issues[_#index#][fuel_issue_id]" class="form-control select2" style="width: 100%" required>
                <option value="0" data-id="0">Выберите значение</option>
                <?php echo $siteData->globalDatas['view::fuel/issue/list/list'];?>
            </select>
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
        function addFuelIssue(from, to, isLast) {
            addElement(from, to, isLast);

            var tr = $('#'+to+' > *').last();
            _initDeleteIssue(tr.find('[data-action="remove-tr"]'));
            _initCalcIssue(tr.find('[data-id="quantity"]'));
            __init();
        }

        function addFuelIssueValue(fuelID, fuelIssueID, from, to, isLast) {
            addElement(from, to, isLast);

            var tr = $('#'+to+' > *').last();
            _initDeleteIssue(tr.find('[data-action="remove-tr"]'));
            _initCalcIssue(tr.find('[data-id="quantity"]'));
            __init();

            tr.find('[data-id="issue-fuel_id"]').val(fuelID).trigger('change');
            tr.find('[data-id="issue-fuel_issue_id"]').val(fuelIssueID).trigger('change');
        }

        function _initCalcIssue(elements) {
            elements.on('change', function(){
                $('[name="fuel_quantity_from"]').trigger('change');
            });
        }

        function _initDeleteIssue(elements) {
            // удаление записи в таблицы
            elements.click(function () {
                $('[name="fuel_quantity_from"]').trigger('change');
            });
        }

        $(document).ready(function () {
            _initCalcIssue($('#fuel-issues input[data-id="quantity"]'));
            _initDeleteIssue($('#fuel-issues [data-action="remove-tr"]'));
        });
    </script>
<?php } ?>