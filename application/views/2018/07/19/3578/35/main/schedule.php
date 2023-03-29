<header class="header-blog-slider"></header>
<header class="header-schedule">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Расписание</h1>
            </div>
            <div class="col-md-4 box-a">
                Часовой пояс: MT + 06.00
            </div>
        </div>
        <div id="calendar"></div>
    </div>
</header>
<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/plugins/fullcalendar/fullcalendar.print.css" media="print">
<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css">
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/plugins/fullcalendar/lib/moment.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/plugins/fullcalendar/locale/ru.js"></script>
<!-- Page specific script -->
<script>
    $(function () {
        $('#calendar').fullCalendar({
            lang: 'ru',
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            monthNamesSort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
            header: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            buttonText: {
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day'
            },
            eventLimit: true,
            events: {
                url: 'schedule/events',
                error: function() {
                }
            },
            editable: false,
            droppable: false,
            timeFormat:'HH:mm',
            displayEventEnd: true
        });
    });
</script>