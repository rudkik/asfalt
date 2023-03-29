<?php

$periodFrom = strtotime(Request_RequestParams::getParamDateTime('start'));
if(!empty($data->values['date_from'])) {
    $tmp = strtotime($data->values['date_from']);
    if ($periodFrom < $tmp) {
        $periodFrom = $tmp;
    }
}

$periodTo = strtotime(Request_RequestParams::getParamDateTime('end'));
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
echo substr(json_encode($result), 1, -1);

?>