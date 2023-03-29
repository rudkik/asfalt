<tr data-action="db-click-edit">
    <td class="text-right">#index#</td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_arrival']); ?></td>
    <td>
        <?php if(empty($data->values['date_arrival'])){ ?>
            Неприбывшие
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
</tr>
