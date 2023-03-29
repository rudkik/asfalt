<?php
$panelID = 'bill-item-'.rand(0, 10000);
?>
<input name="shop_bill_items[free][shop_room_id]" value="0" style="display: none">
<div id="<?php echo $panelID; ?>" class="col-lg-12">
    <div class="card panel panel-default panel-table" style="overflow: auto;">
        <table class="table table-bordered table-items" style="min-width: 710px;">
            <thead class="thead-default">
            <tr>
                <th>Номер</th>
                <th style="width: 110px;">Дата заезда</th>
                <th style="width: 110px;">Дата выезда</th>
                <th style="width: 64px;">Кол-во суток</th>
                <th style="width: 64px;">Кол-во<br> человек</th>
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
            if (count($data['view::_shop/bill/item/one/index']->childs) > 0) {
                foreach ($data['view::_shop/bill/item/one/index']->childs as $value) {
                    echo str_replace('#panel#', $panelID, $value->str);
                }
            }
            ?>
            </tbody>
        </table>
        <div class="card-footer">
            <button id="<?php echo $panelID; ?>-button" class="btn btn-primary" type="button" onclick="addRoom('#<?php echo $panelID; ?>-table-tr', '#<?php echo $panelID; ?>-table-body', <?php echo intval(Request_RequestParams::getParamInt('id')); ?>)">
                <?php if (count($data['view::_shop/bill/item/one/index']->childs) > 0) { ?>
                    Изменить номер
                <?php }else{ ?>
                    Выбрать номер
                <?php } ?>
            </button>
        </div>
    </div>
</div>
<script>
    function addRoom(from, to, billID) {
        var id = $(this).data('table');
        var url = '/pyramid/shoproom/free_modal';
        var modal = '#room-free-record';

        var form = $(modal);
        if (form.length == 0) {
            jQuery.ajax({
                url: url,
                data: ({
                    'bill_id': billID
                }),
                type: "POST",
                success: function (data) {
                    $('body').append(data);

                    $('#<?php echo $panelID; ?>-button').html('Изменить номер');

                    var parent = $('#<?php echo $panelID; ?>-table-tr').parents('.modal.fade');
                    parent.modal('hide');

                    var form = $(modal);
                    form.data('from', from);
                    form.data('to', to);
                    form.data('parent-modal', '#'+parent.attr('id'));
                    form.modal('show');

                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }else{
            var parent = $('#<?php echo $panelID; ?>-table-tr').parents('.modal.fade');
            form.data('parent-modal', '#'+parent.attr('id'));
            parent.modal('hide');

            form.data('from', from);
            form.data('to', to);
            form.modal('show');
        }

        return false;
    }

    function __InitRoomList(element) {
        element.find('[data-id="human_extra"], [data-id="child_extra"]').change(function () {
            var tr = $(this).parent().parent();
            var el1 = tr.find('[data-id="human_extra"]');
            var el2 = tr.find('[data-id="child_extra"]');
            var el3 = tr.find('[data-id="amount"]');

            if(el1.val() == 0){
                tr.find('[data-id="price_extra"]').css('color', '#fff');
            }else{
                tr.find('[data-id="price_extra"]').css('color', '#000');
            }

            if(el2.val() == 0){
                tr.find('[data-id="price_child"]').css('color', '#fff');
            }else{
                tr.find('[data-id="price_child"]').css('color', '#000');
            }

            var amount = Number(el1.data('price')) * Number(el1.val())
                + Number(el2.data('price')) * Number(el2.val())
                + Number(el3.data('amount'));

            el3.text(amount);
            el3.data('amount-tr', amount);

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

    __InitRoomList($('#<?php echo $panelID; ?>-table-body'));
</script>
<div id="<?php echo $panelID; ?>-table-tr" data-index="1">
<!--
<tr id="bill-item-#index#">
    <td data-id="shop_room_id">
        <input name="shop_bill_items[#index#][shop_room_id]" style="display: none">
        <span></span>
    </td>
    <td>
        <input data-id="date_from" name="shop_bill_items[#index#][date_from]" class="form-control" type="text" readonly>
    </td>
    <td>
        <input data-id="date_to" name="shop_bill_items[#index#][date_to]" class="form-control" type="text" readonly>
    </td>
    <td data-id="diff"></td>
    <td data-id="human"></td>
    <td>
        <select data-id="human_extra" name="shop_bill_items[#index#][human_extra]" class="form-control ks-select" data-parent="#<?php echo $panelID; ?>" style="width: 100%">
        </select>
    </td>
    <td data-id="price_extra" style="color: #fff">
    </td>
    <td>
        <select data-id="child_extra" name="shop_bill_items[#index#][child_extra]" class="form-control ks-select" data-parent="#<?php echo $panelID; ?>" style="width: 100%">
        </select>
    </td>
    <td data-id="price_child" style="color: #fff"></td>
    <td data-id="amount"></td>
    <td>
    <input data-id="id" name="shop_bill_items[#index#][id]" value="#index#" style="display: none">
        <input data-id="amount-input" name="shop_bill_items[#index#][amount]" value="0" style="display: none">
        <input data-id="price" name="shop_bill_items[#index#][price]" value="0" style="display: none">
        <button type="button" class="close" aria-label="Close" data-action="tr-delete-free">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
    </td>
</tr>
-->
</div>