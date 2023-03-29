<?php
/** @var MyArray $data */
/** @var SitePageData $siteData */
//print_r($data);die;
?>
<tr>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['from_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['to_at']); ?></td>
    <td class="text-right"><?php echo $data->values['hours']; ?></td>
    <td><?php echo $data->getElementValue('shop_transport_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_transport_driver_id'); ?></td>
    <td><?php echo $data->getElementValue('create_user_id'); ?> <br> <?php echo $data->getElementValue('update_user_id'); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <?php if(Helpers_DateTime::diffHours(Helpers_DateTime::getCurrentDateTimePHP(), $data->values['to_at']) > 24 * 7 && ! $siteData->operation->getIsAdmin()){ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/edit', array('id' => 'id'), array('is_show' => true), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
            <?php }elseif ($siteData->operation->getOperationTypeID() == Model_OperationType::ATC_CHIEF){ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/edit', array('id' => 'id'), array('is_show' => true), $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
            <?php } else{ ?>
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
                <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportrepair/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php }?>
        </ul>
    </td>
</tr>
