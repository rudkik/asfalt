<?php

$periodFrom = strtotime(date('Y-m-d'));
if(!empty($data->values['date_from'])) {
    $tmp = strtotime($data->values['date_from']);
    if ($periodFrom < $tmp) {
        $periodFrom = $tmp;
    }
}

$periodTo = strtotime('+14 days');
if(!empty($data->values['date_to'])) {
    $tmp = strtotime($data->values['date_to']);
    if ($periodTo > $tmp) {
        $periodTo = $tmp;
    }
}

$result = array();
switch ($data->values['calendar_event_type_id']){
    case Model_CalendarEventType::CALENDAR_EVENT_WEEK_DAYS:
        $weekDays = Arr::path($data->values['time_options'], 'week_days', array());
        if(is_array($weekDays)) {
            while ($periodFrom <= $periodTo) {
                if (array_search(strftime('%u', $periodFrom), $weekDays) !== FALSE) {
                    $result[] = array(
                        'title' => $data->values['name'],
                        'url' => $siteData->urlBasic . '/event?id=' . $data->values['id'],
                        'start' => Helpers_DateTime::getDateTimeISO8601(date('Y-m-d', $periodFrom) . ' ' . $data->values['time_from']),
                        'end' => Helpers_DateTime::getDateTimeISO8601(date('Y-m-d', $periodFrom) . $data->values['time_to']),
                    );
                    break;
                }
                $periodFrom = $periodFrom + 60 * 60 * 24;
            }
        }
        break;
    case Model_CalendarEventType::CALENDAR_EVENT_DAILY:
        while($periodFrom <= $periodTo){
            $result[] = array(
                'title' => $data->values['name'],
                'url' => $siteData->urlBasic.'/event?id='.$data->values['id'],
                'start' => Helpers_DateTime::getDateTimeISO8601(date('Y-m-d', $periodFrom).' '.$data->values['time_from']),
                'end' => Helpers_DateTime::getDateTimeISO8601(date('Y-m-d', $periodFrom).$data->values['time_to']),
            );
            $periodFrom = $periodFrom + 60 * 60 * 24;
            break;
        }
        break;
    case Model_CalendarEventType::CALENDAR_EVENT_MONTH:
        $monthDays = Arr::path($data->values['time_options'], 'month_days', array());
        if(is_array($month)) {
            while ($periodFrom <= $periodTo) {
                if (array_search(floatval(strftime('%d', $periodFrom)), $monthDays) !== FALSE) {
                    $result[] = array(
                        'title' => $data->values['name'],
                        'url' => $siteData->urlBasic . '/event?id=' . $data->values['id'],
                        'start' => Helpers_DateTime::getDateTimeISO8601(date('Y-m-d', $periodFrom) . ' ' . $data->values['time_from']),
                        'end' => Helpers_DateTime::getDateTimeISO8601(date('Y-m-d', $periodFrom) . $data->values['time_to']),
                    );
                }
                $periodFrom = $periodFrom + 60 * 60 * 24;
                break;
            }
        }
        break;
    default:
        $result[] = array(
            'title' => $data->values['name'],
            'url' => $siteData->urlBasic.'/event?id='.$data->values['id'],
            'start' => Helpers_DateTime::getDateTimeISO8601(str_replace(' 00:00:00', '', $data->values['date_from']).' '.$data->values['time_from']),
            'end' => Helpers_DateTime::getDateTimeISO8601(str_replace(' 00:00:00', '', $data->values['date_to']).' '.$data->values['time_to']),
        );
}
?>

<?php foreach ($result as $child){ ?>
<div class="row box-event">
    <div class="date">
        <?php echo Helpers_DateTime::getDateFormatRus($child['start']). ' - '.Helpers_DateTime::getDateFormatRus($child['end']); ?>
    </div>
    <div class="name">
        <a href="<?php echo $siteData->urlBasic;?>/event?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a>
    </div>
    <div class="text">
        <div class="pull-left box-text-article">
            <?php echo $data->values['text']; ?>
        </div>
        <div class="btn-hide">
            <img class="plus" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/plus.png">
            <img class="minus" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/minus.png">
        </div>
    </div>
</div>
<?php } ?>
