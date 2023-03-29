<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Производство
            </label>
        </div>
        <div class="col-md-9">
            <table class="table table-hover table-db table-tr-line" data-action="fixed">
                <tr>
                    <th>Материал/Сырье</th>
                    <th class="width-100">Норма (%)</th>
                    <th class="width-100 text-right">Кол-во</th>
                </tr>
                <tbody id="materials">
                <?php
                foreach ($data['view::_shop/raw/material/item/one/index']->childs as $value) {
                    echo $value->str;
                }
                ?>
                <tr class="total">
                    <td>Итого</td>
                    <td id="total_norm" class="text-center"></td>
                    <td id="total_quantity" class="text-right"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php if(!$isShow){ ?>
    <script>
        function __initRawMaterial() {
            $('[data-id="norm"]:not([data-norm="1"])').change(function () {
                var norm = $(this).valNumber();
                var quantity = $('#quantity').valNumber();

                var quantity = (quantity / 100 * norm).toFixed(3);

                var parentTr = $(this).closest('tr');
                parentTr.find('[data-id="quantity"]').val(quantity);

                var totalNorm = 0;
                var totalQuantity = 0;
                $('[data-id="norm"]').each(function (i) {
                    var norm = $(this).valNumber();
                    var quantity = $('#quantity').valNumber();
                    quantity = Number((quantity / 100 * norm).toFixed(3));

                    totalNorm = totalNorm + norm;
                    totalQuantity = totalQuantity + quantity;
                });

                $('#total_norm').textNumber(totalNorm, 2);
                $('#total_quantity').textNumber(totalQuantity, 3);
            }).attr('data-norm', 1);

            $('[data-id="quantity"]:not([data-quantity="1"])').change(function () {
                var quantity = $(this).valNumber();
                var quantityTotal = $('#quantity').valNumber();

                var norm = (quantity / quantityTotal * 100).toFixed(2);

                var parentTr = $(this).closest('tr');
                parentTr.find('[data-id="norm"]').val(norm).trigger('change');


            }).attr('data-quantity', 1);
        }
        __initRawMaterial();
    </script>
<?php } ?>

