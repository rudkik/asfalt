<tr>
    <td class="text-right">#index#</td>
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
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_bill_id', 'old_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['commission_source'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr(round($data->values['amount'] / 100 * $data->values['commission_source'], 2), true, 2, false); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'] - round($data->values['amount'] / 100 * $data->values['commission_source'], 2), true, 2, false); ?></td>
</tr>