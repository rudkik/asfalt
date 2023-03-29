<tr class="table__row">
    <td class="table__col"><?php echo $data->values['id'];?></td>
    <td class="table__col"><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']);?></td>
    <td class="table__col"><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_send']);?></td>
    <td class="table__col"><?php echo floatval($data->values['weight']);?></td>
    <td class="table__col"><?php echo floatval($data->values['amount']);?>$</td>
</tr>