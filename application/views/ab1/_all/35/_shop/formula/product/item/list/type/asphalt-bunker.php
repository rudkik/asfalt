<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Рецепт
        </label>
    </div>
    <div class="col-md-9">
        <table class="table table-hover table-db table-tr-line" >
            <thead>
            <tr>
                <th rowspan="2">Материал</th>
                <th class="text-center width-150" rowspan="2">% состав с учетом бункерно-го рассева и битума > 100%</th>
                <th class="text-center" colspan="2">Расход материалов на 1000 кг смеси, кг     </th>
                <th class="text-center" colspan="2">Норматив технологических потерь</th>
                <th class="width-140" rowspan="2">Производственные нормы расхода на 1 т а/бетона, кг</th>
                <?php if(!$isShow){ ?>
                <th class="width-85" rowspan="2"></th>
                <?php } ?>
            </tr>
            <tr>
                <th class="text-center width-140">%</th>
                <th class="text-center width-140">кг</th>
                <th class="text-center width-140">%</th>
                <th class="text-center width-140">кг</th>
            </tr>
            </thead>
            <tbody id="materials">
            <?php
            foreach ($data['view::_shop/formula/product/item/one/type/asphalt-bunker']->childs as $value) {
                echo $value->str;
            }
            ?>
            <tr data-id="table-total" class="total">
                <td>Итого</td>
                <td id="bunker_percent" class="text-right"></td>
                <td id="norm_percent" class="text-right"></td>
                <td id="norm_weight" class="text-right"></td>
                <td class="text-right">-</td>
                <td id="losses_weight" class="text-right"></td>
                <td id="norm_industrial" class="text-right"></td>
                <?php if(!$isShow){ ?>
                <td></td>
                <?php } ?>
            </tr>
            </tbody>
        </table>
        <?php if(!$isShow){ ?>
        <div class="modal-footer text-right">
            <button type="button" class="btn btn-danger" onclick="addElementCalcAsphalt('new-material', 'materials', true);">Добавить каменные материалы</button>
            <button type="button" class="btn btn-success" onclick="addElementCalcAsphalt('new-material-bitumen', 'materials', true);">Добавить битум</button>
        </div>
        <?php } ?>
    </div>
</div>
<script>
    function addElementCalcAsphalt(from, to, isLast){
        addElement(from, to, isLast);
        __initCalcAsphalt();
    }

    function __initCalcAsphalt() {
        $('[data-action="remove-tr"]:not([data-remove-tr-1="1"])').click(function () {
            $('[data-id="norm_weight"]:eq(0)').each(function () {
                $(this).trigger('change');
            });
        }).attr('data-remove-tr-1', 1);

        $('[data-action="calc-asphalt"]:not([data-action-calc-asphalt="1"])').change(function () {
            var parentTable = $(this).closest('table');
            var parentTr = $(this).closest('tr');

            // находим какой вес считать за 100%
            var weight = 1000;
            parentTable.find('[data-id="is_bitumen"][value="1"]').each(function () {
                var normWeight = $(this).closest('tr').find('[data-id="norm_weight"]').valNumber();
                if ($.isNumeric(normWeight)) {
                    weight = weight - normWeight;
                }
            });

            var isBitumen = Number(parentTr.find('[data-id="is_bitumen"]').val())  == 1;
            if(isBitumen){
                parentTable.find('[data-id="norm_weight"]').each(function () {
                    if($(this).closest('tr').find('[data-id="is_bitumen"]').val() != 1){
                        $(this).trigger('change');
                    }
                });
            }

            var normWeight = parentTr.find('[data-id="norm_weight"]').valNumber();
            if ($.isNumeric(normWeight)) {
                parentTr.find('[data-id="norm_percent"]').val((normWeight / weight * 100).toFixed(2));

                if(isBitumen){
                    parentTr.find('[data-id="norm_industrial"]').val(normWeight);
                }else {
                    var losses = parentTr.find('[data-id="losses"]').valNumber();
                    if ($.isNumeric(losses)) {
                        var lossesWeight = (normWeight / 100 * losses).toFixed(2);
                        parentTr.find('[data-id="losses_weight"]').val(lossesWeight);

                        parentTr.find('[data-id="norm_industrial"]').val(normWeight + Number(lossesWeight));
                    }
                }
            }


            // считаем итоги
            var total = 0;
            parentTable.find('[data-id="bunker_percent"]').each(function () {
                var tmp = $(this).valNumber();
                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#bunker_percent').textNumber(total, 3);

            var total = 0;
            parentTable.find('[data-id="norm_percent"]').each(function () {
                var tmp = $(this).valNumber();
                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#norm_percent').textNumber(total, 3);

            var total = 0;
            parentTable.find('[data-id="norm_weight"]').each(function () {
                var tmp = $(this).valNumber();
                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#norm_weight').textNumber(total, 3);

            var total = 0;
            parentTable.find('[data-id="norm_percent"]').each(function () {
                var tmp = $(this).valNumber();
                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#norm_percent').textNumber(total, 3);

            var total = 0;
            parentTable.find('[data-id="losses_weight"]').each(function () {
                var tmp = $(this).valNumber();
                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#losses_weight').textNumber(total, 3);

            var total = 0;
            parentTable.find('[data-id="norm_industrial"]').each(function () {
                var tmp = $(this).valNumber();
                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#norm_industrial').textNumber(total, 3);

        }).attr('data-action-calc-asphalt', '1');
    }

    $(document).ready(function () {
        __initCalcAsphalt();

        $('[data-id="norm_weight"]:eq(0)').each(function () {
            $(this).trigger('change');
        });
    });
</script>

<?php if(!$isShow){ ?>
<div id="new-material" data-index="0">
    <!--
    <tr>
        <td>
            <select name="shop_formula_items[_#index#][shop_material_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-action="calc-asphalt" data-id="bunker_percent" name="shop_formula_items[_#index#][options][bunker_percent]" type="text" class="form-control text-right" >
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-id="norm_percent" name="shop_formula_items[_#index#][options][norm_percent]" type="text" class="form-control text-right" placeholder="Расход (%)" readonly>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight" name="shop_formula_items[_#index#][norm_weight]" type="text" class="form-control text-right" placeholder="Расход (вес)" required >
        </td>
        <td>
            <input data-type="money" data-action="calc-asphalt" data-id="losses" name="shop_formula_items[_#index#][losses]" type="text" class="form-control text-right" placeholder="Потери (%)">
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-id="losses_weight" name="shop_formula_items[_#index#][options][losses_weight]" type="text" class="form-control text-right" placeholder="Потери (кг)" readonly>
        </td>
        <td>
            <input data-type="money" data-id="norm_industrial" name="shop_formula_items[_#index#][options][norm_industrial]" type="text" class="form-control text-right" placeholder="Производственные нормы кг)" readonly>
        </td>
        <td>
            <input data-id="is_bitumen" name="shop_formula_items[_#index#][options][is_bitumen]" value="0" style="display: none">
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>
<div id="new-material-bitumen" data-index="1000000">
    <!--
    <tr style="background-color: rgba(97, 106, 168, 0.3);">
        <td>
            <select name="shop_formula_items[_#index#][shop_material_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-action="calc-asphalt" data-id="bunker_percent" name="shop_formula_items[_#index#][options][bunker_percent]" type="text" class="form-control text-right">
        </td>
        <td>
            <input data-type="money" data-fractional-length="2" data-id="norm_percent" name="shop_formula_items[_#index#][options][norm_percent]" type="text" class="form-control text-right" placeholder="Расход (%)" readonly>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight" name="shop_formula_items[_#index#][norm_weight]" type="text" class="form-control text-right" placeholder="Расход (вес)" required>
        </td>
        <td>
            <input data-type="money" data-action="calc-asphalt" data-id="losses" name="shop_formula_items[_#index#][losses]" type="text" class="form-control text-right" placeholder="Потери (%)" required value="-" readonly>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-id="losses_weight" name="shop_formula_items[_#index#][options][losses_weight]" type="text" class="form-control text-right" placeholder="Потери (кг)" readonly>
        </td>
        <td>
            <input data-type="money" data-id="norm_industrial" name="shop_formula_items[_#index#][options][norm_industrial]" type="text" class="form-control text-right" placeholder="Производственные нормы кг)" readonly>
        </td>
        <td>
            <input data-id="is_bitumen" name="shop_formula_items[_#index#][options][is_bitumen]" value="1" style="display: none">
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>
<?php } ?>