<tr>
    <td>
        <?php if($data->values['esf_type_id'] == Model_Magazine_ESFType::ESF_TYPE_AWAITING_RECEIPT){?>
            Временная
        <?php }elseif($data->values['esf_type_id'] == Model_Magazine_ESFType::ESF_TYPE_RETURN){?>
            Возвратная
        <?php }else{?>
            Основная
        <?php }?>
    </td>
    <td><?php echo $data->values['number']; ?></td>
    <td>
        <?php echo $data->values['number_esf']; ?>
        <?php if($data->values['esf_type_id'] == Model_Magazine_ESFType::ESF_TYPE_RETURN){ ?>
            <br>Основная №<a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit', array(), array('id' => $data->values['shop_invoice_id']), $data->values); ?>"><?php echo $data->getElementValue('shop_invoice_id', 'number');?></a>
        <?php }?>
    </td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['esf_date']); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
