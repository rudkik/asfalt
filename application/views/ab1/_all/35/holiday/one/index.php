<div class="col-md-3">
    <div id="calendar-<?php echo $data->id;?>" style="border: #605ca8 solid 1px; margin-bottom: 30px"></div>
</div>
<script>
    var days<?php echo $data->id;?>;

    function runFreeDay<?php echo $data->id;?>(year){
        days<?php echo $data->id;?> = new Map([
            <?php foreach ($data->values['holidays'] as $day => $name){?>
            [year + '<?php echo Helpers_DateTime::getDateStr($day, $data->id, '') ?>', 2],
            <?php } ?>
        ]);

        for(var i = 1; i <= getLastDayMonthEndStr(<?php echo $data->id;?>, year); i++){
            var date = new Date(year + '-' + <?php echo $data->id;?> + '-' + i);
            var tmp = getWeekDay(date);

            date = formatDate(date);
            if((tmp == 6 || tmp == 7) && days<?php echo $data->id;?>.get(date) != 2){
                days<?php echo $data->id;?>.set(date, 1);
            }
        }
    }

    function _initCalendar<?php echo $data->id;?>(year) {
        runFreeDay<?php echo $data->id;?>(year);
        __initCalendar<?php echo $data->id;?>(year);
    }

    function __initCalendar<?php echo $data->id;?>(year) {
        $('#calendar-<?php echo $data->id;?>').fullCalendar({
            lang: 'ru',
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            monthNamesSort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
            header: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            defaultDate: new Date(year + '-<?php echo $data->id;?>-01'),
            eventLimit: true,
            editable: true,
            droppable: false,
            timeFormat: 'HH:mm',
            displayEventEnd: true,
            dayClick: function (date, jsEvent, view) {
                if (date.format('M') != <?php echo $data->id;?>) {
                    return true;
                }

                date = date.format();
                var day = days<?php echo $data->id;?>.get(date);
                if (day == 1) {
                    $(this).css("background-color", "rgb(252,1,43, 0.7)");
                    days<?php echo $data->id;?>.set(date, 2);
                } else {
                    if (day == 2) {
                        $(this).css("background-color", "#fff");
                        days<?php echo $data->id;?>.set(date, 0);
                    } else {
                        $(this).css("background-color", "rgba(58,159,255, 0.7)");
                        days<?php echo $data->id;?>.set(date, 1);
                    }
                }
            },
            dayRender: function (date, cell) {
                var day = days<?php echo $data->id;?>.get(date.format());
                if (day == 1) {
                    cell.css("background-color", "rgba(58,159,255, 0.7)");
                } else {
                    if (day == 2) {
                        cell.css("background-color", "rgb(252,1,43, 0.7)");
                    }
                }
            }
        });
    }

    <?php if($siteData->action == 'new') { ?>
        _initCalendar<?php echo $data->id;?>(<?php echo $data->values['year'];?>);
    <?php }else{ ?>
        days<?php echo $data->id;?> = new Map([
            <?php foreach ($data->values['holidays'] as $day => $name){?>
            ['<?php echo Helpers_DateTime::getDateStr($day, $data->id, $data->values['year']) ?>', 2],
            <?php } ?>

            <?php foreach ($data->values['frees'] as $day){?>
            ['<?php echo $day; ?>', 1],
            <?php } ?>
        ]);

        __initCalendar<?php echo $data->id;?>(<?php echo $data->values['year'];?>);
    <?php } ?>
</script>