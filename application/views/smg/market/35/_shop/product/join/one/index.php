<?php $source = Arr::path($data->values['options'], 'source', array()); ?>
<tr>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_source_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_operation_id'); ?></td>
    <td class="text-right"><a class="text-blue" target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopproduct/index', array('shop_product_join_id' => 'id'), array(), $data->values); ?>"><?php echo Func::getNumberStr($data->values['quantity'], true); ?></a></td>
</tr>
