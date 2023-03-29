<tr>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->additionDatas['date']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <?php if($data->values['shop_invoice_id'] > 0){?>
        <td class="text-right">0</td>
        <td class="text-right">0</td>
    <?php }else{?>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <?php }?>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/new', array(), array('date_from' => $data->additionDatas['date'], 'date_to' => $data->additionDatas['date'])); ?>" class="btn bg-blue btn-flat">
            <i class="fa fa-fw fa-plus"></i>
            Накладная
        </a>
    </td>
</tr>
