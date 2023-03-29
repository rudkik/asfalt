<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_driver_id.name', ''); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', ''); ?></td>
    <td <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['tarra']).' т'; ?></td>
    <td <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['quantity'], true, 3).' '.Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.unit', ''); ?></td>
    <td <?php
    if ($data->values['shop_client_attorney_id'] > 0){
        $attorney = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_attorney_id', '');
        if($attorney['balance'] < 0){
            echo 'class=text-red';
        }
    }else{
        $client = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id', '');
        if($client['balance_cache'] < 0){
            echo 'class=text-red';
        }
    }
    ?>><?php echo Func::getPriceStr($siteData->currency, $data->values['amount'], TRUE, FALSE); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_turn_id.name', ''); ?></td>
</tr>
