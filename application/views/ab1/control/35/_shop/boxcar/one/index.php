<tr data-action="db-click-edit" data-id="<?php echo $data->id; ?>">
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
    <td data-id="date_arrival"><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_arrival']); ?></td>
    <td data-id="drain_zhdc_from_shop_operation_id"><?php echo $data->getElementValue('drain_zhdc_from_shop_operation_id'); ?></td>
    <td data-id="date_departure"><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_departure']); ?></td>
    <td data-id="drain_zhdc_to_shop_operation_id"><?php echo $data->getElementValue('drain_zhdc_to_shop_operation_id'); ?></td>
    <td>
        <?php if(empty($data->values['date_departure'])){ ?>
        <ul class="list-inline tr-button">
            <li><a href="#modal-arrival" data-bs-toggle="modal" data-bs-target="#modal-arrival" class="link-green"><i class="fa fa-edit margin-r-5"></i> Прибытие</a></li>
            <li><a href="#modal-departure" data-bs-toggle="modal" data-bs-target="#modal-departure" class="link-red"><i class="fa fa-edit margin-r-5"></i> Убытие</a></li>
        </ul>
        <?php } ?>
    </td>
</tr>
