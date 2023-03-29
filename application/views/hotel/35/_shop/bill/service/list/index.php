<?php
$panelID = 'bill-service-'.rand(0, 10000);
?>
<input name="shop_bill_services[free][shop_service_id]" value="0" style="display: none">
<div id="<?php echo $panelID; ?>" class="col-lg-12">
    <div class="card panel panel-default panel-table" style="overflow: auto;">
        <table class="table table-bordered table-items" style="min-width: 710px;">
            <thead class="thead-default">
            <tr>
                <th>Услуга / Штраф</th>
                <th style="width: 111px;">Дата</th>
                <th style="width: 74px;">Цена</th>
                <th style="width: 104px;">Кол-во</th>
                <th style="width: 81px;">Сумма</th>
                <th style="width: 30px;"></th>
            </tr>
            </thead>
            <tbody id="<?php echo $panelID; ?>-table-body" data-index="0">
            <?php
            if (count($data['view::_shop/bill/service/one/index']->childs) > 0) {
                foreach ($data['view::_shop/bill/service/one/index']->childs as $value) {
                    echo $value->str;
                }
            }
            ?>
            </tbody>
        </table>
        <div class="card-footer">
            <button class="btn btn-primary" type="button" onclick="addService('#<?php echo $panelID; ?>-table-tr', '#<?php echo $panelID; ?>-table-body')">Добавить услугу</button>
        </div>
    </div>
</div>
<script>
    function addService(from, to) {
        addTr(from, to);

        __InitServiceList($('#<?php echo $panelID; ?>-table-body'));
        return false;
    }

    function __InitServiceList(element) {
        element.find('[data-id="shop_service_id"], [data-id="quantity"]').change(function () {
            var tr = $(this).parent().parent();

            var service = tr.find('[data-id="shop_service_id"]');
            var price = Number(tr.find('[data-id="'+service.val()+'"]').data('price'));

            var quantity = Number(tr.find('[data-id="quantity"]').val());
            var amount = price * quantity;

            tr.find('[data-id="price"]').html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(price).replace(',', '.'));
            var el = tr.find('[data-id="amount"]');
            el.html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(amount).replace(',', '.'));
            el.data('amount-tr', amount);

            var parent = $('#<?php echo $panelID; ?>-table-body');
            parent = parent.parents('.modal.fade');

            var total = 0;
            parent.find('[data-id="amount"]').each(function (i) {
                total = total + Number($(this).data('amount-tr'));
            });

            var discount = Number(parent.find('[data-id="discount"]').val());
            if (discount !== undefined) {
                total = total / 100 * (100 - discount);
            }

            var el = parent.find('[data-id="total"]');
            el.val(total);
            el.data('amount', total);
        });

        // удаление записи в таблицы
        element.find('td [data-action="tr-delete-free"]').click(function () {
            var parent = $(this).parent().parent();
            var tr = parent.parent();

            parent.remove();

            var parent = tr.parents('form');

            var total = 0;
            parent.find('[data-id="amount"]').each(function (i) {
                total = total + Number($(this).data('amount-tr'));
            });

            var discount = Number(parent.find('[data-id="discount"]').val());
            if (discount !== undefined) {
                total = total / 100 * (100 - discount);
            }

            parent.find('[data-id="total"]').val(total);

            return false;
        });
    }

    __InitServiceList($('#<?php echo $panelID; ?>-table-body'));
</script>
<div id="<?php echo $panelID; ?>-table-tr" data-index="1">
    <!--
    <tr>
        <td>
            <select data-id="shop_service_id" name="shop_bill_services[#index#][shop_service_id]" class="form-control ks-select" data-parent="##parent-select#" style="width: 100%">
                <option data-id="0" value="0" data-price="0">Выберите услугу</option>
                <?php echo $siteData->globalDatas['view::_shop/service/list/list']; ?>
            </select>
        </td>
        <td>
            <input data-id="date" name="shop_bill_services[#index#][date]" class="form-control" data-type="date" type="datetime" value="<?php echo date('d.m.Y'); ?>">
        </td>
        <td data-id="price"></td>
        <td>
            <input data-id="quantity" name="shop_bill_services[#index#][quantity]" class="form-control" type="text" value="0">
        </td>
        <td data-id="amount"></td>
        <td>
            <button type="button" class="close" aria-label="Close" data-action="tr-delete-free">
                <span aria-hidden="true" class="fa fa-close"></span>
            </button>
        </td>
    </tr>
    -->
</div>