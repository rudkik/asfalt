<?php $isAll = Request_RequestParams::getParamBoolean('is_all');?>
<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<tr>
    <?php if($isAll){?>
        <td><?php echo Arr::path($data->values, 'shop_car_id', Arr::path($data->values, 'shop_piece_id', '')); ?></td>
        <td><?php echo $data->getElementValue('shop_car_id', 'ticket', $data->getElementValue('shop_piece_id', 'ticket', '')); ?></td>
        <td><?php echo $data->getElementValue('shop_car_id', 'name', $data->getElementValue('shop_piece_id', 'name', '')); ?></td>
    <?php }?>
    <td>
        <?php if($siteData->operation->getIsAdmin()){ ?>
            <a target="_blank" href="/cash/shopproduct/edit?id=<?php echo $data->values['shop_product_id'];?>" class="text-blue">
                <?php echo $data->getElementValue('shop_product_id'); ?>
            </a>
        <?php }else{ ?>
            <?php echo $data->getElementValue('shop_product_id'); ?>
        <?php } ?>
    </td>
    <td class="text-right">
        <?php
        if(Arr::path($data->values, 'shop_piece_id', 0) > 0){
            $field = 'shop_piece_id';
            $fieldURL = 'shoppiece';
        }else {
            $field = 'shop_car_id';
            $fieldURL = 'shopcar';
        }
        $diff = $data->values['price'] - $data->getElementValue('shop_product_time_price_id', 'price', 0);
        if($diff != 0 && $data->values['shop_product_time_price_id'] > 0){
            ?>
            <span class="text-right text-red" style="font-size: 12px;"><?php echo Func::getNumberStr($diff, TRUE, 2, FALSE); ?> </span><br>
        <?php }?>
        <?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?>
        <?php if($isAll){?>
            <br>
            <?php if($data->values['shop_client_balance_day_id'] > 0){ ?>
                <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/set_current_price', array('shop_product_id' => 'shop_product_id'), array('is_edit_invoice' => true, $field => Arr::path($data->values, $field, 0)), $data->values, true);?>" class="text-right text-blue" style="font-size: 12px;">Текущие цены</a>
                <br>
            <?php }else{ ?>
                <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/break_price_client_balance', array('shop_product_id' => 'shop_product_id'), array('is_edit_invoice' => true, $field => Arr::path($data->values, $field, 0)), $data->values, true);?>" class="text-right text-blue" style="font-size: 12px;">Цены по фикс. балансам</a>
                <br>
            <?php }?>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <a href="<?php echo Func::getFullURL($siteData, '/shopinvoice/del_client_balance_days', array('shop_product_id' => 'shop_product_id'), array('is_edit_invoice' => true, $field => Arr::path($data->values, $field, 0)), $data->values, true);?>" class="text-right text-red" style="font-size: 12px;">Не учитывать сумму</a>
                <?php }?>
        <?php }?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <?php if(!$isShow){ ?>
    <td>
        <ul class="list-inline tr-button">
            <?php if($isAll){ ?>
                <?php if(Arr::path($data->values, 'shop_piece_id', 0) > 0){ ?>
                    <li><a href="<?php echo Func::getFullURL($siteData, '/shoppiece/edit', array(), array('id' => Arr::path($data->values, 'shop_piece_id', 0)), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Подробно</a></li>
                <?php }else{ ?>
                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopcar/edit', array(), array('id' => Arr::path($data->values, 'shop_car_id', 0)), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Подробно</a></li>
                <?php } ?>
            <?php } ?>
            <?php if($data->getElementValue('shop_invoice_id', 'check_type_id') != Model_Ab1_CheckType::CHECK_TYPE_PRINT || $siteData->operation->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING || $siteData->operation->getIsAdmin()){?>
                <li>
                    <a data-action="invoice-edit" href="<?php
                    echo Func::getFullURL($siteData, '/shopinvoice/invoice_edit',
                        array(),
                        array(
                            'shop_client_id' => $data->values['shop_client_id'],
                            'shop_client_attorney_id' => $data->values['shop_client_attorney_id'],
                            'shop_client_contract_id' => $data->values['shop_client_contract_id'],
                            'shop_invoice_id' => $data->values['shop_invoice_id'],
                            'shop_product_id' => $data->values['shop_product_id'],
                            'shop_branch_id' => $data->values['shop_id']
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
                        echo Func::getFullURL($siteData, '/shopinvoice/discount_delete',
                            array(),
                            array(
                                'shop_client_id' => $data->values['shop_client_id'],
                                'shop_client_attorney_id' => $data->values['shop_client_attorney_id'],
                                'shop_client_contract_id' => $data->values['shop_client_contract_id'],
                                'shop_invoice_id' => $data->values['shop_invoice_id'],
                                'shop_product_id' => $data->values['shop_product_id'],
                                'shop_branch_id' => $data->values['shop_id']
                            )
                        );
                        ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить скидку</a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </td>
    <?php } ?>
</tr>