<?php
$priceCost = $data->values['price_cost'];
if($priceCost < 0.001){
    $priceCost = floatval($data->getElementValue('shop_product_id', 'price_cost'));
}
?>
<tr data-supplier="<?php echo $data->getElementValue('shop_product_id', 'shop_supplier_id'); ?>"
    data-price_cost="<?php echo $priceCost; ?>"
    data-quantity="<?php echo $data->values['quantity']; ?>">
    <td class="text-center">
        <?php
        if (!empty($data->getElementValue('shop_product_id', 'image_path'))){
            echo '<img src="' . Helpers_Image::getPhotoPath($data->getElementValue('shop_product_id', 'image_path'), 68, 52). '">';
        }else{
            $isImage = false;
            $options = json_decode($data->getElementValue('shop_product_id', 'options', '[]'), true);
            foreach (Arr::path($options, 'sources', array()) as $site => $child){
                echo '<img src="' . $child['image']. '" style="max-width: 68px; max-height: 52px;">';

                $isImage = true;
                break;
            }
            if (!$isImage){
                $images = Arr::path($options, 'image_urls', array());
                foreach ($images as $image){
                    echo '<img src="' . $image. '" style="max-width: 68px; max-height: 52px;">';
                    break;
                }
            }
        }
        ?>
    </td>
    <td><?php echo $data->getElementValue('shop_product_id', 'article'); ?></td>
    <td><?php echo $data->getElementValue('shop_product_id', 'name', $data->values['name']); ?></td>
    <td><?php echo $data->getElementValue('shop_supplier_id'); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['bill_item_status_at']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], true); ?></td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['commission_source'], true); ?>%
        <br><?php echo Func::getNumberStr($data->values['amount'] / 100 * $data->values['commission_source'], true); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['commission_supplier'], true); ?>%
        <br><?php echo Func::getNumberStr($data->values['amount_cost'] / 100 * $data->values['commission_supplier'], true); ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price_cost'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount_cost'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['profit'], true); ?></td>
    <td>
        <?php if (!empty($data->values['url'])){ ?>
            <a target="_blank" href="<?php echo $data->values['url']; ?>" class="text-blue text-sm">Товар</a><br>
        <?php } ?>
    </td>
    <td>
        <?php if ($data->getElementValue('shop_product_id', 'root_shop_product_id') > 0){ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopproduct/child_product', array(), array('id_or_root_shop_product_id' => $data->getElementValue('shop_product_id', 'root_shop_product_id'), 'is_public_ignore' => true, 'sort_by' => ['root_shop_product_id' => 'asc'])); ?>" class="text-blue text-sm"><?php echo $data->getElementValue('root_shop_product_id', 'article'); ?></a><br>

            <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/save', array('id' => 'shop_product_id'), array('root_shop_product_id' => 0), $data->values); ?>" class="text-red text-sm"><i class="fa fa-times margin-r-5"></i> Убрать</a>
        <?php }elseif ($data->getElementValue('shop_product_id', 'child_product_count') > 0){ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopproduct/child_product', array(), array('id_or_root_shop_product_id' => $data->values['shop_product_id'], 'is_public_ignore' => true, 'sort_by' => ['root_shop_product_id' => 'asc'])); ?>" class="text-red text-sm">Детвора</a><br>
        <?php } ?>
    </td>
    <td>
    </td>
</tr>