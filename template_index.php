<!-- Тип Данных one/index  -->
<?php
/** @var MyArray $data */
/** @var SitePageData $siteData */
//print_r($data);die;
?>
<!-- Дата и время  -->
<td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
<td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_from']); ?></td>
<!-- Дата  -->
<td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?></td>
<!-- Время  -->
<td><?php echo Helpers_DateTime::getTimeFormatRus($data->values['date_to']); ?></td>
<!-- ГОд  -->
<td><?php echo Helpers_DateTime::getYear($data->values['date_to']);?></td>
<!-- Текст  -->
<td><?php echo htmlspecialchars($data->values['name_site'], ENT_QUOTES);?></td>
<!-- Текст  -->
<td><?php echo $data->getElementValue('shop_material_id'); ?></td>
<!-- Текст  _id with fieldName  -->
<td><?php echo $data->getElementValue('shop_client_id', 'old_id'); ?></td>
<!-- Вещественные (дробные) числа  -->
<td><?php echo Func::getNumberStr($data->values['moisture'], TRUE, 3, FALSE); ?></td>
<!-- Целые числа  -->
<td><?php echo Func::getNumberStr($data->values['moisture'], TRUE, 0); ?></td>
<!-- Перевести Boolean - Да/Нет  -->
<td><?php if($data->values['is_client'] == 1){echo 'да';}else{echo 'нет';} ?></td>



