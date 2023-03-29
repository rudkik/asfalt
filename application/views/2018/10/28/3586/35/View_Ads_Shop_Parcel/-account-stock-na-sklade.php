<tr class="table__row">
    <td class="table__col">№<?php echo $data->values['id'];?></td>
    <td class="table__col"><?php echo floatval($data->values['weight']);?> кг - <?php echo Func::getNumberStr($data->values['amount'], TRUE);?>$</td>
    <td class="table__col"><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_send']);?></td>
    <!-- <td class="table__col">Республика Казахстан, г. Алматы, Самал-2, дом 11</td> -->
	<td class="table__col"><?php echo $data->values['tracker'];?></td>
</tr>