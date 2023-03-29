<tr>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_write_off_type_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <td>
        <?php if($data->values['is_fiscal_check'] < 1){ ?>
            <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                <?php if($siteData->operation->getIsAdmin() || date('Y-m-d') == Helpers_DateTime::getDateFormatPHP($data->values['created_at'])){ ?>
                    <li><a href="<?php echo Func::getFullURL($siteData, '/shoprealization/edit', array('id' => 'id', 'is_special' => 'is_special'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
                <?php }else{?>
                    <li><a href="<?php echo Func::getFullURL($siteData, '/shoprealization/edit', array('id' => 'id', 'is_special' => 'is_special'), array('is_show' => TRUE), $data->values); ?>" class="link-blue"><i class="fa fa-list-alt margin-r-5"></i> Просмотр</a></li>
                <?php }?>
                <?php if($data->values['shop_write_off_type_id'] == Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS){ ?>
                    <li><a data-acton="fiscal-print" href="<?php echo Func::getFullURL($siteData, '/shoprealization/print', array('id' => 'id'), array('token_not' => true), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-reply margin-r-5"></i> Печать чека</a></li>
                <?php }?>
                <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprealization/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprealization/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            </ul>
        <?php }else{?>
            <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoprealization/edit', array('id' => 'id', 'is_special' => 'is_special'), array('is_show' => TRUE), $data->values); ?>" class="link-blue"><i class="fa fa-list-alt margin-r-5"></i> Просмотр</a></li>
            </ul>
        <?php }?>
    </td>
</tr>
