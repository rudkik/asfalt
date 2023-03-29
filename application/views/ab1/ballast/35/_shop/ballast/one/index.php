<tr>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date']); ?></td>
    <td><?php echo $data->getElementValue('shop_ballast_car_id', 'name'); ?></td>
    <td><?php echo $data->getElementValue('shop_ballast_driver_id', 'name'); ?></td>
    <td><?php echo $data->getElementValue('shop_ballast_distance_id', 'name'); ?></td>
    <td><?php echo $data->getElementValue('shop_work_shift_id', 'name'); ?></td>
    <td>
        <?php
        if ($data->values['take_shop_ballast_crusher_id'] > 0){
            echo $data->getElementValue('take_shop_ballast_crusher_id');
        }else{
            echo 'Карьер';
        }
        ?>
    </td>
    <td>
        <?php
        if ($data->values['shop_ballast_crusher_id'] > 0){
            echo $data->getElementValue('shop_ballast_crusher_id', 'name');
        }elseif($data->values['is_storage']){
            echo 'Складирование';
        }
        ?>
    </td>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <td style="font-size: 14px;" class="text-right">
            <?php if($data->values['shop_transport_waybill_id'] > 0){?>
                <a target="_blank" href="<?php echo $siteData->urlBasic . '/atc/shoptransportwaybill/edit?id=' . $data->values['shop_transport_waybill_id']; ?>"><?php echo $data->getElementValue('shop_transport_waybill_id', 'number'); ?></a>
            <?php } ?>
        </td>
    <?php } ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopballast/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopballast/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopballast/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
