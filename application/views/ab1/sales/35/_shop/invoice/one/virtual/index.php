<?php
$dateFrom = Request_RequestParams::getParamDateTime('date_from');
if($dateFrom === NULL){
    $dateFrom = date('Y-m-d').' 06:00:00';
}
$dateTo = Request_RequestParams::getParamDateTime('date_to');
if($dateTo === NULL){
    $dateTo = date('Y-m-d',strtotime('+1 day')).' 06:00:00';
}
?>
<tr data-action="db-click-edit">
    <td>
        <span class="margin-r-5"><?php echo $data->values['shop_client_name']; ?></span>
        <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopclient/edit', array(),
            array(
                'id' => $data->values['shop_client_id'],
            )); ?>" class="link-blue"><i class="fa fa-eye"></i></a>
    </td>
    <td><?php if($data->values['shop_client_attorney_id'] > 0){echo 'безналичный';}else{echo 'наличный';} ?></td>
    <td>
        <span class="margin-r-5"><?php echo $data->values['shop_client_attorney_number']; ?></span>
        <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/index', array(),
            array(
                'shop_client_id' => $data->values['shop_client_id'],
            )); ?>" class="link-blue"><i class="fa fa-eye"></i></a>
    </td>
    <td>
        <span class="margin-r-5"><?php if($data->values['shop_client_contract_id'] > 0){echo $data->values['shop_client_contract_number'];}else{echo 'без договора';} ?></span>
        <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopclientcontract/index', array(),
            array(
                'shop_client_id' => $data->values['shop_client_id'],
            )); ?>" class="link-blue"><i class="fa fa-eye"></i></a>
    </td>
    <td><?php if($data->values['is_delivery'] == 1){echo 'с доставкой';}else{echo 'без доставки';} ?></td>
    <td><?php echo $data->values['product_type_name']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['total'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['count']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['block_amount'], TRUE, 2, FALSE); ?></td>
    <td class="text-right">
        <span class="margin-r-5"><?php echo Func::getNumberStr(Arr::path($data->additionDatas, 'cash', ''), TRUE, 2, FALSE); ?></span>
        <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shoppayment/index', array(),
            array(
                'shop_client_id' => $data->values['shop_client_id'],
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
            )); ?>" class="link-blue"><i class="fa fa-eye"></i></a>
    </td>
    <td>
        <ul class="list-inline tr-button">
            <li><a data-name="edit" target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopinvoice/virtual_show', array(),
                    array(
                        'date_from' => $dateFrom,
                        'date_to' => $dateTo,
                        'shop_client_id' => $data->values['shop_client_id'],
                        'shop_client_name' => $data->values['shop_client_name'],
                        'shop_client_attorney_id' => $data->values['shop_client_attorney_id'],
                        'shop_client_contract_id' => $data->values['shop_client_contract_id'],
                        'is_delivery' => $data->values['is_delivery'],
                        'product_type_id' => $data->values['product_type_id'],
                    ),
                    $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Подробно</a></li>
        </ul>
    </td>
    <td>
        <ul class="list-inline tr-button">
            <li><a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopinvoice/virtual_index', array(),
                    array(
                        'date_from' => date('Y-m-d', strtotime('-1 day')).' 06:00:00',
                        'date_to' => date('Y-m-d').' 06:00:00',
                        'shop_client_id' => $data->values['shop_client_id'],
                        'shop_client_name' => $data->values['shop_client_name'],
                    ),
                    $data->values); ?>" class="text-purple"><i class="fa fa-calendar-check-o margin-r-5"></i> <?php echo date('d.m.Y', strtotime('-1 day')); ?></a></li>
            <li><a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopinvoice/virtual_index', array(),
                    array(
                        'date_from' => date('Y-m-d', strtotime('-2 day')).' 06:00:00',
                        'date_to' => date('Y-m-d', strtotime('-1 day')).' 06:00:00',
                        'shop_client_id' => $data->values['shop_client_id'],
                        'shop_client_name' => $data->values['shop_client_name'],
                    ),
                    $data->values); ?>" class="text-orange"><i class="fa fa-calendar-check-o margin-r-5"></i> <?php echo date('d.m.Y', strtotime('-2 day')); ?></a></li>
            <li><a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopinvoice/virtual_index', array(),
                    array(
                        'date_from' => date('Y-m-d', strtotime('-3 day')).' 06:00:00',
                        'date_to' => date('Y-m-d', strtotime('-2 day')).' 06:00:00',
                        'shop_client_id' => $data->values['shop_client_id'],
                        'shop_client_name' => $data->values['shop_client_name'],
                    ),
                    $data->values); ?>" class="link-blue"><i class="fa fa-calendar-check-o margin-r-5"></i> <?php echo date('d.m.Y', strtotime('-3 day')); ?></a></li>
        </ul>
    </td>
</tr>
