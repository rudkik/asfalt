<tr data-index="#index#" data-article="<?php echo $data->values['article']; ?>" data-action="identify">
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopproduct/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <td>
        <?php
        if (!empty($data->values['image_path'])){
            echo '<img data-id="img" src="' . Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52). '">';
        }else{
            $isImage = false;
            foreach (Arr::path($data->values['options'], 'sources', array()) as $site => $child){
                echo '<img data-id="img" src="' . $child['image']. '" style="max-width: 68px; max-height: 52px;">';

                $isImage = true;
                break;
            }
            if (!$isImage){
                $images = Arr::path($data->values['options'], 'image_urls', array());
                foreach ($images as $image){
                    echo '<img data-id="img" src="' . $image. '" style="max-width: 68px; max-height: 52px;">';
                    break;
                }
            }
        }
        ?>
    </td>
    <td><?php echo $data->values['article']; ?></td>
    <td>
        <span class="integrations" data-id="integrations">
            <?php echo implode(', ', $data->values['integrations']); ?>
        </span>
    </td>
    <td data-id="name"><?php echo $data->values['name']; ?></td>
    <td>
        <?php echo $data->getElementValue('shop_brand_id'); ?>
        <br><?php echo $data->getElementValue('shop_rubric_id'); ?>
    </td>
    <td><?php echo $data->getElementValue('shop_supplier_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price_cost'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'] - $data->values['price_cost'], true); ?></td>
    <td>
        <?php if (!empty($data->values['url'])){ ?>
            <a data-id="url" target="_blank" href="<?php echo $data->values['url']; ?>" class="text-blue text-sm">Товар</a><br>
        <?php } ?>
    </td>
    <td>
        <?php if ($data->values['root_shop_product_id'] > 0){ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopproduct/child_product', array(), array('id_or_root_shop_product_id' => $data->values['root_shop_product_id'], 'is_public_ignore' => true, 'sort_by' => ['root_shop_product_id' => 'asc'])); ?>" class="text-blue text-sm"><?php echo $data->getElementValue('root_shop_product_id', 'article'); ?></a><br>
        <?php }elseif ($data->values['child_product_count'] > 0){ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopproduct/child_product', array(), array('id_or_root_shop_product_id' => $data->values['id'], 'is_public_ignore' => true, 'sort_by' => ['root_shop_product_id' => 'asc'])); ?>" class="text-red text-sm">Детвора</a><br>
        <?php } ?>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/edit', array('id' => 'id'), array(), $data->values); ?>" class="text-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/del', array('id' => 'id'), array(), $data->values); ?>" class="text-red text-sm"><i class="fa fa-times margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="text-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <li><a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopproduct/double', array('id' => 'id'), array(), $data->values); ?>" class="text-green"><i class="fa fa-edit margin-r-5"></i> Дублировать</a></li>
        </ul>
    </td>
</tr>
