<tr>
    <td>
        <a href="<?php echo Func::getFullURL($siteData, '/shopstorage/balance_statistics', array(), array('shop_storage_id' => $data->values['shop_storage_id'], 'shop_branch_id' => Request_RequestParams::getParamInt('shop_branch_id'))); ?>">
            <?php echo $data->getElementValue('shop_storage_id'); ?>
        </a>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity'], TRUE, 3, FALSE); ?></td>
</tr>
