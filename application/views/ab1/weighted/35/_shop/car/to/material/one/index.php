<tr id="<?php echo $data->values['id']; ?>"
    data-name="<?php echo $data->values['name']; ?>"
    data-tarra="<?php echo $data->values['tarra']; ?>"
    data-quantity="<?php if($data->values['quantity'] > 0){echo $data->values['quantity'];}else{echo $data->values['quantity_daughter'];} ?>">
    <td><img data-action="show-big" data-id="<?php echo $data->id; ?>" data-type="<?php echo Model_Ab1_Shop_Car_To_Material::TABLE_ID; ?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td>
        <?php
        echo $data->getElementValue(
            'shop_branch_daughter_id',
            'name',
            $data->getElementValue(
                'shop_daughter_id',
                'name'
            )
        );
        ?><br>
        <?php echo $data->getElementValue('shop_subdivision_daughter_id', 'name'); ?><br>
        <?php echo $data->getElementValue('shop_heap_daughter_id', 'name'); ?>
    </td>
    <td>
        <?php
        echo $data->getElementValue(
            'shop_branch_receiver_id',
            'name',
            $data->getElementValue(
                'shop_client_material_id',
                'name'
            )
        );
        ?><br>
        <?php echo $data->getElementValue('shop_subdivision_receiver_id', 'name'); ?><br>
        <?php echo $data->getElementValue('shop_heap_receiver_id', 'name'); ?>
    </td>
    <td class="text-number"><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_material_id', 'name'); ?></td>
    <td class="text-right" <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>>
        <?php echo Func::getNumberStr($data->values['tarra'], false, 3, false); ?><br>
        <b><?php echo Func::getNumberStr($data->values['quantity'], false, 3, false); ?></b><br>
        <span style="font-size: 20px">
            <?php
            if($data->values['quantity'] > 0){
                echo Func::getNumberStr($data->values['tarra'] + $data->values['quantity'], false, 3, false);
            }else{
                echo Func::getNumberStr($data->values['tarra'] + $data->values['quantity_daughter'], false, 3, false);
            }
            ?>
        </span>
    </td>
    <td class="text-right" data-id="quantity_daughter"><?php echo Func::getNumberStr($data->values['quantity_daughter'], false, 3, false); ?></td>
    <td class="text-right" data-id="quantity_invoice"><?php echo Func::getNumberStr($data->values['quantity_invoice'], false, 3, false); ?></td>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.weighted_operation_id.name', ''); ?></td>
        <td style="font-size: 14px;" class="text-right">
            <?php if($data->values['shop_transport_waybill_id'] > 0){?>
            <a target="_blank" href="<?php echo $siteData->urlBasic . '/atc/shoptransportwaybill/edit?id=' . $data->values['shop_transport_waybill_id']; ?>"><?php echo $data->getElementValue('shop_transport_waybill_id', 'number'); ?></a>
            <?php } ?>
        </td>
    <?php } ?>
    <?php if ($data->values['is_delete'] == 1){ ?>
        <td><?php echo $data->values['text']; ?></td>
        <td><?php $files = Arr::path($data->values['options'], 'files', array());  ?>
            <?php
            foreach ($files as $file){
                if(empty($file)){
                    continue;
                }
                ?>
                <a target="_blank" href="<?php echo Helpers_URL::getFileBasicURL($data->values['shop_id'], $siteData) . Arr::path($file, 'file', ''); ?>">Скачать</a><br>
            <?php } ?>
            </td>
    <?php } ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="#" onclick="sendTareForm(<?php echo $data->id; ?>);" class="link-red">Изменить тару</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a data-action="clone-auto" href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/clone', array('id' => 'id'), array(), $data->values); ?>" class="link-black"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
        </ul>
    </td>
    <td>
        <div class="btn-group pull-left" style="margin-bottom: 10px; margin-right: 10px">
            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                ТТН
                <span class="caret"></span>
                <span class="sr-only">ТТН</span>
            </button>
            <ul class="dropdown-menu" role="menu" style="font-size: 18px;">
                <li><a href="javascript:PrintTTNMaterial(<?php echo $data->id; ?>, '1')">1</a></li>
                <li><a href="javascript:PrintTTNMaterial(<?php echo $data->id; ?>, '1-2')">1-2</a></li>
                <li><a href="javascript:PrintTTNMaterial(<?php echo $data->id; ?>, '1-4')">1-4</a></li>
                <li><a href="javascript:PrintTTNMaterial(<?php echo $data->id; ?>, '1-5')">1-5</a></li>
                <li><a href="javascript:PrintTTNMaterial(<?php echo $data->id; ?>, '2-4')">2-4</a></li>
            </ul>
        </div>

        <?php if(($data->values['quantity'] <= 0) && ($data->values['shop_branch_receiver_id'] == $siteData->shopID)){?>
            <a href="javascript:formReceptionCar(<?php echo $data->id; ?>)" class="btn btn-primary">Принять</a>
            <a href="javascript:formDaughterQuantity(<?php echo $data->id; ?>)" class="btn bg-green" style="font-size: 11px">Принять вес отправителя</a>

        <?php }elseif(($data->values['quantity_daughter'] <= 0) && ($data->values['shop_branch_daughter_id'] == $siteData->shopID)){?>
            <a data-id="send_quantity_daughter" href="javascript:sendDaughterCar(<?php echo $data->id; ?>)" class="btn btn-primary">Принять вес получателя</a>
        <?php }?>
    </td>
</tr>
