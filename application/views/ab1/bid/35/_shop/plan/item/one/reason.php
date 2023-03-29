<tr <?php if($data->values['quantity'] > $data->values['quantity_fact']){echo 'class="tr-red"';}?>>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity_fact'], TRUE, 3, FALSE); ?></td>
    <td>
        <select data-action="set-plan-reason-type" data-href="<?php echo Func::getFullURL($siteData, '/shopplanitem/save', array(), array('id' => $data->id));?>" name="plan_reason_type_id" class="form-control select2" style="width: 100%;">
            <?php $tmp = $data->values['plan_reason_type_id']; ?>
            <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
            <?php
            $tmp = 'data-id="'.$tmp.'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::plan-reason-type/list/list']));
            ?>
        </select>
    </td>
</tr>
