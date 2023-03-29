<tr>
    <td>
        <a target="_blank" class="text-blue" href="https://kaspi.kz/merchantcabinet/#/orders/details/<?php echo $data->getElementValue('shop_bill_id', 'old_id'); ?>"><?php echo $data->getElementValue('shop_bill_id', 'old_id'); ?></a>
        <br><?php echo $data->getElementValue('shop_company_id'); ?>
    </td>
    <td>
        <?php echo Helpers_DateTime::getDateTimeFormatRus($data->getElementValue('shop_bill_id', 'approve_source_at')); ?>
        <br><b><?php echo Helpers_DateTime::getDateTimeFormatRus($data->getElementValue('shop_bill_id', 'delivery_at')); ?></b>
        <br><?php echo Helpers_DateTime::getDateTimeFormatRus($data->getElementValue('shop_bill_id', 'delivery_plan_at')); ?>
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
    <td><?php echo $data->getElementValue('shop_product_id', 'article'); ?></td>
    <td><?php echo $data->getElementValue('shop_product_id', 'name', $data->values['name']); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], true); ?></td>
    <td class="text-right">
        <input class="form-control" name="price_cost" placeholder="Цена закупа" value="<?php echo Func::getNumberStr($data->values['price_cost'], true); ?>" type="text">
    </td>
    <td><?php echo $data->getElementValue('shop_supplier_id'); ?></td>
    <td class="text-right">
        <input class="form-control" name="commission_supplier" placeholder="Коммисия перевода" value="<?php echo Func::getNumberStr($data->values['commission_supplier'], true); ?>" type="text">
    </td>
    <td><?php echo $data->getElementValue('shop_source_id'); ?></td>
    <td class="text-right">
        <input class="form-control" name="commission_source" placeholder="Коммисия источника" value="<?php echo Func::getNumberStr($data->values['commission_source'], true); ?>" type="text">
    </td>
    <td class="text-right">
        <input class="form-control" name="delivery_amount" placeholder="Стоимость доставки" value="<?php echo Func::getNumberStr($data->values['delivery_amount'], true); ?>" type="text">
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['profit'], true); ?></td>
</tr>