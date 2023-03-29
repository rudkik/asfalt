<?php $isInvoice = $data->values['quantity_invoice'] > 0.0001;  ?>
<tr data-barcode="<?php echo $data->getElementValue('shop_product_id', 'barcode'); ?>" data-action="tr">
    <td data-id="index" class="text-right">$index$</td>
    <td class="relative">
        <i data-action="load-photo-click" class="fa fa-fw fa-camera" style="font-size: 20px;"></i>
        <i data-id="img-status" class="fa fa-fw fa-check is-image" <?php if(!Func::_empty($data->getElementValue('shop_product_id', 'image_path'))){echo 'data-img="true"';} ?>></i>
        <input data-id="<?php echo $data->values['shop_product_id']; ?>" data-action="load-photo" data-id="file" type="file" multiple="multiple" accept=".txt,image/*" style="display: none">
    </td>
    <td>
        <a target="_blank" href="/accounting/shopproduction/index?shop_product_id=<?php echo $data->values['shop_product_id']; ?>"><?php echo $data->getElementValue('shop_product_id'); ?></a>
        <br><span data-id="barcode"><?php echo $data->getElementValue('shop_product_id', 'barcode'); ?></span>
        <input data-id="shop_product_id" name="shop_receive_items[<?php echo $data->id; ?>][shop_product_id]" value="<?php echo $data->values['shop_product_id']; ?>" hidden>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['nds_percent'], TRUE, 2, FALSE); ?></td>
    <td>
        <div class="box-quantity">
            <input <?php if($siteData->action == 'new') { ?>data-active-save="receive"<?php } ?> data-id="quantity" data-keywords="virtual" data-action="tr-multiply" data-total="#total" data-parent-count="3" name="shop_receive_items[<?php echo $data->id; ?>][quantity]" type="tel" class="form-control text-center" placeholder="Кол-во" required value="<?php echo Func::getNumberStr($data->values['quantity'], FALSE, 3); ?>" <?php if($data->values['is_esf'] == 1 || $isInvoice){ ?> readonly<?php }?>>
        </div>
        <div class="box-price">
            <input <?php if($siteData->action == 'new') { ?>data-active-save="receive"<?php } ?> data-keywords="virtual" data-id="price_purchase" data-action="tr-multiply" data-total="#total" data-parent-count="3" name="shop_receive_items[<?php echo $data->id; ?>][price]" type="tel" class="form-control money-format text-right" placeholder="Цена" value="<?php echo Func::getNumberStr($data->values['price'], FALSE); ?>" <?php if($data->values['is_esf'] == 1){ ?> readonly<?php }?> required>
        </div>
    </td>
    <td class="text-right">
        <input data-id="total" data-action="tr-edit-total" data-total="#total" data-parent-count="3" class="form-control text-right" name="shop_receive_items[<?php echo $data->id; ?>][amount]" type="tel" placeholder="Сумма" required value="<?php echo Func::getNumberStr($data->values['amount'], FALSE, 3); ?>" <?php if($data->values['is_esf'] == 1 || $isInvoice){ ?> readonly<?php }?>>
    </td>
    <td class="text-center">
        <?php if($isInvoice){ ?>
            <span class="text-blue">Сдано по ЭСФ: <b><?php echo Func::getNumberStr($data->values['quantity_invoice'], TRUE, 3, FALSE); ?></b></span>
        <?php }elseif($data->values['is_esf'] == 1){ ?>
            <span class="text-green">Загружено из ЭСФ</span>
        <?php }else{ ?>
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        <?php } ?>
    </td>
</tr>