<?php $isInTransit = Request_RequestParams::getParamBoolean('is_in_transit'); ?>
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
    <?php if(!$isInTransit){ ?>
        <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_arrival']); ?></td>
        <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_drain_from']); ?></td>
        <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_drain_to']); ?></td>
    <?php } ?>
    <td><?php $arr = Arr::path($data->values['options'], 'stations', array()); echo array_pop($arr); ?></td>
</tr>
