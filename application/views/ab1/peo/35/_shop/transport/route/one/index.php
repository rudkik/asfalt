<?php
/** @var MyArray $data */
/** @var SitePageData $siteData */
//print_r($data);die;
?>
<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shoptransportroute/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_branch_from_id', 'name', $data->getElementValue('shop_daughter_from_id')); ?></td>
    <td><?php echo $data->getElementValue('shop_branch_to_id', 'name', $data->getElementValue('shop_daughter_to_id')); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['distance'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td><a data-action="calc-transport-route" href="#" data-id="<?php echo $data->values['id']; ?>" class="link-green">Пересчатать расценку</a></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoptransportroute/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportroute/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoptransportroute/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
