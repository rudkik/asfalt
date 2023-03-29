<header class="header-map-img">
    <div class="container">
        <h2>Book a room on our interactive map Kara Dala</h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <img id="map-zone" class="img-responsive img-map" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/map_en.png">
    </div>
</header>

<div id="reserv-hotel" class="modal fade modal-reserve" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="box-close">
            <button class="close" type="button" data-dismiss="modal"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/modal-close1.png" class="img-responsive"></button>
        </div>
        <div class="modal-content">
            <form data-get-url="<?php echo $siteData->urlBasicLanguage;?>/rooms/hotel"  enctype="multipart/form-data" action="<?php echo $siteData->urlBasicLanguage;?>/free/rooms" method="get">
                <div class="modal-header">
                <h3>Choose a Room</h3>
                <div class="row box-reserve">
                    <div class="m-center" style="margin-top: 10px;">
                        <div class="col-sm-6 box-date">
                            <label>Check in Date</label>
                            <div class="input-group">
                                <input data-action="modal-date" name="date_from" class="form-control" required type="datetime" value="<?php echo Request_RequestParams::getParamStr('date_from'); ?>">
                                <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 box-date">
                            <label>Check out Date</label>
                            <div class="input-group">
                                <input data-action="modal-date" name="date_to" class="form-control" required type="datetime" value="<?php echo Request_RequestParams::getParamStr('date_to'); ?>">
                                <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="modal-body">
                    <div class="modal-fields">
                        <h4>Main Building</h4>
                        <div class="row" data-id="building-rooms">
                            <?php echo $siteData->globalDatas['view::View_Hotel_Shop_Rooms\hotel']; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-blue">Book a Room</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="reserv-townhouse" class="modal fade modal-reserve" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px;">
        <div class="box-close">
            <button class="close" type="button" data-dismiss="modal"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/modal-close1.png" class="img-responsive"></button>
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-fields">
                    <h3>Choose a Room</h3>
                    <form data-get-url="<?php echo $siteData->urlBasicLanguage;?>/rooms/townhouse"  enctype="multipart/form-data" action="<?php echo $siteData->urlBasic;?>/free/rooms" method="get">
                        <div class="row box-reserve">
                            <div class="m-center">
                                <div class="col-sm-6 box-date">
                                    <label>Check in Date</label>
                                    <div class="input-group">
                                        <input data-action="modal-date" name="date_from" class="form-control" required type="datetime" value="<?php echo Request_RequestParams::getParamStr('date_from'); ?>">
                                        <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 box-date">
                                    <label>Check out Date</label>
                                    <div class="input-group">
                                        <input data-action="modal-date" name="date_to" class="form-control" required type="datetime" value="<?php echo Request_RequestParams::getParamStr('date_to'); ?>">
                                        <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4>Townhouse</h4>
                        <div class="row" data-id="building-rooms">
                            <?php echo $siteData->globalDatas['view::View_Hotel_Shop_Rooms\townhouse']; ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-blue">Book a Room</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="reserv-cottage" class="modal fade modal-reserve" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px;">
        <div class="box-close">
            <button class="close" type="button" data-dismiss="modal"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/modal-close1.png" class="img-responsive"></button>
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-fields">
                    <h3>Choose a Room</h3>
                    <form data-get-url="<?php echo $siteData->urlBasicLanguage;?>/rooms/cottage" enctype="multipart/form-data" action="<?php echo $siteData->urlBasic;?>/free/rooms" method="get">
                        <div class="row box-reserve">
                            <div class="m-center">
                                <div class="col-sm-6 box-date">
                                    <label>Check in Date</label>
                                    <div class="input-group">
                                        <input data-action="modal-date" name="date_from" class="form-control" required type="datetime" required  value="<?php echo Request_RequestParams::getParamStr('date_from'); ?>">
                                        <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 box-date">
                                    <label>Check out Date</label>
                                    <div class="input-group">
                                        <input data-action="modal-date" name="date_to" class="form-control" required type="datetime" required  value="<?php echo Request_RequestParams::getParamStr('date_to'); ?>">
                                        <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4>Cottage Apartment</h4>
                        <div class="row" data-id="building-rooms">
                            <?php echo $siteData->globalDatas['view::View_Hotel_Shop_Rooms\cottage']; ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-blue">Book a Room</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function __initReservRoom(element) {
        element.find('.room:not(.busy):not(.no-active)').click(function(e) {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).find('input[data-id="shop_rooms"]').removeAttr('checked');
            } else {
                $(this).addClass('active');
                $(this).find('input[data-id="shop_rooms"]').attr('checked', '');
            }
        });
    }


    jQuery( document ).ready(function( $ ) {
        var isShowTooltip = false;
        $("#map-zone").tooltip({
            trigger: 'manual',
            title: 'Click and Book'
        }).click(function(e) {
            var offset = $(this).offset();
            var relativeX = (e.pageX - offset.left);
            var relativeY = (e.pageY - offset.top);
            var width = $(this).width();

            // область гостиницa
            var x1 = 179/(1317/width);
            var x2 = 503/(1317/width);
            var y1 = 171/(1317/width);
            var y2 = 267/(1317/width);

            if ((x1 <= relativeX) && (x2 >= relativeX) && (y1 <= relativeY) && (y2 >= relativeY)){
                $('#reserv-hotel').modal('show');
                return true;
            }

            // область таунхауса
            var x1 = 179/(1317/width);
            var x2 = 428/(1317/width);
            var y1 = 659/(1317/width);
            var y2 = 728/(1317/width);

            if ((x1 <= relativeX) && (x2 >= relativeX) && (y1 <= relativeY) && (y2 >= relativeY)){
                $('#reserv-townhouse').modal('show');
                return true;
            }

            // область коттеджа
            var x1 = 765/(1317/width);
            var x2 = 889/(1317/width);
            var y1 = 913/(1317/width);
            var y2 = 967/(1317/width);

            if ((x1 <= relativeX) && (x2 >= relativeX) && (y1 <= relativeY) && (y2 >= relativeY)){
                $('#reserv-cottage').modal('show');
                return true;
            }
        }).mousemove(function(e) {
            var offset = $(this).offset();
            var relativeX = (e.pageX - offset.left);
            var relativeY = (e.pageY - offset.top);
            var width = $(this).width();

            // область гостиницa
            var x1 = 179/(1317/width);
            var x2 = 503/(1317/width);
            var y1 = 171/(1317/width);
            var y2 = 267/(1317/width);

            if ((x1 <= relativeX) && (x2 >= relativeX) && (y1 <= relativeY) && (y2 >= relativeY)){
                $(this).css('cursor', 'pointer');

                if(!isShowTooltip) {
                    $(this).tooltip('show');
                }
                var el = $('#'+$(this).attr('aria-describedby'));
                el.css('top', offset.top + y1 - el.height() - 10).css('left', offset.left + ((x2-x1) / 2) - (el.width() / 2)  + x1);
                return true;
            }

            // область таунхауса
            var x1 = 179/(1317/width);
            var x2 = 428/(1317/width);
            var y1 = 659/(1317/width);
            var y2 = 728/(1317/width);

            if ((x1 <= relativeX) && (x2 >= relativeX) && (y1 <= relativeY) && (y2 >= relativeY)){
                $(this).css('cursor', 'pointer');

                if(!isShowTooltip) {
                    $(this).tooltip('show');
                }
                var el = $('#'+$(this).attr('aria-describedby'));
                el.css('top', offset.top + y1 - el.height() - 10).css('left', offset.left + ((x2-x1) / 2) - (el.width() / 2)  + x1);
                return true;
            }

            // область коттеджа
            var x1 = 765/(1317/width);
            var x2 = 889/(1317/width);
            var y1 = 913/(1317/width);
            var y2 = 967/(1317/width);

            if ((x1 <= relativeX) && (x2 >= relativeX) && (y1 <= relativeY) && (y2 >= relativeY)){
                $(this).css('cursor', 'pointer');

                if(!isShowTooltip) {
                    $(this).tooltip('show');
                }
                var el = $('#'+$(this).attr('aria-describedby'));
                el.css('top', offset.top + y1 - el.height() - 10).css('left', offset.left + ((x2-x1) / 2) - (el.width() / 2)  + x1);
                return true;
            }

            $(this).tooltip('hide');
            $(this).css('cursor', 'default');

        }).on('hidden.bs.tooltip', function () {
            isShowTooltip = false;
        }).on('show.bs.tooltip', function () {
            isShowTooltip = true;
        });

        $('input[data-action="modal-date"]').change(function(e) {
            var parent = $(this).parents('.modal-body');
            var date_from = parent.find('input[name="date_from"]').val();
            var date_to = parent.find('input[name="date_to"]').val();
            var url = parent.data('get-url');
            jQuery.ajax({
                url: url,
                data: ({
                    date_from: (date_from),
                    date_to: (date_to),
                }),
                type: "POST",
                success: function (data) {
                    parent.find('[data-id="building-rooms"]').html(data);

                    __initReservRoom(parent);
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });

    });

    $('input[data-action="modal-date"]').change(function(e) {
        var parent = $(this).parents('form');
        var date_from = parent.find('input[name="date_from"]').val();
        var date_to = parent.find('input[name="date_to"]').val();
        var url = parent.data('get-url');
        jQuery.ajax({
            url: url,
            data: ({
                date_from: (date_from),
                date_to: (date_to),
            }),
            type: "POST",
            success: function (data) {
                parent.find('[data-id="building-rooms"]').html(data);

                __initReservRoom(parent);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });

    __initReservRoom($('html .modal-reserve '));
</script>