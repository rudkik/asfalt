<tr>
    <td><a href="<?php
        $arr = array(
            'shop_write_off_type_id' => $data->values['shop_write_off_type_id'],
            'is_all_branch' => Request_RequestParams::getParamBoolean('is_all_branch'),
        );
        $arr['shop_branch_id'] = $siteData->shopID;
        echo Func::getFullURL($siteData, '/shoprealization/index', array(), $arr, array(), true);
        ?>"><?php echo $data->getElementValue('shop_write_off_type_id'); ?></a></td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['1'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['1'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['2'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['2'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['3'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['3'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['4'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['4'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['5'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['5'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['6'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['6'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['7'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['7'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['8'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['8'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['9'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['9'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['10'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['10'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['11'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['11'], TRUE, 2, FALSE); ?>
    </td>
    <td style="text-align: right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity']['12'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount']['12'], TRUE, 2, FALSE); ?>
    </td>
</tr>
