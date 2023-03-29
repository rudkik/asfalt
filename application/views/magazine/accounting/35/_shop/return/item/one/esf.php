<?php
$esf = new Helpers_ESF_Unload_Product();
$arr = json_decode($data->values['esf'], TRUE);
if(is_array($arr)) {
    $esf->loadToArray($arr);
}
?>
<tr data-hash="<?php echo $esf->getHash(); ?>" data-quantity="<?php echo round($data->values['quantity'], 4); ?>" data-price="<?php echo $data->values['price']; ?>">
    <td>
        <span data-id="shop_product_name"><?php echo $data->getElementValue('shop_product_id'); ?></span>
        <input data-id="shop_return_item_id" name="shop_return_items[<?php echo $data->id; ?>][shop_return_item_id]" value="<?php echo $data->values['id']; ?>" hidden>
        <input data-id="hash_esf" name="shop_return_items[<?php echo $data->id; ?>][hash_esf]" value="<?php echo $esf->getHash(); ?>" hidden>
    </td>
    <td class="text-right" data-id="original-quantity">
        <?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?>
    </td>
    <td class="text-right" data-id="original-price">
        <?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?>
    </td>
    <td data-id="total" class="text-right borber-r-blue" value="<?php echo round($data->values['amount'], 2); ?>"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>

    <td data-id="name"><?php echo $esf->getName(); ?></td>
    <?php $quantity = $esf->getQuantity(); ?>
    <td data-id="quantity" class="text-right <?php if(!empty($quantity) && round($quantity, 4) != round($data->values['quantity'], 4)){echo 'tr-red';}?>"><?php echo Func::getNumberStr($quantity, TRUE, 3, FALSE); ?></td>
    <?php $price = round($esf->getPrice(), 2); ?>
    <td data-id="price" class="text-right <?php if(!empty($price) && $price != round($data->values['price'], 2)){echo 'tr-red';}?>"><?php echo Func::getNumberStr($price, TRUE, 2, FALSE); ?></td>
    <td data-id="amount" class="text-right"><?php echo Func::getNumberStr($esf->getAmount(), TRUE, 2, FALSE); ?></td>
    <td>
        <a href="#" class="link-red text-sm" data-action="delete-esf"><i class="fa fa-remove margin-r-5"></i></a>
    </td>
</tr>