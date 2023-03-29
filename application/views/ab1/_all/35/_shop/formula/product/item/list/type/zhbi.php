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
                <th>Материал</th>
                <th class="text-center width-140">Расход материалов кг, м3</th>
                <?php if(!$isShow){ ?>
                <th class="width-85"></th>
                <?php } ?>
            </tr>
            </thead>
            <tbody id="materials">
            <?php
            foreach ($data['view::_shop/formula/product/item/one/type/zhbi']->childs as $value) {
                echo $value->str;
            }
            ?>
            <tr data-id="table-total" class="total">
                <td>Итого</td>
                <td id="norm_weight" class="text-right"></td>
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

            var total = 0;
            parentTable.find('[data-id="norm_weight"]').each(function () {
                var tmp = $(this).valNumber();
                if ($.isNumeric(tmp)) {
                    total = total + tmp;
                }
            });
            $('#norm_weight').textNumber(total, 3);

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
            <input data-type="money" data-fractional-length="3" data-action="calc-asphalt" data-id="norm_weight" name="shop_formula_items[_#index#][norm_weight]" type="text" class="form-control text-right" placeholder="Расход (вес)" required >
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
<?php } ?>