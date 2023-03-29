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
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price_cost'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price_cost'] * $data->values['quantity'], true); ?></td>
</tr>
<tr>
    <td>
        <label class="span-checkbox">
            <input name="is_buys[<?php echo $data->values['id']; ?>]" value="1" checked type="checkbox" class="minimal">
        </label>
    </td>
    <td colspan="5">
        <input name="barcodes[<?php echo $data->values['id']; ?>]" type="text" class="form-control" placeholder="Штрих-код товара">
    </td>
</tr>