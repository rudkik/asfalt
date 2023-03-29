<tr data-action="receive-move" data-id="<?php echo $data->values['id']; ?>" data-quantity="<?php echo $data->values['quantity']; ?>">
    <td class="text-right">#index#</td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->getElementValue('shop_bill_id', 'created_at')); ?></td>
    <td><?php echo $data->values['id']; ?></td>
    <td>
        <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopbill/edit', array('id' => 'shop_bill_id'), array(), $data->values); ?>" class="text-blue"><?php echo $data->getElementValue('shop_bill_id', 'old_id'); ?></a>
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
        <?php if ($data->values['shop_supplier_id'] > 0){ ?>
            <b><?php echo $data->getElementValue('shop_supplier_id'); ?></b>
            <br>
        <?php } ?>
        <?php echo $data->values['name']; ?>
        <?php if ($data->values['shop_product_id'] > 0){ ?>
            <br><?php echo $data->getElementValue('shop_product_id'); ?>
        <?php } ?>
        <a data-action="select-bill-item" href="#" class="text-blue" style="font-weight: bold">Соеденить</a>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price_cost'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price_cost'] * $data->values['quantity'], true); ?></td>
</tr>