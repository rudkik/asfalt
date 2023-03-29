<tr class="table__row">
    <td class="table__col"><?php echo $data->values['tracker'];?></td>
    <td class="table__col"><?php echo Func::getNumberStr($data->values['price'], TRUE);?>$</td>
    <td class="table__col"><?php echo $data->values['text'];?></td>
</tr>