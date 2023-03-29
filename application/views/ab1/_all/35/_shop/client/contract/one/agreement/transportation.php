<tr>
    <td colspan="5">
        <h4 style="margin: 0px"><b>№<?php echo $data->values['number']; ?> от <?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']); ?></b></h4>
    </td>
</tr>
<?php foreach ($data->childs as $child){ ?>
<tr>
    <td>
        <?php echo $child->values['name']; ?>
    </td>
    <td>
        <?php echo $child->values['unit']; ?>
    </td>
    <td>
        <?php echo Func::getNumberStr($child->values['quantity'], true, 2, false); ?>
    </td>
    <td>
        <?php echo Func::getNumberStr($child->values['price'], true, 2, false); ?>
    </td>
    <td>
        <?php echo Func::getNumberStr($child->values['amount'], true, 2, false); ?>
    </td>
</tr>
<?php } ?>