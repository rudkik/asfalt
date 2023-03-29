<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/fullcalendar/fullcalendar.print.css" media="print">
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/css/style.css">
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/fullcalendar/lib/moment.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/fullcalendar/locale/ru.js"></script>
<style>
    .fc-scroller.fc-day-grid-container{
        height: auto !important;
    }
    .fc-left, .fc-right{
        display: none;
    }
</style>
<script>
    function getLastDayMonthEndStr(month, year){
        var day = 0;
        switch (month){
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                day = 31;
                break;
            case 2:
                if (year % 4 == 0){
                    day = 29;
                }else{
                    day = 28;
                }
                break;
            default:
                day = 30;
        }

        return day;
    }

    function getWeekDay(date){
        var days = ['7', '1', '2', '3', '4', '5', '6'];
        var day = date.getDay();

        return days[day];
    }

    function formatDate(date) {
        var month = '' + (date.getMonth() + 1),
            day = '' + date.getDate(),
            year = date.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
</script>
<div class="row">
    <div class="col-md-12" style="margin: 20px 0px 10px">
        <div class="pull-left"><label>Выходной день</label></div>
        <div class="pull-left" style="width: 20px;height: 20px;background-color: rgba(58, 159, 255, 0.7);margin: 0px 10px;"></div>
        <div class="pull-left"><label>Праздничный день</label></div>
        <div class="pull-left" style="width: 20px;height: 20px;background-color: rgb(252,1,43, 0.7);margin: 0px 10px;"></div>

        <div class="pull-right">
            <b>Примечание:</b> один клик выходной, второй клик праздник
        </div>
    </div>

    <?php
    foreach ($data['view::holiday/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
</div>
<script>
    function getCalendarVal(){
        var result = {};

        days1.forEach(function(value, key, map){
            result[key] = value;
        });
        days2.forEach(function(value, key, map){
            result[key] = value;
        });
        days3.forEach(function(value, key, map){
            result[key] = value;
        });
        days4.forEach(function(value, key, map){
            result[key] = value;
        });
        days5.forEach(function(value, key, map){
            result[key] = value;
        });
        days6.forEach(function(value, key, map){
            result[key] = value;
        });
        days7.forEach(function(value, key, map){
            result[key] = value;
        });
        days8.forEach(function(value, key, map){
            result[key] = value;
        });
        days9.forEach(function(value, key, map){
            result[key] = value;
        });
        days10.forEach(function(value, key, map){
            result[key] = value;
        });
        days11.forEach(function(value, key, map){
            result[key] = value;
        });
        days12.forEach(function(value, key, map){
            result[key] = value;
        });

        return result;
    }
    $('[name="year"]').on('change', function(){
        var year = Number($(this).val());
        if(year > 2000 && year < 2223){
            $('#calendar-1').fullCalendar('destroy');
            $('#calendar-2').fullCalendar('destroy');
            $('#calendar-3').fullCalendar('destroy');
            $('#calendar-4').fullCalendar('destroy');
            $('#calendar-5').fullCalendar('destroy');
            $('#calendar-6').fullCalendar('destroy');
            $('#calendar-7').fullCalendar('destroy');
            $('#calendar-8').fullCalendar('destroy');
            $('#calendar-9').fullCalendar('destroy');
            $('#calendar-10').fullCalendar('destroy');
            $('#calendar-11').fullCalendar('destroy');
            $('#calendar-12').fullCalendar('destroy');

            _initCalendar1(year);
            _initCalendar2(year);
            _initCalendar3(year);
            _initCalendar4(year);
            _initCalendar5(year);
            _initCalendar6(year);
            _initCalendar7(year);
            _initCalendar8(year);
            _initCalendar9(year);
            _initCalendar10(year);
            _initCalendar11(year);
            _initCalendar12(year);
        }
    });
</script>
