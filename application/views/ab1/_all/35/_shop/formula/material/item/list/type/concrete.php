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
                <th rowspan="2" colspan="2">Сырье / Материал</th>
                <th class="text-center" colspan="2">Норма расхода на 1 м3 </th>
                <th class="width-140 text-center" rowspan="2">Норматив технологических потерь (%)</th>
                <th class="width-140 text-center" colspan="2">Производственные нормы расхода на 1 м3</th>
                <?php if(!$isShow){ ?>
                <th class="width-85" rowspan="2"></th>
                <?php } ?>
            </tr>
            <tr>
                <th class="text-center width-120">кг</th>
                <th class="text-center width-120">л</th>
                <th class="text-center width-120">кг</th>
                <th class="text-center width-120">л</th>
            </tr>
            </thead>
            <tbody id="materials">
            <?php
            foreach ($data['view::_shop/formula/material/item/one/type/concrete']->childs as $value) {
                echo $value->str;
            }
            ?>
            <tr data-id="table-total" class="total">
                <td colspan="2">Итого</td>
                <td id="norm_weight" colspan="2" class="text-center"></td>
                <td class="text-center">-</td>
                <td id="norm_industrial" colspan="2" class="text-center"></td>
                <?php if(!$isShow){ ?>
                <td></td>
                <?php } ?>
            </tr>
            </tbody>
        </table>
        <?php if(!$isShow){ ?>
        <div class="modal-footer text-right">
            <button type="button" class="btn btn-danger" onclick="addElementCalcAsphalt('new-material', 'materials', true);">Добавить материал в кг</button>
            <button type="button" class="btn btn-success" onclick="addElementCalcAsphalt('new-material-liter', 'materials', true);">Добавить материал в л</button>
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

        $('[data-id="raw"]:not([data-raw="1"])').change(function () {
            if(Number($(this).val()) > 0) {
                var parentTr = $(this).closest('tr');
                parentTr.find('[data-id="material"]').val(0).trigger('change');
            }
        }).attr('data-raw', 1);

        $('[data-id="material"]:not([data-material="1"])').change(function () {
            if(Number($(this).val()) > 0) {
                var parentTr = $(this).closest('tr');
                parentTr.find('[data-id="raw"]').val(0).trigger('change');
            }
        }).attr('data-material', 1);

        $('[data-action="calc-asphalt"]:not([data-action-calc-asphalt="1"])').change(function () {
            var parentTable = $(this).closest('table');
            var parentTr = $(this).closest('tr');

            var normWeight = parentTr.find('[data-id="norm_weight"]').valNumber();
            if ($.isNumeric(normWeight)) {
                var losses = parentTr.find('[data-id="losses"]').valNumber();
                if ($.isNumeric(losses)) {
                    var lossesWeight = (normWeight / 100 * losses).toFixed(2);
                    parentTr.find('[data-id="norm_industrial"]').val(normWeight + Number(lossesWeight));
                }
            }

            // считаем итоги
            var total = 0;
            parentTable.find('[data-id="norm_weight"]').each(function () {
                var tmp = $(this).valNumber();
                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#norm_weight').textNumber(total, 3);

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

<div id="new-material" data-index="0">
    <!--
    <tr>
        <td style="width: 50%;">
            <select data-id="material" name="shop_formula_items[_#index#][shop_raw_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/raw/list/list']; ?>
            </select>
        </td>
        <td style="width: 50%;">
            <select data-id="raw" name="shop_formula_items[_#index#][shop_material_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
            </select>
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight" name="shop_formula_items[_#index#][norm_weight]" type="text" class="form-control text-right" placeholder="Расход (кг)" required >
        </td>
        <td class="text-center"> - </td>
        <td>
            <input data-type="money" data-action="calc-asphalt" data-id="losses" name="shop_formula_items[_#index#][losses]" type="text" class="form-control text-right" placeholder="Потери (%)">
        </td>
        <td>
            <input data-type="money" data-id="norm_industrial" name="shop_formula_items[_#index#][options][norm_industrial]" type="text" class="form-control text-right" placeholder="Производственные нормы (кг)" readonly>
        </td>
        <td class="text-center"> - </td>
        <td>
            <input data-id="is_bitumen" name="shop_formula_items[_#index#][options][is_liter]" value="0" style="display: none">
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>
<div id="new-material-liter" data-index="1000000">
    <!--
    <tr style="background-color: rgba(97, 106, 168, 0.3);">
        <td style="width: 50%;">
            <select data-id="material" name="shop_formula_items[_#index#][shop_raw_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/raw/list/list']; ?>
            </select>
        </td>
        <td style="width: 50%;">
            <select data-id="raw" name="shop_formula_items[_#index#][shop_material_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
            </select>
        </td>
        <td class="text-center"> - </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight" name="shop_formula_items[_#index#][norm_weight]" type="text" class="form-control text-right" placeholder="Расход (л)" required>
        </td>
        <td>
            <input data-type="money" data-action="calc-asphalt" data-id="losses" name="shop_formula_items[_#index#][losses]" type="text" class="form-control text-right" placeholder="Потери (%)" required>
        </td>
        <td class="text-center"> - </td>
        <td>
            <input data-type="money" data-id="norm_industrial" name="shop_formula_items[_#index#][options][norm_industrial]" type="text" class="form-control text-right" placeholder="Производственные нормы (л)" readonly>
        </td>
        <td>
            <input data-id="is_bitumen" name="shop_formula_items[_#index#][options][is_liter]" value="1" style="display: none">
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>