<?php
$amount = $data->values['balance'];
?>
<tr>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['bin']; ?></td>
    <?php if($amount > 0){?>
        <td class="text-right"><?php echo Func::getNumberStr($amount, TRUE, 2, FALSE); ?></td>
        <td></td>
    <?php }else{?>
        <td></td>
        <td class="text-right"><?php echo Func::getNumberStr($amount * -1, TRUE, 2, FALSE); ?></td>
    <?php }?>
</tr>
