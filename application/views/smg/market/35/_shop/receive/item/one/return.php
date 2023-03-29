<tr>
    <td class="text-right">#index#</td>
    <td><?php echo $data->values['name']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], true); ?></td>
</tr>