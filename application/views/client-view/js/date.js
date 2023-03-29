/**
 * Показываем календарь у текстового поля и ставим формат даты
 * Стили и скрипты
 */
/*
<link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.css"/>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
 */
/**
 * Обязательно type="datetime" у тектового поля
 * date-type="date" - d.m.Y (по умолчанию)
 * date-type="datetime" - d.m.Y H:i
 */
$('input[type="datetime"][date-type="date"], input[type="datetime"]:not([date-type])').datetimepicker({
    dayOfWeekStart : 1,
    lang:'ru',
    format:	'd.m.Y',
    timepicker:false,
}).inputmask({
    mask: "99.99.9999"
}).attr('autocomplete','off');

$('input[type="datetime"][date-type="datetime"]').datetimepicker({
    dayOfWeekStart : 1,
    lang:'ru',
    format:	'd.m.Y H:i',
    timepicker:true,
}).inputmask({
    mask: "99.99.9999 99:99"
}).attr('autocomplete','off');