/*function addTr(from, to) {
    var form = $(from);
    var index = form.data('index');
    form.data('index', Number(index) + 1);

    var tmp = $.trim(form.html().replace('<!--', '').replace('-->', '').replace(/#index#/g, '_' + index));

    var element = $(to).append(tmp);
    $('.select2').select2();

    return false;
}*/

/*function __initTrRoomType(element) {
    element.find('.select2').select2();

    element.find('form [data-action="free-room-type"]').change(function () {
        var parent = $(this).parents('tr');
        var shopRoomTypeID = parent.find('[name="shop_room_type_id"]').val();
        var adults = parent.find('[name="adults"]').val();
        var childs = parent.find('[name="childs"]').val();

        jQuery.ajax({
            url: '/hotel/room/get_amount',
            data: ({
                shop_room_type_id: (shopRoomTypeID),
                adults: (adults),
                childs: (childs),
                date_from: (''),
                date_to: (''),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                var el = parent.find('[data-id="amount"]');
                var oldAmount = Number(el.data('amount'));
                el.data('amount', obj.amount);
                el.find('b').html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(obj.amount)+' тг');

                var el = $('#<?php echo $panelID; ?> [data-id="total"]');
                var amount = Number(el.data('amount')) - oldAmount + obj.amount;
                el.find('b').html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(amount)+' тг');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
}

function addTr(from, to) {
    var form = $(from);
    var index = form.data('index');
    form.data('index', Number(index) + 1);

    var tmp = $.trim(form.html().replace('<!--', '').replace('-->', '').replace(/#index#/g, '_' + index));

    var element = $(to).append(tmp);
    __initTrRoomType($(to));

    return false;
}*/