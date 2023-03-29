<?php $source = Arr::path($data->values['options'], 'source', array()); ?>
<tr>
    <td>
        <?php
        if (empty($data->values['image_url'])){ ?>
        <img src="<?php echo Helpers_Image::getPhotoPath($data->getElementValue('shop_product_id', 'image_path'), 68, 52); ?>">
        <?php }else{ ?>
            <img src="<?php echo $data->values['image_url']; ?>">
        <?php } ?>
    </td>
    <td><?php echo $data->getElementValue('shop_product_id', 'article'); ?></td>
    <td><?php echo $data->getElementValue('shop_product_id'); ?></td>
    <td>
        <?php echo $data->getElementValue('shop_brand_id'); ?>
        <br><a target="_blank" class="text-blue" href="<?php echo Func::getFullURL($siteData, '/shoprubricsource/index', array(), array('id' => $data->values['shop_rubric_source_id']));?>"><?php echo $data->getElementValue('shop_rubric_source_id'); ?></a>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_supplier_id'); ?>
        <?php if (!Func::_empty($data->getElementValue('shop_product_id', 'url'))){ ?>
            <br><a target="_blank" href="<?php echo $data->getElementValue('shop_product_id', 'url'); ?>" class="text-blue text-sm">Товар</a><br>
        <?php } ?>
    </td>
    <td class="text-right">
        <?php
        if($data->getElementValue('shop_rubric_source_id', 'is_sale', 0) == 0) {
            echo $data->getElementValue('shop_rubric_source_id', 'commission', '"' . Controller_Smg_Kaspi::PERCENT);
        }else{
            echo $data->getElementValue('shop_rubric_source_id', 'commission_sale', '"' . Controller_Smg_Kaspi::PERCENT);
        }
        ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->getElementValue('shop_product_id', 'price'), true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price_cost'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['profit'], true); ?></td>
    <td>
        <?php echo $data->getElementValue('shop_company_id'); ?>
        <br><?php echo $data->getElementValue('shop_source_id'); ?>
    </td>
    <td>
        <a target="_blank" href="<?php echo $data->getElementValue('shop_product_source_id', 'url'); ?>" class="text-blue text-sm">Ссылка</a><br>
    </td>
    <td class="text-right">
        <b><?php echo Func::getNumberStr($data->values['price_source'], true); ?></b>
        <br>Мин. <?php echo Func::getNumberStr($data->values['price_min'], true); ?>
        <br>Макс. <?php echo Func::getNumberStr($data->values['price_max'], true); ?>
    </td>
    <td class="text-right">
        <b><?php echo $data->values['position_number']; ?></b> / <?php echo $data->values['position_count']; ?>
    </td>
    <td>
        <?php if ($data->getElementValue('shop_product_id', 'root_shop_product_id') > 0){ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopproduct/child_product', array(), array('id_or_root_shop_product_id' => $data->getElementValue('shop_product_id', 'root_shop_product_id'), 'is_public_ignore' => true, 'sort_by' => ['root_shop_product_id' => 'asc'])); ?>" class="text-blue text-sm"><?php echo $data->getElementValue('root_shop_product_id', 'article'); ?></a><br>
        <?php }elseif ($data->getElementValue('shop_product_id', 'child_product_count') > 0){ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopproduct/child_product', array(), array('id_or_root_shop_product_id' => $data->values['shop_product_id'], 'is_public_ignore' => true, 'sort_by' => ['root_shop_product_id' => 'asc'])); ?>" class="text-red text-sm">Детвора</a><br>
        <?php } ?>
    </td>
</tr>
