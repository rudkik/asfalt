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
    <td><?php echo $data->values['shop_client_name']; ?></td>
    <td><?php if($data->values['is_cash']){echo 'Наличный';}else{echo 'Безналичный';} ?></td>
    <td><?php echo $data->values['shop_client_attorney_number']; ?></td>
    <td><?php if($data->values['shop_client_contract_id'] > 0){echo $data->values['shop_client_contract_number'];}else{echo 'без договора';} ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['count']); ?></td>
    <td>
        <ul class="list-inline tr-button">
            <li><a data-name="edit" target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopactservice/virtual_show', array('date_from' => 'date_from', 'date_to' => 'date_to',),
                    array(
                        'date_from' => $dateFrom,
                        'date_to' => $dateTo,
                        'shop_client_id' => $data->values['shop_client_id'],
                        'shop_client_contract_id' => $data->values['shop_client_contract_id'],
                        'shop_client_attorney_id' => $data->values['shop_client_attorney_id'],
                        'shop_client_name' => $data->values['shop_client_name'],
                        'is_cash' => $data->values['is_cash'],
                        ),
                    $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Подробно</a></li>
        </ul>
    </td>
</tr>
