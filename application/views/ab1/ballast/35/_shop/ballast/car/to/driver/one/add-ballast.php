<tr data-shop_ballast_car_id="<?php echo $data->values['shop_ballast_car_id']; ?>"
    data-shop_ballast_driver_id="<?php echo $data->values['shop_ballast_driver_id']; ?>">
    <td>
        <b style="font-size: 18px"><?php echo $data->getElementValue('shop_ballast_car_id', 'name'); ?></b><br>
        <?php echo $data->getElementValue('shop_ballast_driver_id', 'name'); ?>
    </td>
    <td>
        <?php echo $siteData->globalDatas['view::_shop/ballast/crusher/list/add-ballast']; ?>
        <?php if(false && Arr::path($siteData->shop->getOptionsArray(), 'ballast_is_storage', 1) == 1){ ?>
            <button type="button" class="btn bg-purple btn-flat" data-action="add-ballast" data-id="0" style="margin: 0px 10px 10px 0px;"><i class="fa fa-fw fa-plus"></i> Склад</button>
        <?php } ?>
    </td>
    <td data-id="count" style="font-size: 18px; font-weight: 700"><?php echo $data->additionDatas['count']; ?></td>
</tr>
