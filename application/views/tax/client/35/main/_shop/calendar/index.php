<div id="calendar-record" class="modal-edit">
    <div class="modal-dialog" style="margin: 0px; max-width: 100%">
        <div class="modal-content" style="border: none">
            <form class="has-validation-callback" action="/tax/shop/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="calendar"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/fullcalendar/fullcalendar.print.css" media="print">
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/fullcalendar/lib/moment.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/fullcalendar/fullcalendar.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/plugins/fullcalendar/locale/ru.js"></script>
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
                    url: '/tax/shopcalendar/json?_fields[]=id',
                    error: function() {
                    }
                },
                editable: false,
                droppable: false,
                timeFormat:'HH:mm',
                displayEventEnd: true,
            });
        });
    </script>
    <style>
        .fc-event.ks-day-off {
            background: #ec644b;
            color: #fff !important;
            padding: 50px 0px;
            text-align: center;
            border-color: #ec644b;
        }
        .fc-event.ks-holiday {
            background: #3a529b;
            color: #fff !important;
            padding: 50px 0px;
            text-align: center;
            border-color: #3a529b;
        }
        .fc-title{
            white-space: normal;
        }
    </style>
</div>
