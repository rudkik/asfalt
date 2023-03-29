<link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic; ?>/css/pyramid/assets/styles/apps/projects/grid-board.min.css">
<div id="room-free-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Бронирование номера</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <div class="has-validation-callback">
                <div class="modal-body" style="padding: 10px 20px">
                    <div class="container-fluid">
                        <div id="room-free-find">
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-4">
                                    <label for="date_from" class="col-form-label">Дата заезда</label>
                                    <div class="form-group">
                                        <input name="date_from" class="form-control" id="date_from" type="datetime" autocomplete="off" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']);?>">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="date_to" class="col-form-label">Дата выезда</label>
                                    <div class="form-group">
                                        <input name="date_to" class="form-control" id="date_to" type="datetime" autocomplete="off" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']);?>">
                                    </div>
                                </div>
                            </div>
                            <input name="bill_id" style="display: none" value="<?php echo $data->values['bill_id'];?>; ?>">
                        </div>
                        <h4 class="text-center" style="margin-top: 20px">Номера</h4>
                        <div id="list-free-rooms" class="row">
                            <?php echo trim($siteData->replaceDatas['view::_shop/room/list/free']); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-left">
                        <label data-id="total" class="col-form-label">Общее</label>
                    </div>
                        <div class="pull-right">
                        <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                        <button type="button" onclick="selectRoom()" class="btn btn-primary">Выбрать</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function groupItems() {
        var modal = $('#room-free-record');
        var $that = $(modal.data('parent-modal')).find('form');
        var formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)

        jQuery.ajax({
            url: '/pyramid/shopbill/group_items',
            data: formData,
            type: "POST",
            contentType: false, // важно - убираем форматирование данных по умолчанию
            processData: false, // важно - убираем преобразование строк по умолчанию
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                var toForm = $(modal.data('to'));
                $.each(obj, function(key, value) {
                    var child = toForm.find('#bill-item-'+value.id);

                    child.find('[data-id="date_from"]').val(value.date_from);
                    child.find('[data-id="date_to"]').val(value.date_to);

                    var date1 = value.date_from;
                    var date2 = value.date_to;
                    date1 = new Date(date1.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1'));
                    date2 = new Date(date2.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1'));
                    var timeDiff = Math.abs(date2.getTime() - date1.getTime()) + 1;
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) - 1;

                    child.find('[data-id="diff"]').html(diffDays);

                    var el3 = child.find('[data-id="amount"]');
                    el3.text(value.amount);
                    el3.data('amount', value.amount);

                    child.find('[data-id="amount-input"]').val(value.amount).attr('value', value.amount);
                    child.attr('select', '1');
                });

                toForm.find('tr:not([select="1"])').remove();
                toForm.find('[data-id="human_extra"]').trigger('change');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }
    function selectRoom() {
        var selects = $('#room-free-record td.active[data-action="select"]');
        if(selects.length < 1){
            return false;
        }

        var modal = $('#room-free-record');

        var form = $(modal.data('from'));
        var index = form.data('index');

        var toForm = $(modal.data('to'));
        toForm.html('');

        selects.each(function (i) {
            var select = $(this);

            var html = $.trim(form.html().replace('<!--', '').replace('-->', '').replace(/#index#/g, '_' + index));
            toForm.append(html);
            var child = toForm.children().last();

            child.find('[data-id="shop_room_id"] input').val(select.data('id'));
            child.find('[data-id="shop_room_id"] span').text(select.parent().find('[data-id="shop_room_id"]').text());

            var dateFrom = select.data('date');
            child.find('[data-id="date_from"]').val(dateFrom);

            var dateTo = select.data('date');
            var dTo = new Date(dateTo.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1'));
            dTo.setDate(dTo.getDate() + 1);
            dTo = $.datepicker.formatDate('dd.mm.yy', dTo);
            child.find('[data-id="date_to"]').val(dTo);

            child.find('[data-id="price"]').val(select.data('price')).attr('value', select.data('price'));
            child.find('[data-id="human"]').text(select.data('human'));

            var el1 = child.find('[data-id="human_extra"]');
            el1.data('price', select.data('price_extra'));

            sHtml = '';
            for(var i=0; i <= $(this).data('human_extra'); i++){
                sHtml = sHtml + '<option value="'+i+'" data-id="'+i+'">'+i+'</option>';
            }
            el1.html(sHtml);

            el1.val('0');
            child.find('[data-id="price_extra"]').text(select.data('price_extra'));

            var el2 = child.find('[data-id="child_extra"]');
            el2.data('price', select.data('price_child'));

            sHtml = '';
            for(var i=0; i <= $(this).data('human_extra'); i++){
                sHtml = sHtml + '<option value="'+i+'" data-id="'+i+'">'+i+'</option>';
            }
            el2.html(sHtml);

            el2.val('0');
            child.find('[data-id="price_child"]').text(select.data('price_child'));

            var date1 = new Date(dateFrom.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1'));
            var date2 = new Date(dateTo.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1'));
            var timeDiff = Math.abs(date2.getTime() - date1.getTime()) + 1;
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

            child.find('[data-id="diff"]').html(diffDays);

            var amount = diffDays * Number(select.data('price'));
            var el3 = child.find('[data-id="amount"]');
            el3.text(amount);
            el3.data('amount', amount);
            child.find('[data-id="amount-input"]').val(amount).attr('value', amount);

            __InitRoomList(child);
            el1.trigger('change');

            index++;
        });

        form.data('index', Number(index));

        $(modal.data('parent-modal')).modal('show');
        modal.modal('hide');

        __initTr();

        groupItems();
    }

    function calcAmount() {
        var human = 0;
        $('#room-free-record [data-id="rooms"] tr').each(function (i) {
            var td = $(this).find('td.active:last');
            if(td.length == 1) {
                human = human + Number(td.data('human'));
            }
        });

        var amount = 0;
        $('#room-free-record [data-id="rooms"] td.active').each(function (i) {
            amount = amount + Number($(this).data('price'));
        });

        $('#room-free-record [data-id="total"]').html('Общая сумма: <b style="font-size: 20px">'+Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(amount).replace(',', '.')+' тг</b>');
    }

    function __InitRoomFree() {
        $('#room-free-record [data-id="rooms"] td.free[data-action="select"]').click(function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            }else{
                $(this).addClass('active');
            }
            calcAmount();
            return true;
        });

        calcAmount();
    }
    $(document).ready(function () {
        __initTable();
        __InitRoomFree();

        $('#room-free-find input').change(function () {
            var data = {};
            var arr = $('#room-free-find').find('input[name], select[name]');
            arr.each(function (i) {
                data[$(this).attr('name')] = $(this).val();
            });

            jQuery.ajax({
                url: '/pyramid/shoproom/free',
                data: data,
                type: "POST",
                success: function (data) {
                    $('#list-free-rooms').html(data);
                    __InitRoomFree();

                    calcAmount();
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });

        $('#room-free-record input[type="datetime"]').datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y',
            timepicker:false,
        });
    });
</script>