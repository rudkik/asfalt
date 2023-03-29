<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Рецепт
            </label>
        </div>
        <div class="col-md-9">
            <table class="table table-hover table-db table-tr-line" data-action="fixed">
                <tr>
                    <th colspan="2">Материал/Сырье</th>
                    <th class="tr-header-amount">Норма (%)</th>
                    <?php if(!$isShow){ ?>
                        <th class="tr-header-buttom"></th>
                    <?php } ?>
                </tr>
                <tbody id="materials">
                <?php
                foreach ($data['view::_shop/formula/raw/item/one/index']->childs as $value) {
                    echo $value->str;
                }
                ?>
                <tr data-id="table-total" class="total">
                    <td colspan="2">Итого</td>
                    <td id="norm" class="text-center"></td>
                    <?php if(!$isShow){ ?>
                        <td></td>
                    <?php } ?>
                </tr>
                </tbody>
            </table>
            <?php if(!$isShow){ ?>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-danger" onclick="addElementCalcAsphalt('new-material', 'materials', true);">Добавить материал</button>
                </div>
            <?php } ?>
        </div>
    </div>
<?php if(!$isShow){ ?>
    <script>
        function addElementCalcAsphalt(from, to, isLast){
            addElement(from, to, isLast);
            __initCalcAsphalt();
        }

        function __initCalcAsphalt() {
            $('[data-id="raw"]:not([data-raw="1"])').change(function () {
                if (Number($(this).val()) > 0) {
                    var parentTr = $(this).closest('tr');
                    parentTr.find('[data-id="material"]').val(0).trigger('change');
                }
            }).attr('data-raw', 1);

            $('[data-id="material"]:not([data-material="1"])').change(function () {
                if (Number($(this).val()) > 0) {
                    var parentTr = $(this).closest('tr');
                    parentTr.find('[data-id="raw"]').val(0).trigger('change');
                }
            }).attr('data-material', 1);

            $('[data-id="norm"]:not([data-calc-norm="1"])').change(function () {
                var parentTable = $(this).closest('table');

                var total = 0;
                parentTable.find('[data-id="norm"]').each(function () {
                    var tmp = $(this).valNumber();
                    if ($.isNumeric(tmp)) {
                        total = total + tmp;
                    }
                });
                $('#norm').textNumber(total, 2);

            }).attr('data-calc-norm', '1');
        }

        $(document).ready(function () {
            __initCalcAsphalt();

            $('[data-id="norm"]:eq(0)').each(function () {
                $(this).trigger('change');
            });
        });
    </script>
    <div id="new-material" data-index="0">
        <!--
        <tr>
            <td style="width: 50%;">
                <select data-id="raw" name="shop_formula_items[_#index#][shop_material_id]" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
                </select>
            </td>
            <td style="width: 50%;">
                <select data-id="material" name="shop_formula_items[_#index#][shop_raw_id]" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/raw/list/list']; ?>
                </select>
            </td>
            <td>
                <input data-id="norm" name="shop_formula_items[_#index#][norm]" type="text" class="form-control" placeholder="Норма (%)" required value="0">
            </td>
            <td>
                <ul class="list-inline tr-button delete">
                    <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                </ul>
            </td>
        </tr>
        -->
    </div>
<?php } ?>

