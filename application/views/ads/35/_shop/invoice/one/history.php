<tr>
    <td><?php echo $data->values['id']; ?></td>
    <td><?php echo $data->values['shop_parcel_id']; ?></td>
    <td><?php echo Func::getNumberStr($data->values['amount']); ?></td>
    <td>
        <?php
        if($data->values['is_paid'] == 1){
            echo 'Оплачено <br>'.Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date_paid']);
        }else{
            echo 'Неоплачено';
        } ?>
    </td>
</tr>