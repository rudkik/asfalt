<?php if (Arr::path($additionDatas, 'is_min_amount', '') === TRUE){ ?>
<?php
$rand = rand(0, 10000);
$panelID = 'free-room-type-'.$rand;
?>
<div id="<?php echo $panelID; ?>" class="row" data-block="box-rooms">
    <div class="col-sm-12">
        <?php if (FALSE && (Arr::path($additionDatas, 'is_min_amount', '') === TRUE)){ ?>
            <h3 class="text-left">Вариант 1 "Бюджетный"</h3>
        <?php }elseif (FALSE && (Arr::path($additionDatas, 'is_min_room', '') === TRUE)){ ?>
            <h3 class="text-left">Вариант 2 "Альтернативный"</h3>
        <?php } ?>
        <form action="<?php echo $siteData->urlBasicLanguage;?>/hotel/room/add_bill_room_type" method="get" style="margin: 30px 0px 40px;">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-rooms table-column-5">
                        <thead>
                        <tr>
                            <th data-id="column-room">Номер</th>
                            <th style="width: 200px;">Койко-места</th>
                            <th style="width: 200px;">Доп. места, взрослые</th>
                            <th style="width: 200px;">Доп. места, дети</th>
                            <th style="width: 240px;">Сумма</th>
                            <th style="width: 30px;"></th>
                        </tr>
                        </thead>
                        <tbody id="to-<?php echo $panelID; ?>">
                        <?php
                        foreach ($data['view::View_Hotel_Shop_Room_Type\free']->childs as $key => $value){
                            echo str_replace('#index#', $key, $value->str);
                        }
                        ?>
                        <tr data-tr="total" class="tr-total total-all" style="background-color: rgb(0, 51, 142); color: #fff !important;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>Итого:</b></td>
                            <td style="background-color: rgb(0, 51, 142) !important;" colspan="2" data-id="total" data-amount="<?php echo $additionDatas['amount']; ?>"><?php
                                $diffDays = Helpers_DateTime::diffDays($additionDatas['date_to'], $additionDatas['date_from']) + 1;
                                echo '<b>'.Func::getPriceStr($siteData->currency, $additionDatas['amount']). '</b> за '.Func::getCountElementStrRus($diffDays, 'дней','день', 'дня');
                                ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row box-button-rooms">
                <div class="col-sm-6 text-left">
                    <button class="btn btn-flat btn-blue" data-action="edit-room-type" type="button" onclick="editTable<?php echo $rand; ?>()">Изменить вариант</button>
                    <button style="display: none" class="btn btn-flat btn-blue" data-action="add-room-type" type="button" onclick="addTr<?php echo $rand; ?>('#from-<?php echo $panelID; ?>', '#to-<?php echo $panelID; ?>')">Добавить номер</button>
                </div>
                <div class="col-sm-6 text-right">
                    <input name="url_error" value="<?php echo $siteData->urlBasicLanguage;?>/free/room/types?date_from=<?php echo $additionDatas['date_from']; ?>&date_to=<?php echo $additionDatas['date_to']; ?>&adults=<?php echo Request_RequestParams::getParamInt('adults'); ?>&childs=<?php echo Request_RequestParams::getParamInt('childs'); ?>" style="display: none">
                    <input name="url" value="<?php echo $siteData->urlBasicLanguage;?>/bill/client" style="display: none">
                    <input name="shop_id" value="3576" style="display: none;" >
                    <input name="date_from" value="<?php echo $additionDatas['date_from']; ?>" style="display: none;" >
                    <input name="date_to" value="<?php echo date('Y-m-d', strtotime($additionDatas['date_to'].' + 1 day')); ?>" style="display: none;" >
                    <button id="submit<?php echo $rand; ?>" class="btn btn-flat btn-blue-un" type="button">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('#submit<?php echo $rand; ?>').click(function () {
        $('#<?php echo $panelID; ?> select').removeAttr('disabled');
        $('#<?php echo $panelID; ?> [data-action="edit-room-type"]').css('display', 'none');
        $('#<?php echo $panelID; ?> [data-action="add-room-type"], #<?php echo $panelID; ?> [data-action="tr-delete-free"]').css('display', '');
        $('#<?php echo $panelID; ?> [data-id="column-room"]').html('Выберите номер');

        $('#<?php echo $panelID; ?> form').submit();
    });

    function __initTrRoomType<?php echo $rand; ?>(element) {
        element.find('.select2').select2();

        element.find('[data-action="free-room-type"]').change(function () {
            var parent = $(this).parents('tr');

            var elAdults = parent.find('[data-name="adults"]');
            var adults = elAdults.val();

            var elChilds = parent.find('[data-name="childs"]');
            var childs = elChilds.val();

            var shopRoomTypeID = parent.find('[data-name="shop_room_type_id"]').val();
            var option = parent.find('[data-name="shop_room_type_id"] option[data-id="'+shopRoomTypeID+'"]');
            parent.find('[data-id="human"]').html(option.data('human'));

            var humanExtra = Number(option.data('human_extra'));

            if (humanExtra - childs < adults) {
                adults = 0;
            }
            if (humanExtra - adults < childs) {
                childs = 0;
            }

            var s = '';
            for(var i=0; i <= humanExtra - childs; i++){
                s = s+'<option>'+i+'</option>';
            }

            elAdults.html(s);

            var elTitle = elAdults.parent().find('.select2-selection__rendered[title]');
            if (humanExtra - childs >= adults) {
                elAdults.val(adults);
                elTitle.attr('title', adults);
                elTitle.text(adults);
            }else{
                elAdults.val(0);
                elTitle.attr('title', 0);
                elTitle.text(0);
            }

            if (humanExtra - childs == 0){
                elAdults.attr('disabled', '');
            }else{
                elAdults.removeAttr('disabled');
            }

            s = '';
            for(var i=0; i <= humanExtra - adults; i++){
                s = s+'<option>'+i+'</option>';
            }
            elChilds.html(s);

            var elTitle = elChilds.parent().find('.select2-selection__rendered[title]');
            if (humanExtra - adults >= childs) {
                elChilds.val(childs);
                elTitle.attr('title', childs);
                elTitle.text(childs);
            }else{
                elChilds.val(0);
                elTitle.attr('title', 0);
                elTitle.text(0);
            }

            if (humanExtra - adults == 0){
                elChilds.attr('disabled', '');
            }else{
                elChilds.removeAttr('disabled');
            }

            jQuery.ajax({
                url: '/hotel/room/get_amount',
                data: ({
                    shop_room_type_id: (shopRoomTypeID),
                    adults: (adults),
                    childs: (childs),
                    date_from: ('<?php echo $additionDatas['date_from']; ?>'),
                    date_to: ('<?php echo date('d.m.Y', strtotime($additionDatas['date_to']) + 24 * 60 * 60); ?>'),
                }),
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    var el = parent.find('[data-id="amount"]');
                    el.data('amount', obj.amount);
                    el.find('b').html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(obj.amount)+' тг');

                    var amount = 0;
                    parent.parent().find('[data-id="amount"]').each(function(index, value){
                        amount = amount + Number($(this).data('amount'));
                    });

                    var el = $('#<?php echo $panelID; ?> [data-id="total"]');
                    el.find('b').html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(amount)+' тг');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });

        element.find('[data-action="tr-delete-free"]').click(function () {
            var table = $(this).parents('table');

            var tr = $(this).parents('tr');
            tr.remove();

            var amount = 0;
            table.find('[data-id="amount"]').each(function(index, value){
                amount = amount + Number($(this).data('amount'));
            });
            var el = $('#<?php echo $panelID; ?> [data-id="total"]');
            el.find('b').html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(amount)+' тг');
        });
    }

    function addTr<?php echo $rand; ?>(from, to) {
        var form = $(from);
        var index = form.data('index');
        form.data('index', Number(index) + 1);

        var tmp = $.trim(form.html().replace('<!--', '').replace('-->', '').replace(/#index#/g, '_' + index));

        var element = $(tmp);
        element.appendTo(to);
        $(to).find('[data-tr="total"]').insertAfter(element);

        __initTrRoomType<?php echo $rand; ?>(element);
        element.find('[data-name="shop_room_type_id"]').each(function(){
            $(this).trigger('change');
            return false;
        });

        return false;
    }

    function editTable<?php echo $rand; ?>() {
        $('#<?php echo $panelID; ?>').parent().children('[data-block="box-rooms"]').each(function(){
            if ($(this).attr('id') != '<?php echo $panelID; ?>'){
                $(this).css('display', 'none');
            }
        });

        $('#<?php echo $panelID; ?> select').removeAttr('disabled');
        $('#<?php echo $panelID; ?> [data-action="edit-room-type"]').css('display', 'none');
        $('#<?php echo $panelID; ?> [data-action="add-room-type"], #<?php echo $panelID; ?> [data-action="tr-delete-free"]').css('display', '');
        $('#<?php echo $panelID; ?> [data-id="column-room"]').html('Выберите номер');
        $('#<?php echo $panelID; ?> [data-name="shop_room_type_id"]').trigger('change');

        return false;
    }

    __initTrRoomType<?php echo $rand; ?>($('#<?php echo $panelID; ?>'));
</script>
<div id="from-<?php echo $panelID; ?>" data-index="1" style="display: none;">
    <!--
    <tr data-index="#index#">
        <td>
            <select data-name="shop_room_type_id" data-action="free-room-type" name="room_types[#index#][shop_room_type_id]" class="form-control select2" style="width: 100%;">
                <?php echo $siteData->globalDatas['view::View_Hotel_Shop_Room_Types\list']; ?>
            </select>
        <td data-id="human">0</td>
        <td>
            <select data-name="adults" data-action="free-room-type" name="room_types[#index#][adults]" class="form-control select2" style="width: 100%;">
                <option>0</option>
            </select>
        </td>
        <td>
            <select data-name="childs" data-action="free-room-type" name="room_types[#index#][childs]" class="form-control select2" style="width: 100%;">
                <option>0</option>
            </select>
        </td>
        <td data-id="amount" data-amount="0">
            <?php
            $diffDays = Helpers_DateTime::diffDays($additionDatas['date_to'], $additionDatas['date_from']);
            $amount = 0;
            echo '<b>'.Func::getPriceStr($siteData->currency, $amount). '</b> за '.Func::getCountElementStrRus($diffDays, 'дней','день', 'дня');
            ?>
        </td>
        <td>
            <button type="button" class="close" aria-label="Close" data-action="tr-delete-free">
                <span aria-hidden="true" class="fa fa-close"></span> удалить
            </button>
        </td>
    </tr>
    -->
</div>
<?php } ?>
