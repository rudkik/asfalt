<tr>
    <td colspan="9">
        <h4 style="margin: 0px"><b>№<?php echo $data->values['number']; ?> от <?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']); ?></b></h4>
    </td>
</tr>
<?php foreach ($data->childs as $child){ ?>
<tr>
    <td>
        <?php
        $name = '';
        if($child->values['product_shop_branch_id'] > 0){
            $name = $child->getElementValue('product_shop_branch_id'). ', ';
        }
        if($child->values['shop_product_rubric_id'] > 0){
            $name = $child->getElementValue('shop_product_rubric_id'). ', ';
        }
        if($child->values['shop_product_id'] > 0){
            $name = $child->getElementValue('shop_product_id'). ', ';
        }
        echo mb_substr($name, 0, -2);
        ?>
    </td>
    <td>
        <?php echo Func::getNumberStr($child->values['quantity'], FALSE); ?>
    </td>
    <td>
        <?php echo Func::getNumberStr($child->values['price'], FALSE); ?>
    </td>
    <td>
        <?php echo Func::getNumberStr($child->values['amount'], TRUE); ?>
    </td>
    <td>
        <?php echo Func::getNumberStr($child->values['discount'], FALSE); ?>
    </td>
    <td class="text-center">
        <?php if ($child->values['is_fixed_price'] == 1) { echo 'да'; }else{echo 'нет';} ?>
    </td>
    <td>
        <?php echo Helpers_DateTime::getDateFormatRus($child->values['from_at']); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($child->values['block_amount'], TRUE, 2, FALSE); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($child->values['balance_amount'], TRUE, 2, FALSE); ?>
    </td>
</tr>
<?php } ?>