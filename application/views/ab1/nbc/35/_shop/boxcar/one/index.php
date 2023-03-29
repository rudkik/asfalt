<tr data-action="db-click-edit">
    <td class="text-right">#index#</td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_arrival']); ?></td>
    <td>
        <?php if(empty($data->values['date_arrival'])){ ?>
            Неприбывшие
        <?php }elseif(empty($data->values['date_drain_from'])){ ?>
            На территории
        <?php }elseif(empty($data->values['date_drain_to'])){ ?>
            На разгрузке
        <?php }elseif(empty($data->values['date_departure'])){ ?>
            На территории
        <?php }else{ ?>
            Убывшие
        <?php } ?>
    </td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td>
        <?php echo $data->getElementValue('shop_boxcar_client_id'); ?>
        <?php if($data->values['shop_client_id'] > 0){ ?>
            <br><span class="text-red"><?php echo $data->getElementValue('shop_client_id'); ?></span>
        <?php } ?>
    </td>
    <td><?php echo $data->values['number']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_drain_from']); ?></td>
    <td><?php echo $data->getElementValue('drain_zhdc_from_shop_operation_id'); ?></td>
    <td>
        <?php echo $data->getElementValue('drain_from_shop_operation_id_1'); ?><br>
        <?php echo $data->getElementValue('drain_from_shop_operation_id_2'); ?>
    </td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_drain_to']); ?></td>
    <td><?php echo $data->getElementValue('drain_zhdc_to_shop_operation_id'); ?></td>
    <td>
        <?php echo $data->getElementValue('drain_to_shop_operation_id_1'); ?><br>
        <?php echo $data->getElementValue('drain_to_shop_operation_id_2'); ?>
    </td>
    <td><?php echo $data->getElementValue('zhdc_shop_operation_id'); ?></td>
    <td>
        <?php if(empty($data->values['date_departure'])){ ?>
        <ul class="list-inline tr-button">
            <li><a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopboxcar/drain_from', array('id' => 'id'), array(), $data->values); ?>" class="link-green"><i class="fa fa-edit margin-r-5"></i> Начало разгрузки</a></li>
            <li><a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopboxcar/drain_to', array('id' => 'id'), array(), $data->values); ?>" class="link-red"><i class="fa fa-edit margin-r-5"></i> Окончание разгрузки</a></li>
        </ul>
        <?php } ?>
    </td>
</tr>
