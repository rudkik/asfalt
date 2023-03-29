<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['from_at']).'-'.Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['to_at']); ?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['amount'], TRUE, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopconsumable/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopconsumable/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopconsumable/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
