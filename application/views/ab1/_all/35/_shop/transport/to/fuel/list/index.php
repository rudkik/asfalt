<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th style="width: 50%">Вид ГСМ</th>
        <th style="width: 50%">Формула расчета</th>
        <?php if(!$isShow){ ?>
        <th class="width-90"></th>
        <?php } ?>
    </tr>
    <tbody id="to-fuel">
    <?php
    foreach ($data['view::_shop/transport/to/fuel/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){ ?>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addElementToFuel('new-to-fuel', 'to-fuel', true);">Добавить строчку</button>
</div>
<div id="new-to-fuel" data-index="0">
    <!--
    <tr>
        <td>
            <select name="shop_transport_to_fuels[_#index#][fuel_type_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Выберите значение</option>
                <?php echo $siteData->globalDatas['view::fuel/type/list/list'];?>
            </select>
        </td>
        <td>
            <select data-id="shop_transport_indicator_formula_id" name="shop_transport_to_fuels[_#index#][shop_transport_indicator_formula_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Выберите значение</option>
                <?php echo $siteData->globalDatas['view::_shop/transport/indicator/formula/list/list'];?>
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
<?php } ?>
<script>
    function addElementToFuel(from, to, isLast){
        addElement(from, to, isLast);

        var tr = $('#' + to + ' > *').last();
        _initCalc(tr.find('[data-id="shop_transport_indicator_formula_id"]'));
        _initDelete(tr.find('[data-action="remove-tr"]'));
    }

    function _initDelete(elements) {
        // удаление записи в таблицы
        elements.click(function () {
            $('#to-fuel [data-id="shop_transport_indicator_formula_id"]').last().trigger('change');
        });
    }

    function _initCalc(elements) {
        elements.on('change', function(){
            var formula = '';
            $('#to-fuel [data-id="shop_transport_indicator_formula_id"] option:selected').each(function(index) {
                formula = formula + $(this).data('formula') + ' ';
            });
            if(formula == ''){
                return false;
            }

            jQuery.ajax({
                url: '/<?php echo $siteData->actionURLName;?>/shoptransport/indicators',
                data: ({
                    'formula': (formula),
                    'shop_transport_id': (<?php echo intval(Request_RequestParams::getParamInt('id'));?>),
                }),
                type: "POST",
                success: function (data) {
                    $('#to-indicators').html(data);
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });
    }


    $(document).ready(function () {
        _initCalc($('[data-id="shop_transport_indicator_formula_id"]'));
        _initDelete($('#to-fuel [data-action="remove-tr"]'));
    });
</script>