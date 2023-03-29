<tr data-action="db-click-edit">
    <td>
        <?php echo $data->getElementValue('shop_boxcar_client_id'); ?>
        <?php if($data->values['shop_client_id'] > 0){ ?>
            <br><span class="text-red"><?php echo $data->getElementValue('shop_client_id'); ?></span>
        <?php } ?>
    </td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3); ?></td>
    <td><?php echo $data->getElementValue('shop_boxcar_departure_station_id'); ?></td>
    <td <?php if(!empty($data->values['date_departure']) && strtotime($data->values['date_shipment']) > strtotime($data->values['date_departure'])){ ?> class="text-red" <?php } ?>><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_shipment']); ?></td>
    <td <?php if(!empty($data->values['date_departure']) && strtotime($data->values['date_shipment']) > strtotime($data->values['date_departure'])){ ?> class="text-red" <?php } ?>><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_departure']); ?></td>
    <td><?php
        $i = 0;
        foreach ($data->values['boxcars'] as $child){
            $i++;
            echo $child . ' ';

            if($i == 2){
                echo '<br>';
                $i = 0;
            }
        }
        ?>
    </td>
    <td><?php echo Func::trimTextNew($data->values['text'], 200); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/edit', array('id' => 'id'), array('is_show' => 1), $data->values); ?>" class="link-blue"><i class="fa fa-desktop margin-r-5"></i> Просмотр</a></li>
            <li><a data-name="edit" href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a data-action="clone-auto" href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/clone', array('id' => 'id'), array(), $data->values); ?>" class="link-black"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
