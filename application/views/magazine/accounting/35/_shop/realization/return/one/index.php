<tr>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td data-id="fiscal"><?php echo $data->values['fiscal_check']; ?></td>
    <td class="text-right"><?php echo $data->values['quantity']; ?></td>
    <td class="text-right"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount'], TRUE, FALSE); ?></td>
    <td>
        <?php if($data->values['is_fiscal_check'] < 1){ ?>
            <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                <?php if($siteData->operation->getIsAdmin() || date('Y-m-d') == Helpers_DateTime::getDateFormatPHP($data->values['created_at'])){ ?>
                    <li><a href="<?php echo Func::getFullURL($siteData, '/shoprealizationreturn/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
                <?php }else{?>
                    <li><a href="<?php echo Func::getFullURL($siteData, '/shoprealizationreturn/edit', array('id' => 'id'), array('is_show' => TRUE), $data->values); ?>" class="link-blue"><i class="fa fa-list-alt margin-r-5"></i> Просмотр</a></li>
                <?php }?>
                <li><a data-acton="fiscal-print" href="<?php echo Func::getFullURL($siteData, '/shoprealizationreturn/print', array('id' => 'id'), array('token_not' => true), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-reply margin-r-5"></i> Печать чека</a></li>
                <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprealizationreturn/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoprealizationreturn/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            </ul>
        <?php }else{?>
            <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                <li><a href="<?php echo Func::getFullURL($siteData, '/shoprealizationreturn/edit', array('id' => 'id'), array('is_show' => TRUE), $data->values); ?>" class="link-blue"><i class="fa fa-list-alt margin-r-5"></i> Просмотр</a></li>
            </ul>
        <?php }?>
    </td>
</tr>
