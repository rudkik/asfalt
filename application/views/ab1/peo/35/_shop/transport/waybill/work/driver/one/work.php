<tr <?php if($data->additionDatas['is_free']){?>class="tr-red" <?php }?>>
    <td class="text-right">#index#</td>
    <?php if ($data->additionDatas['is_repair']){ ?>
        <td>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/edit', ['id' => 'id'], ['is_show' => true], $data->values); ?>">
                <?php if(empty($data->values['number'])){echo 'Ремонт'; }else{ echo $data->values['number']; } ?>
            </a>
        </td>
        <td>
            <?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>
        </td>
        <td>
            <?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['from_at']); ?>
        </td>
        <td>
            <?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['to_at']); ?>
        </td>
        <td>
            <?php echo $data->getElementValue('shop_transport_id');?>
        </td>
        <td>
            <?php echo $data->getElementValue('shop_transport_id', 'number');?>
        </td>
        <td>Ремонт</td>
    <?php }else{ ?>
        <td>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/edit', ['id' => 'shop_transport_waybill_id'], ['is_show' => true], $data->values); ?>">
                <?php echo $data->getElementValue('shop_transport_waybill_id', 'number');?>
            </a>
        </td>
        <td>
            <?php echo Helpers_DateTime::getDateFormatRus($data->getElementValue('shop_transport_waybill_id', 'date')); ?>
        </td>
        <td>
            <?php echo Helpers_DateTime::getDateTimeFormatRus($data->getElementValue('shop_transport_waybill_id', 'from_at')); ?>
        </td>
        <td>
            <?php echo Helpers_DateTime::getDateTimeFormatRus($data->getElementValue('shop_transport_waybill_id', 'to_at')); ?>
        </td>
        <td>
            <?php echo $data->getElementValue('shop_transport_id');?>
        </td>
        <td>
            <?php echo $data->getElementValue('shop_transport_id', 'number');?>
        </td>
        <td>
            <?php echo $data->getElementValue('transport_work_id'); ?>
        </td>
    <?php } ?>
    <?php foreach ($data->additionDatas['works'] as $child) { ?>
        <td class="text-right">
            <?php echo Arr::path($data->additionDatas['work_quantities'], $child->id, ''); ?>
        </td>
    <?php } ?>
</tr>