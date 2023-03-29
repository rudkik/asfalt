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
                <th class="text-center" colspan="5">Количество компонентов</th>
            </tr>
            <tr>
                <th class="text-center width-140">% рецепта от</th>
                <th class="text-center width-140">% рецепта до</th>
                <th class="text-center width-140">кг рецепта от</th>
                <th class="text-center width-140">кг рецепта до</th>
                <th class="text-center width-140">кг системы</th>
            </tr>
            </thead>
            <tbody id="materials">
            <tr><td colspan="6"><b>Сырьё</b></td></tr>
            <?php if(count($data['view::_shop/formula/material/item/one/type/bitumen-fuel-oil']->childs) == 0){ ?>
                <tr>
                    <td>
                        <select name="shop_formula_items[__1][shop_material_id]" class="form-control select2" required style="width: 100%;">
                            <option value="0" data-id="0">Без значения</option>
                            <?php echo $siteData->globalDatas['view::_shop/material/list/list'];?>
                        </select>
                    </td>
                    <td colspan="2">
                        <input data-type="money" data-fractional-length="2" name="shop_formula_items[__1][options][norm_percent]" type="text" class="form-control text-right" placeholder="Расход (%)" required value="100">
                    </td>
                    <td>
                        <input data-type="money" data-fractional-length="3" name="shop_formula_items[__1][options][norm_weight_from]" type="text" class="form-control text-right" placeholder="Расход (вес)" required>
                    </td>
                    <td>
                        <input data-type="money" data-fractional-length="3" name="shop_formula_items[__1][options][norm_weight_to]" type="text" class="form-control text-right" placeholder="Расход (вес)" required>
                    </td>
                    <td>
                        <input data-type="money" data-fractional-length="3" name="shop_formula_items[__1][norm_weight]" type="text" class="form-control text-right" placeholder="Расход (вес)" required>
                    </td>
                    <td></td>
                </tr>
            <?php } ?>
            <?php
            foreach ($data['view::_shop/formula/material/item/one/type/bitumen-fuel-oil']->childs as $value) {
                echo $value->str;
            }
            $dataMaterial = Arr::path($data['view::_shop/formula/material/item/one/type/bitumen-fuel-oil']->additionDatas['material'], 'options', array());
            ?>
            <tr><td colspan="6"><b>Получаемые продукты</b></td></tr>
            <tr>
                <td id="material"></td>
                <td>
                    <input data-type="money" data-fractional-length="2" data-action="calc-asphalt" data-id="norm_percent_from" name="options[product][norm_percent_from]" type="text" class="form-control text-right" placeholder="Расход (%)" value="<?php echo Arr::path($dataMaterial, 'product.norm_percent_from', ''); ?>" required>
                </td>
                <td>
                    <input data-type="money" data-fractional-length="2" data-action="calc-asphalt" data-id="norm_percent_to" name="options[product][norm_percent_to]" type="text" class="form-control text-right" placeholder="Расход (%)" value="<?php echo Arr::path($dataMaterial, 'product.norm_percent_to', ''); ?>" required>
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight_from" name="options[product][norm_weight_from]" type="text" class="form-control text-right" placeholder="Расход (вес)" value="<?php echo Arr::path($dataMaterial, 'product.norm_weight_from', ''); ?>" required>
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight_to" name="options[product][norm_weight_to]" type="text" class="form-control text-right" placeholder="Расход (вес)" value="<?php echo Arr::path($dataMaterial, 'product.norm_weight_to', ''); ?>" required>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Топливный нефтяной компонент</td>
                <td>
                    <input data-type="money" data-fractional-length="2" data-action="calc-asphalt" data-id="norm_percent_from" name="options[oil_component][norm_percent_from]" type="text" class="form-control text-right" placeholder="Расход (%)" value="<?php echo Arr::path($dataMaterial, 'oil_component.norm_percent_from', ''); ?>" required>
                </td>
                <td>
                    <input data-type="money" data-fractional-length="2" data-action="calc-asphalt" data-id="norm_percent_to" name="options[oil_component][norm_percent_to]" type="text" class="form-control text-right" placeholder="Расход (%)" value="<?php echo Arr::path($dataMaterial, 'oil_component.norm_percent_to', ''); ?>" required>
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight_from" name="options[oil_component][norm_weight_from]" type="text" class="form-control text-right" placeholder="Расход (вес)" value="<?php echo Arr::path($dataMaterial, 'oil_component.norm_weight_from', ''); ?>" required>
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight_to" name="options[oil_component][norm_weight_to]" type="text" class="form-control text-right" placeholder="Расход (вес)" value="<?php echo Arr::path($dataMaterial, 'oil_component.norm_weight_to', ''); ?>" required>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Потери в виде газов </td>
                <td>
                    <input data-type="money" data-fractional-length="2" data-action="calc-asphalt" data-id="norm_percent_from" name="options[losses_gas][norm_percent_from]" type="text" class="form-control text-right" placeholder="Расход (%)" value="<?php echo Arr::path($dataMaterial, 'losses_gas.norm_percent_from', ''); ?>" required>
                </td>
                <td>
                    <input data-type="money" data-fractional-length="2" data-action="calc-asphalt" data-id="norm_percent_to" name="options[losses_gas][norm_percent_to]" type="text" class="form-control text-right" placeholder="Расход (%)" value="<?php echo Arr::path($dataMaterial, 'losses_gas.norm_percent_to', ''); ?>" required>
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight_from" name="options[losses_gas][norm_weight_from]" type="text" class="form-control text-right" placeholder="Расход (вес)" value="<?php echo Arr::path($dataMaterial, 'losses_gas.norm_weight_from', ''); ?>" required>
                </td>
                <td>
                    <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight_to" name="options[losses_gas][norm_weight_to]" type="text" class="form-control text-right" placeholder="Расход (вес)" value="<?php echo Arr::path($dataMaterial, 'losses_gas.norm_weight_to', ''); ?>" required>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr data-id="table-total" class="total">
                <td>Итого</td>
                <td id="norm_percent_from" class="text-right"></td>
                <td id="norm_percent_to" class="text-right"></td>
                <td id="norm_weight_from" class="text-right"></td>
                <td id="norm_weight_to" class="text-right"></td>
                <td class="text-right">-</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $('#shop_material_id').change(function () {
        $('#material').text($(this).find('option:selected').text());
    });

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

            // считаем итоги
            var total = 0;
            parentTable.find('[data-id="norm_percent_from"]').each(function () {
                var tmp = $(this).valNumber();

                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#norm_percent_from').textNumber(total, 3));

            var total = 0;
            parentTable.find('[data-id="norm_percent_to"]').each(function () {
                var tmp = $(this).valNumber();
                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#norm_percent_to').textNumber(total, 3));

            var total = 0;
            parentTable.find('[data-id="norm_weight_from"]').each(function () {
                var tmp = $(this).valNumber();
                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#norm_weight_from').textNumber(total, 3));

            var total = 0;
            parentTable.find('[data-id="norm_weight_to"]').each(function () {
                var tmp = $(this).valNumber();

                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#norm_weight_to').textNumber(total, 3);

        }).attr('data-action-calc-asphalt', '1');
    }

    $(document).ready(function () {
        __initCalcAsphalt();

        $('[data-id="norm_percent_to"]:eq(0)').each(function () {
            $(this).trigger('change');
        });

        $('#shop_material_id').trigger('change');
    });
</script>