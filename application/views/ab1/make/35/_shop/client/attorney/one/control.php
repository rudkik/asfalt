<tr>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['from_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['to_at']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['balance'], TRUE, 2, FALSE); ?></td>
    <td class="text-right">
        <?php
        $balance = $data->getElementValue('shop_client_id', 'balance', 0);
        $balanceCash = $data->getElementValue('shop_client_id', 'balance_cache', 0);
        $balance -= $balanceCash;
        echo Func::getNumberStr($balance, TRUE, 2, FALSE);
        ?>
    </td>
    <td class="text-right"><?php $tmp = $balance - $data->values['balance']; if($tmp != 0){echo Func::getNumberStr($tmp, TRUE, 2, FALSE);}?></td>
    <td class="text-right"><?php echo Func::getNumberStr($balanceCash, TRUE, 2, FALSE); ?></td>
    <td>
        <?php echo $data->getElementValue('create_user_id'); ?>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopclientattorney/edit', array('id' => 'id'), array('is_show' => 1), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр доверенности</a></li>
        </ul>
    </td>
</tr>
