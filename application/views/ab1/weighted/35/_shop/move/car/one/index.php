<tr>
    <td><img data-action="show-big" data-id="<?php echo $data->id; ?>" data-type="<?php echo Model_Ab1_Shop_Move_Car::TABLE_ID; ?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['weighted_entry_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['weighted_exit_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_driver_id.name', ''); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', ''); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_turn_place_id.name', ''); ?></td>
    <td <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['tarra'], true, 3, false); ?></td>
    <td <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.weighted_exit_operation_id.name', ''); ?></td>
        <td style="font-size: 14px;" class="text-right">
            <?php if($data->values['shop_transport_waybill_id'] > 0){?>
            <a target="_blank" href="<?php echo $siteData->urlBasic . '/atc/shoptransportwaybill/edit?id=' . $data->values['shop_transport_waybill_id']; ?>"><?php echo $data->getElementValue('shop_transport_waybill_id', 'number'); ?></a>
            <?php } ?>
        </td>
    <?php } ?>
    <td class="box-history-button">
        <div class="btn-group pull-left">
            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                ТТН
                <span class="caret"></span>
                <span class="sr-only">ТТН</span>
            </button>
            <ul class="dropdown-menu" role="menu" style="font-size: 18px;">
                <li><a href="javascript:PrintTTN(<?php echo $data->id; ?>, '1')">1</a></li>
                <li><a href="javascript:PrintTTN(<?php echo $data->id; ?>, '1-2')">1-2</a></li>
                <li><a href="javascript:PrintTTN(<?php echo $data->id; ?>, '1-4')">1-4</a></li>
                <li><a href="javascript:PrintTTN(<?php echo $data->id; ?>, '1-5')">1-5</a></li>
                <li><a href="javascript:PrintTTN(<?php echo $data->id; ?>, '2-4')">2-4</a></li>
            </ul>
        </div>
        <button type="button" class="btn btn-default pull-left" onclick="PrintTalon(<?php echo $data->id; ?>);"><i class="fa fa-fw fa-print"></i> Талон</button>
        <button type="button" class="btn bg-purple btn-flat" onclick="showAutoAdd(<?php echo $data->values['id'];?>)"><i class="fa fa-fw fa-plus"></i> Добавить машину</button>
    </td>
</tr>
