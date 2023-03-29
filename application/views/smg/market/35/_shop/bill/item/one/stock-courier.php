<tr>
    <td>
        <?php if($data->values['new_shop_courier_id'] > 0){ ?>
            <b class="text-red"><?php echo $data->getElementValue('new_shop_courier_id'); ?></b>
        <?php } ?>
    </td>
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
    <td>
        <?php echo $data->getElementValue('shop_product_id', 'article'); ?>
        <br><b><?php echo $data->getElementValue('shop_product_id'); ?></b>
        <br><?php echo $data->values['name']; ?>
    </td>
    <td><?php echo $data->getElementValue('shop_supplier_id'); ?></td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['price_cost'], true); ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true); ?></td>
    <td>
        <?php echo $data->getElementValue('shop_bill_id', 'old_id'); ?>
        <br><?php echo $data->getElementValue('shop_company_id'); ?>
        <br><b><?php echo $data->getElementValue('shop_source_id'); ?></b>
    </td>
    <td>
        <?php echo Helpers_DateTime::getDateTimeFormatRus($data->getElementValue('buy_at')); ?>
    </td>
</tr>