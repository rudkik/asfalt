<div class="ks-nav-body">
    <div class="row">
        <div class="col-md-5">
            <div id="calendar"></div>
        </div>
        <div class="col-md-7">
            <table class="table table-hover table-db table-tr-line">
                <thead style="background-color: hsla(0,0%,100%,.3);">
                <tr>
                    <th style="width: 100%;">Бухгалтера на <label data-id="day" class="day-current"></label></th>
                    <th style="width: 74px">Кол-во</th>
                </tr>
                </thead>
                <tbody id="bookkeepers">
                </tbody>
            </table>
        </div>
    </div>
    <div class="card" style="margin-top: 20px">
        <div class="card-block">
            <table class="table table-hover table-db table-tr-line">
                <thead style="background-color: hsla(0,0%,100%,.3);">
                <tr>
                    <th style="width: 33%;">Задачи <label data-id="day" class="day-current"></label></th>
                    <th style="width: 33%;">Клиент</label></th>
                    <th style="width: 33%;">Бухгалтер</th>
                    <th style="width: 158px">Срок действия от</th>
                    <th style="width: 158px;">Срок действия до</th>
                    <th style="min-width: 144px;"></th>
                </tr>
                </thead>
                <tbody id="tasks">
                </tbody>
            </table>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/nur/plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/nur/plugins/fullcalendar/fullcalendar.print.css" media="print">
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/nur/css/style.css">
<script src="<?php echo $siteData->urlBasic; ?>/css/nur/plugins/fullcalendar/lib/moment.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/nur/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/nur/plugins/fullcalendar/locale/ru.js"></script>
<!-- Page specific script -->
<script>
    function getTasks(date) {
        jQuery.ajax({
            url: '/nur-bookkeeping/shoptaskcurrent/json_calendar_day',
            data: ({
                'date': (date),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                $('[data-id="day"]').text(date);
                var tasks = $('#tasks');
                tasks.empty();
                jQuery.each(obj.tasks, function (index, value) {
                    var task = '<tr>\n' +
                        '<td>'+value.shop_task_name+'</td>\n' +
                        '<td>'+value.shop_name+'</td>\n' +
                        '<td>'+value.shop_bookkeeper_name+'</td>\n' +
                        '<td>'+moment(value.date_from).format('DD.MM.YYYY')+'</td>\n' +
                        '<td>'+moment(value.date_to).format('DD.MM.YYYY')+'</td>\n';

                    if(value.status == 1){
                        task = task +
                            '<td><a href="/nur-bookkeeping/shoptaskcurrent/finish?id='+value.shop_task_id+'&shop_branch_id='+value.shop_id+'"><span class="ks-icon fa fa-pencil-square-o"></span> Завершить работу</a></td>\n' +
                            '</tr>';
                    }else{
                        task = task +
                            '<td><a href="/nur-bookkeeping/shoptaskcurrent/add?id='+value.shop_task_id+'&shop_branch_id='+value.shop_id+'"><span class="ks-icon fa fa-pencil-square-o"></span> Взять в работу</a></td>\n' +
                            '</tr>';
                    }

                    tasks.append(task);
                });

                var bookkeepers = $('#bookkeepers');
                bookkeepers.empty();
                jQuery.each(obj.bookkeepers, function (index, value) {
                    var bookkeeper = '<tr>\n' +
                        '<td>'+value.shop_bookkeeper_name+'</td>\n' +
                        '<td>'+value.count+'</td>\n' +
                        '</tr>';

                    bookkeepers.append(bookkeeper);
                });
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }
    $(function () {
        $('#calendar').fullCalendar({
            lang: 'ru',
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            monthNamesSort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
            header: {
                left: 'prev',
                center: 'title',
                right: 'month , basicWeek, next'
            },
            buttonText: {
                today: 'сегодня',
                month: 'месяц',
                week: 'неделя',
                day: 'день'
            },
            eventLimit: true,
            events: {
                url: '/nur-bookkeeping/shoptaskcurrent/json_calendar',
                error: function() {
                }
            },
            editable: false,
            droppable: false,
            timeFormat:'HH:mm',
            displayEventEnd: true,
            eventAfterRender: function (event, element) {
                console.log(event); // Debug
                if(event.status == 2) {
                    element.css({'background-color': '#f95372'});
                }else{
                    if(event.status == 1) {
                        element.css({'background-color': '#1abc9c'});
                    }else{
                        element.css({'background-color': '#f39c12'});
                    }
                }
            },
            dayClick: function(date) {
                $('#calendar .selected-day').removeClass('selected-day');
                $('#calendar [data-date="'+moment(date).format('YYYY-MM-DD')+'"]').addClass('selected-day');

                var date = moment(date).format('DD.MM.YYYY');
                getTasks(date);
            },
            eventLimitClick: function(info) {
                $('#calendar .selected-day').removeClass('selected-day');
                $('#calendar [data-date="'+moment(info.date).format('YYYY-MM-DD')+'"]').addClass('selected-day');

                var date = moment(info.date).format('DD.MM.YYYY');
                getTasks(date);
                return false;
            },
            eventLimit: 1
        });
    });
</script>