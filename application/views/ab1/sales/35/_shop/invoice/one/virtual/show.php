<?php $isAll = Request_RequestParams::getParamBoolean('is_all');?>
<?php if(Arr::path($data->additionDatas, 'is_total', FALSE)){ ?>
    <tr style="font-weight: 700; background-color: rgba(103, 168, 206, 0.4);">
        <?php if($isAll){?>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        <?php }?>
        <td></td>
        <?php if(!$isAll){?>
            <td class="text-right"><?php echo Func::getNumberStr(count($data->additionDatas['ids']), TRUE); ?></td>
        <?php }?>
        <td class="text-right"></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
        <td></td>
    </tr>
<?php }else{ ?>
    <tr>
        <?php if($isAll){?>
            <td class="text-center">
                <?php if(Arr::path($data->values, 'shop_piece_id', 0) > 0){ ?>
                    <input name="set-is-check-invoice" <?php if ($data->values['is_check_invoice'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shoppieceitem/save', array(), array('id' => $data->id), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
                <?php }else{ ?>
                    <input name="set-is-check-invoice" <?php if ($data->values['is_check_invoice'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopcaritem/save', array(), array('id' => $data->id), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
                <?php } ?>
            </td>
            <td><?php echo Arr::path($data->values, 'shop_car_id', Arr::path($data->values, 'shop_piece_id', '')); ?></td>
            <td><?php echo $data->getElementValue('shop_car_id', 'ticket', $data->getElementValue('shop_piece_id', 'ticket', '')); ?></td>
            <td><?php echo $data->getElementValue('shop_car_id', 'name', $data->getElementValue('shop_piece_id', 'name', '')); ?></td>
        <?php }?>
        <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
        <?php if(!$isAll){?>
            <td class="text-right"><?php echo Func::getNumberStr(count($data->additionDatas['ids']), TRUE); ?></td>
        <?php }?>
        <td class="text-right">
            <?php
            $diff = $data->values['price'] - $data->getElementValue('shop_product_time_price_id', 'price', 0);
            if($diff != 0 && $data->values['shop_product_time_price_id'] > 0){
            ?>
            <span class="text-right text-red" style="font-size: 12px;"><?php echo Func::getNumberStr($diff, TRUE, 2, FALSE); ?> </span><br>
            <?php }?>
            <?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?>
        </td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
        <td>
            <ul class="list-inline tr-button">
                <?php if($isAll){?>
                    <?php if(Arr::path($data->values, 'shop_piece_id', 0) > 0){ ?>
                        <li><a href="<?php echo Func::getFullURL($siteData, '/shoppiece/edit', array(), array('id' => Arr::path($data->values, 'shop_piece_id', 0)), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Талон</a></li>
                    <?php }else{ ?>
                        <li><a href="<?php echo Func::getFullURL($siteData, '/shopcar/edit', array(), array('id' => Arr::path($data->values, 'shop_car_id', 0)), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Талон</a></li>
                    <?php } ?>
                <?php }?>
                <li>
                    <a data-action="invoice-edit" href="<?php
                    echo Func::getFullURL($siteData, '/shopinvoice/virtual_edit',
                        array(
                            'shop_client_id' => 'shop_client_id',
                            'shop_client_attorney_id' => 'shop_client_attorney_id',
                            'shop_client_contract_id' => 'shop_client_contract_id',
                            'product_type_id' => 'product_type_id',
                            'date_from' => 'date_from',
                            'date_to' => 'date_to',
                        ),
                        array(
                            'shop_product_id' => $data->values['shop_product_id'],
                            'price' => $data->values['price'],
                        )
                    );
                    ?>">
                        <i class="fa fa-building-o margin-r-5"></i>
                        Изменить доверенность
                    </a>
                </li>
                <?php if($diff != 0 || $data->values['shop_product_time_price_id'] == 0){ ?>
                    <li>
                        <a href="<?php
                        echo Func::getFullURL($siteData, '/shopinvoice/virtual_discount_delete',
                            array(
                                'shop_client_id' => 'shop_client_id',
                                'shop_client_attorney_id' => 'shop_client_attorney_id',
                                'shop_client_contract_id' => 'shop_client_contract_id',
                                'product_type_id' => 'product_type_id',
                                'date_from' => 'date_from',
                                'date_to' => 'date_to',
                            ),
                            array(
                                'shop_product_id' => $data->values['shop_product_id']
                            )
                        );
                        ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить скидку</a>
                    </li>
                <?php } ?>
            </ul>
        </td>
    </tr>
<?php } ?>