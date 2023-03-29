<?php
$panelID = 'payment-item-'.rand(0, 10000);
?>

<div id="<?php echo $panelID; ?>" class="col-lg-12">
    <div class="card panel panel-default panel-table" style="overflow: auto;">
        <table class="table table-bordered table-items" style="min-width: 710px;">
            <thead class="thead-default">
            <tr>
                <th>Комната</th>
                <th style="width: 110px;">Дата от</th>
                <th style="width: 110px;">Дата до</th>
                <th style="width: 74px;">Цена</th>
                <th style="width: 64px;">Доп. взрослых</th>
                <th style="width: 84px;">Цена взрослых</th>
                <th style="width: 64px;">Доп. детских</th>
                <th style="width: 84px;">Цена детских</th>
                <th style="width: 81px;">Сумма</th>
                <th style="width: 30px;"></th>
            </tr>
            </thead>
            <tbody id="<?php echo $panelID; ?>-table-body" data-index="0">
            <?php
            if (count($data['view::_shop/payment/item/one/index']->childs) > 0) {
                foreach ($data['view::_shop/payment/item/one/index']->childs as $value) {
                    echo str_replace('#parent-select#', $panelID, $value->str);
                }
            }
            ?>
            </tbody>
        </table>
        <div class="card-footer">
            <button class="btn btn-primary" type="button" onclick="addRoom('#<?php echo $panelID; ?>-table-tr', '#<?php echo $panelID; ?>-table-body')">Добавить номер</button>
        </div>
    </div>
</div>
<script>
    function addRoom(from, to) {
        addTr(from, to);
        __InitRoomList($('#<?php echo $panelID; ?>-table-body'));
        return false;
    }

    function __InitRoomList(element) {
        element.find('[data-id="shop_room_id"], [data-id="date_from"], [data-id="date_to"], [data-id="human_extra"], [data-id="child_extra"]').change(function () {
            var parent = $('#<?php echo $panelID; ?>-table-body');

            var room = parent.find('[data-id="shop_room_id"]');
            var option = room.find('[data-id="'+room.val()+'"]');

            var dateFrom = parent.find('[data-id="date_from"]').val();
            var dateTo = parent.find('[data-id="date_to"]').val();

            if((dateFrom != '') && (dateTo != '')) {
                var date1 = new Date(dateFrom.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1'));
                var date2 = new Date(dateTo.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1'));
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                if (diffDays < 0) {
                    diffDays = 0;
                }
            }else{
                diffDays = 0;
            }

            parent.find('[data-id="price"]').html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(Number(option.data('price'))).replace(',', '.'));
            parent.find('[data-id="price_extra"]').html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(Number(option.data('price_extra'))).replace(',', '.'));
            parent.find('[data-id="price_child"]').html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(Number(option.data('price_child'))).replace(',', '.'));

            var amount = Number(option.data('price'))
                + Number(option.data('price_extra')) * Number(parent.find('[data-id="human_extra"]').val())
                + Number(option.data('price_child')) * Number(parent.find('[data-id="child_extra"]').val());
            amount = amount * diffDays;
            parent.find('[data-id="amount"]').html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(amount).replace(',', '.'));
            parent.find('[data-id="amount"]').data('amount', amount);

            var tr = $(this).parent().parent().parent();

            var total = 0;
            tr.find('[data-id="amount"]').each(function (i) {
                total = total + Number($(this).data('amount'));
            });

            tr = tr.parents('.modal.fade');
            var el = tr.find('[data-id="total"]');
            el.val(total);
            el.data('amount', total);

            tr.find('[data-id="pay-percent"]').trigger('change');
        });

        // удаление записи в таблицы
        element.find('td [data-action="tr-delete-free"]').click(function () {
            var parent = $(this).parent().parent();
            var tr = parent.parent();

            parent.remove();

            var total = 0;
            tr.parent().find('[data-id="amount"]').each(function (i) {
                total = total + Number($(this).data('amount'));
            });
            tr.parents('.modal.fade').find('[data-id="total"]').val(total);

            return false;
        });

        fields = element.find('input[type="datetime"]:not([data-datetime="1"])');
        if (fields.length > 0) {
            fields.attr('data-datetime', 1);

            fields.datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            });
        }

        fields = element.find('td[data-id="shop_room_id"] select:not([data-shop_room_id="1"])');
        if (fields.length > 0) {
            fields.attr('data-shop_room_id', 1);

            fields.datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            });
        }
    }

    __InitRoomList($('#<?php echo $panelID; ?>-table-body'));
</script>
<div id="<?php echo $panelID; ?>-table-tr" data-index="1">
    <!--
    <tr>
        <td>
            <select data-id="shop_room_id" name="shop_payment_items[#index#][shop_room_id]" class="form-control ks-select" data-parent="#<?php echo $panelID; ?>"style="width: 100%">
                <option data-id="0" value="0">Выберите номер</option>
                <?php echo $siteData->globalDatas['view::_shop/room/list/list']; ?>
            </select>
        </td>
        <td>
            <input data-id="date_from" name="shop_payment_items[#index#][date_from]" class="form-control" type="datetime">
        </td>
        <td>
            <input data-id="date_to" name="shop_payment_items[#index#][date_to]" class="form-control" type="datetime" >
        </td>
        <td data-id="price"></td>
        <td>
            <input data-id="human_extra" name="shop_payment_items[#index#][human_extra]" class="form-control" type="text">
        </td>
        <td data-id="price_extra">
        </td>
        <td>
            <input data-id="child_extra" name="shop_payment_items[#index#][child_extra]" class="form-control" type="text">
        </td>
        <td data-id="price_child">
        </td>
        <td data-id="amount">
        </td>
        <td>
            <button type="button" class="close" aria-label="Close" data-action="tr-delete-free">
                <span aria-hidden="true" class="fa fa-close"></span>
            </button>
        </td>
    </tr>
    -->
</div>