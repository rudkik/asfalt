<?php
/** @var MyArray $data */
/** @var SitePageData $siteData */
//print_r($data);die;
?>
<tr>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo $data->getElementValue('shop_transport_mark_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td><?php echo $data->getElementValue('shop_worker_responsible_id'); ?></td>
    <td><?php echo $data->values['text']; ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <?php if ($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_CHIEF){ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportsamplefuel/edit', array('id' => 'id'), array('is_show' => true), $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
            <?php } else{ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportsamplefuel/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportsamplefuel/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportsamplefuel/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
