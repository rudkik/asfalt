<?php
$rand = rand(0, 10000);
$panelID = 'free-room-'.$rand;
?>
<div class="row">
    <div class="col-sm-12" id="<?php echo $panelID; ?>">
        <h3 class="text-left">Room <span style="color: rgb(0, 51, 142);"><?php echo Helpers_DateTime::getDateFormatRus($additionDatas['date_from']) .' - '. Helpers_DateTime::getDateFormatRus($additionDatas['date_to']); ?></span></h3>
        <form action="<?php echo $siteData->urlBasic;?>/hotel/room/add_bill_room?data_language_id=<?php echo $siteData->dataLanguageID; ?>" method="get" style="margin: 30px 0px 40px;">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-rooms table-column-5">
                        <thead>
                        <tr>
                            <th data-id="column-room">Room</th>
                            <th style="width: 200px;">Persons</th>
                            <th style="width: 200px;">Extra Bed, Adults</th>
                            <th style="width: 200px;">Extra Bed, Children</th>
                            <th style="width: 240px;">Amount, KZT</th>
                            <th style="width: 30px;"></th>
                        </tr>
                        </thead>
                        <tbody id="to-<?php echo $panelID; ?>">
                        <?php
                        foreach ($data['view::View_Hotel_Shop_Room\free']->childs as $key => $value){
                            echo str_replace('#index#', $key, $value->str);
                        }
                        ?>
                        <tr data-tr="total" class="tr-total total-all-en" style="background-color: rgb(0, 51, 142); color: #fff !important;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>Total:</b></td>
                            <td colspan="2" data-id="total" data-amount="<?php echo $additionDatas['amount']; ?>"><?php
                                $diffDays = Helpers_DateTime::diffDays($additionDatas['date_to'], $additionDatas['date_from']) + 1;
                                echo '<b>'.Func::getPriceStr($siteData->currency, $additionDatas['amount']). '</b> '.$diffDays.' Per Night';
                                ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row box-button-rooms">
                <div class="col-sm-6 text-left">
                    <button class="btn btn-flat btn-blue" data-action="edit-room" type="button" onclick="editTable<?php echo $rand; ?>()">Change Booking</button>
                    <button style="display: none" class="btn btn-flat btn-blue" data-action="add-room" type="button" onclick="addTr<?php echo $rand; ?>('#from-<?php echo $panelID; ?>', '#to-<?php echo $panelID; ?>')">Add a Room</button>
                </div>
                <div class="col-sm-6 text-right">
                    <input name="url_error" value="<?php echo $siteData->urlBasicLanguage;?>/free/rooms<?php echo URL::query(); ?>" style="display: none">
                    <input name="url" value="<?php echo $siteData->urlBasicLanguage;?>/bill/client" style="display: none">
                    <input name="shop_id" value="3576" style="display: none;" >
                    <input name="date_from" value="<?php echo $additionDatas['date_from']; ?>" style="display: none;" >
                    <input name="date_to" value="<?php echo date('Y-m-d', strtotime($additionDatas['date_to'].' + 1 day')); ?>" style="display: none;" >
                    <button id="submit<?php echo $rand; ?>" class="btn btn-flat btn-blue-un" type="button">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('#submit<?php echo $rand; ?>').click(function () {
        $('#<?php echo $panelID; ?> select').removeAttr('disabled');
        $('#<?php echo $panelID; ?> [data-action="edit-room"]').css('display', 'none');
        $('#<?php echo $panelID; ?> [data-action="add-room"], #<?php echo $panelID; ?> [data-action="tr-delete-free"]').css('display', '');
        $('#<?php echo $panelID; ?> [data-id="column-room"]').html('Choose a Room');

        $('#<?php echo $panelID; ?> form').submit();
    });

    function __initTrRoom<?php echo $rand; ?>(element) {
        element.find('.select2').select2();

        element.find('[data-action="free-room"]').change(function () {
            var parent = $(this).parents('tr');

            var elAdults = parent.find('[data-name="adults"]');
            var adults = elAdults.val();

            var elChilds = parent.find('[data-name="childs"]');
            var childs = elChilds.val();

            var shopRoomID = parent.find('[data-name="shop_room_id"]').val();
            var option = parent.find('[data-name="shop_room_id"] option[data-id="'+shopRoomID+'"]');
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
                    shop_room_id: (shopRoomID),
                    adults: (adults),
                    childs: (childs),
                    date_from: ('<?php echo $additionDatas['date_from']; ?>'),
                    date_to: ('<?php echo $additionDatas['date_to']; ?>'),
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

        __initTrRoom<?php echo $rand; ?>(element);
        element.find('[data-name="shop_room_id"]').each(function(){
            $(this).trigger('change');
            return false;
        });

        return false;
    }

    function editTable<?php echo $rand; ?>() {
        $('#<?php echo $panelID; ?> select').removeAttr('disabled');
        $('#<?php echo $panelID; ?> [data-action="edit-room"]').css('display', 'none');
        $('#<?php echo $panelID; ?> [data-action="add-room"], #<?php echo $panelID; ?> [data-action="tr-delete-free"]').css('display', '');
        $('#<?php echo $panelID; ?> [data-id="column-room"]').html('Choose a Room');
        $('#<?php echo $panelID; ?> [data-name="shop_room_id"]').trigger('change');

        return false;
    }

    __initTrRoom<?php echo $rand; ?>($('#<?php echo $panelID; ?>'));
</script>
<div id="from-<?php echo $panelID; ?>" data-index="1" style="display: none;">
    <!--
    <tr>
        <td>
            <select data-name="shop_room_id" data-action="free-room" name="rooms[#index#][shop_room_id]" class="form-control select2" style="width: 100%;">
                <?php echo $siteData->globalDatas['view::View_Hotel_Shop_Rooms\list']; ?>
            </select>
        <td data-id="human">0</td>
        <td>
            <select data-name="adults" data-action="free-room" name="rooms[#index#][adults]" class="form-control select2" style="width: 100%;">
                <option>0</option>
            </select>
        </td>
        <td>
            <select data-name="childs" data-action="free-room" name="rooms[#index#][childs]" class="form-control select2" style="width: 100%;">
                <option>0</option>
            </select>
        </td>
        <td data-id="amount" data-amount="0">
            <?php
            $diffDays = Helpers_DateTime::diffDays($additionDatas['date_to'], $additionDatas['date_from']);
            $amount = 0;
            echo '<b>'.Func::getPriceStr($siteData->currency, $amount). '</b> '.$diffDays. 'Per Night';
            ?>
        </td>
        <td>
            <button type="button" class="close" aria-label="Close" data-action="tr-delete-free">
                <span aria-hidden="true" class="fa fa-close"></span> delete
            </button>
        </td>
    </tr>
    -->
</div>