<tr>
    <td>
        <a href="<?php
        $arr = array(
            'shop_transport_company_id-is_own' => $data->getElementValue('shop_transport_company_id', 'is_own', 2),
            'is_all_branch' => Request_RequestParams::getParamBoolean('is_all_branch'),
        );
        $arr['shop_branch_id'] = $siteData->shopID;
        echo Func::getFullURL($siteData, '/shoptransportcompany/statistics', array(), $arr, array(), true);
        ?>">
            <?php
            switch ($data->getElementValue('shop_transport_company_id', 'is_own', 2)){
                case 1:
                    echo 'Собственные';
                    break;
                case 0:
                    echo 'Наемные';
                    break;
                default:
                    echo 'Не задано';
            }
            ?>
        </a>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount_day'], TRUE, 2, FALSE); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount_yesterday'], TRUE, 2, FALSE); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount_week'], TRUE, 2, FALSE); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount_month'], TRUE, 2, FALSE); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount_month_previous'], TRUE, 2, FALSE); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?>
        <br><?php echo Func::getNumberStr($data->additionDatas['amount_year'], TRUE, 2, FALSE); ?>
    </td>
</tr>
