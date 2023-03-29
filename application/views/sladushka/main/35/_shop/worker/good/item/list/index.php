<?php
$panelID = 'worker-good-item-'.rand(0, 10000);
?>

<div class="col-lg-12">
    <div class="card panel panel-default panel-table">
        <table id="<?php echo $panelID; ?>" class="table table-bordered table-items">
            <thead class="thead-default">
            <tr>
                <th>Продукция</th>
                <th style="width: 70px;">Вес (кг)</th>
                <th style="width: 70px;">Цена</th>
                <th style="width: 110px;">Забрал</th>
                <th style="width: 110px;">Вернул</th>
                <th style="width: 110px;">Продано</th>
                <th style="width: 100px;">Сумма</th>
            </tr>
            </thead>
            <tbody id="<?php echo $panelID; ?>-table-body" data-index="0">
            <?php
            if (count($data['view::_shop/worker/good/item/one/index']->childs) > 0) {
                foreach ($data['view::_shop/worker/good/item/one/index']->childs as $value) {
                    echo str_replace('#parent-select#', $panelID, $value->str);
                }
            }
            ?>
            </tbody>
        </table>
        <div class="card-footer">
            <button class="btn btn-primary" type="button" onclick="addGoods('#<?php echo $panelID; ?>-table-tr', '#<?php echo $panelID; ?>-table-body')">Добавить товар</button>
        </div>
    </div>
</div>
<div id="<?php echo $panelID; ?>-table-tr" data-index="1">
    <!--
    <tr>
        <td>
            <select data-id="shop_good_id" name="shop_worker_good_items[#index#][shop_good_id]" class="form-control ks-select" data-parent="#<?php echo $panelID; ?>" style="width: 100%">
                <option data-id="0" value="0" data-price="0">Выберите товар</option>
                <?php echo $siteData->replaceDatas['view::_shop/good/list/list'];?>
            </select>
        </td>
        <td data-id="weight"></td>
        <td data-id="price"></td>
        <td>
            <input data-id="took" data-action="total" name="shop_worker_good_items[#index#][took]" class="form-control money-format" type="text">
        </td>
        <td>
            <input data-id="return" data-action="total" name="shop_worker_good_items[#index#][return]" class="form-control money-format" type="text">
        </td>
        <td data-id="quantity"></td>
        <td data-id="amount"
            data-total="#invoice-commercial-new-amount"
            data-price="0" data-weight="0"></td>
        <td>
            <button type="button" class="close" aria-label="Close" data-action="tr-delete">
                <span aria-hidden="true" class="fa fa-close"></span>
            </button>
        </td>
    </tr>
    -->
</div>
<script>
    function addGoods(from, to) {
        addTr(from, to);
        __InitGoodList($('#<?php echo $panelID; ?>-table-body'));
        return false;
    }

    function __InitGoodList(element) {
        element.find('[data-action="total"]').change(function () {
            var parent = $(this).parent().parent();
            var took = Number(parent.find('[data-id="took"]').val());
            var retur = Number(parent.find('[data-id="return"]').val());

            parent.find('[data-id="quantity"]').html(took - retur);

            var el = parent.find('[data-id="amount"]');
            var price = Number(el.data('price'));
            var weight = Number(el.data('weight'));

            var amount = (took - retur) * price * weight;
            el.html(amount);
            el.data('amount', amount);

            parent = parent.parent();

            var total = 0;
            parent.find('[data-id="amount"]').each(function (i) {
                total = total + Number($(this).data('amount'));
            });
            $(this).parents('.modal-dialog').find('[data-id="total-all"]').val(total);
        });

        // удаление записи в таблицы
        element.find('td [data-action="tr-delete"]').click(function () {
            var parent = $(this).parent().parent();
            var tr = parent.parent();

            parent.remove();

            var total = 0;
            tr.parent().find('[data-id="amount"]').each(function (i) {
                total = total + Number($(this).data('amount'));
            });
            tr.parents('.modal-dialog').find('[data-id="total-all"]').val(total);

            return false;
        });

        element.find('[data-id="shop_good_id"]').change(function () {
            var parent = $(this).parent().parent();
            var option = $(this).find('option:selected');

            var weight = Number(option.data('weight'));
            parent.find('[data-id="weight"]').html(weight);

            var price = Number(option.data('price'));
            parent.find('[data-id="price"]').html(price);

            var el = parent.find('[data-id="amount"]');
            el.data('price', price)
            el.data('weight', weight)
            parent.find('[data-action="total"]').trigger('change');
        });
    }

    __InitGoodList($('#<?php echo $panelID; ?>-table-body'));
</script>