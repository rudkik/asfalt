<tr data-action="db-click-edit">
    <td>
        <img data-action="show-big"
             data-src="<?php echo Func::getFullURL($siteData, '/shopboxcar/get_images'); ?>"
             data-id="<?php echo $data->id; ?>"
             data-type="<?php echo Model_Ab1_Shop_Boxcar::TABLE_ID; ?>"
             src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>">
    </td>
    <td>
        <?php echo $data->getElementValue('shop_boxcar_client_id'); ?>
        <?php if($data->values['shop_client_id'] > 0){ ?>
            <br><span class="text-red"><?php echo $data->getElementValue('shop_client_id'); ?></span>
        <?php } ?>
    </td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_arrival']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_drain_from']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_drain_to']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_departure']); ?></td>
    <td><?php $arr = Arr::path($data->values['options'], 'stations', array()); echo array_pop($arr); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a data-name="edit" href="<?php echo Func::getFullURL($siteData, '/shopboxcartrain/edit', array(), array('id' => $data->values['shop_boxcar_train_id']), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Открыть отгрузку</a></li>
            <li><a data-name="edit" href="<?php echo Func::getFullURL($siteData, '/shopboxcar/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
