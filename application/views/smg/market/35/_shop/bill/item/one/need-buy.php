<?php
$priceCost = $data->values['price_cost'];
if($priceCost < 0.001){
    $priceCost = floatval($data->getElementValue('shop_product_id', 'price_cost'));
}

$commission = $data->values['commission_source'];
?>
<tr data-id="product" data-supplier="<?php echo $data->getElementValue('shop_product_id', 'shop_supplier_id'); ?>"
    data-price_cost="<?php echo $priceCost; ?>"
    data-quantity="<?php echo $data->values['quantity']; ?>">
    <td class="text-right">#index#</td>
    <td>
        <input name="set-is-public" <?php if ($data->getElementValue('shop_product_id', 'is_public') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopproduct/save', array('id' => 'shop_product_id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->values['shop_product_id']; ?>">
    </td>
    <td class="text-center">
        <input data-field="is_in_stock" name="set-is-public" <?php if ($data->getElementValue('shop_product_id', 'is_in_stock') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopproduct/save', array('id' => 'shop_product_id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->values['shop_product_id']; ?>">
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
    <td>
        <?php
        $integrations = json_decode($data->getElementValue('shop_product_id', 'integrations', '[]'), true);

        $s = '';
        foreach ($integrations as $integration){
            if(empty($integrations)){
                continue;
            }

            if(empty($s) || strlen($integration) < $s){
                $s = $integration;
            }

        }

        echo $s;
        ?>
    </td>
    <td data-id="name"><?php echo $data->getElementValue('shop_product_id', 'name', $data->values['name']); ?></td>
    <td>
        <b><?php echo $data->getElementValue('shop_supplier_id'); ?></b>
        <br><?php ksort($data->additionDatas['supplier_list']); echo implode('<br>', $data->additionDatas['supplier_list']); ?>
    </td>
    <td>
        <?php echo $data->getElementValue('shop_source_id'); ?>
        <br><b><?php echo $commission; ?></b>%
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['price'], true); ?>
        <br><?php echo Func::getNumberStr($data->values['quantity'], true); ?>
        <br><?php echo Func::getNumberStr($data->values['amount'], true); ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($priceCost, true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'] - ($data->values['price'] / 100 * $commission) - $priceCost, true); ?></td>
    <td>
        <?php if (!Func::_empty($data->getElementValue('shop_product_id', 'url'))){ ?>
            <a target="_blank" href="<?php echo $data->getElementValue('shop_product_id', 'url'); ?>" class="text-blue text-sm">Товар</a><br>
        <?php } ?>
    </td>
    <td>
        <?php if ($data->getElementValue('shop_product_id', 'root_shop_product_id') > 0){ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopproduct/child_product', array(), array('id_or_root_shop_product_id' => $data->getElementValue('shop_product_id', 'root_shop_product_id'), 'is_public_ignore' => true, 'sort_by' => ['root_shop_product_id' => 'asc'])); ?>" class="text-blue text-sm"><?php echo $data->getElementValue('shop_product_id', 'root_shop_product_id'); ?></a><br>

            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopproduct/save', array('id' => 'shop_product_id'), array('root_shop_product_id' => 0), $data->values); ?>" class="text-red text-sm"><i class="fa fa-times margin-r-5"></i> Убрать</a>
        <?php }elseif ($data->getElementValue('shop_product_id', 'child_product_count') > 0){ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopproduct/child_product', array(), array('id_or_root_shop_product_id' => $data->values['shop_product_id'], 'is_public_ignore' => true, 'sort_by' => ['root_shop_product_id' => 'asc'])); ?>" class="text-red text-sm">Детвора</a><br>
        <?php } ?>
    </td>
    <td>
        <ul class="list-inline tr-button">
            <li><a class="text-blue" data-status="<?php echo Model_AutoPart_Shop_Bill_Item_Status::STATUS_NEW;?>" href="<?php echo Func::getFullURL($siteData, '/shopbillitem/set_status', array('current_shop_bill_item_status_id' => Model_AutoPart_Shop_Bill_Item_Status::STATUS_NEW, 'shop_product_id' => 'shop_product_id', 'name' => 'name'), array(), $data->values); ?>" class="link-blue">Изменить статус</a></li>
        </ul>
    </td>
</tr>
<tr>
    <td colspan="16">
        <div class="row">
            <div class="col-md-6">
                <label class="text-blue">Товары в заказах</label>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="width-30 text-right">№</th>
                        <th class="width-130">№ заказа
                            <br>Источник
                        </th>
                        <th class="width-140">
                            Поставщик
                            <br>Дата создания
                            <br>Дата доставки
                        </th>
                        <th>
                            Покупатель, адрес доставки
                        </th>
                        <th class="text-right width-80">Цена Кол-во Сумма</th>
                        <th class="width-155"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; foreach ($data->additionDatas['childs'] as $child) { ?>
                        <tr data-bill="<?php echo $child->getElementValue('shop_bill_id', 'old_id'); ?>" data-id="product" data-supplier="<?php echo $child->getElementValue('shop_product_id', 'shop_supplier_id'); ?>"
                            data-price_cost="<?php echo $priceCost; ?>"
                            data-quantity="<?php echo $child->values['quantity']; ?>">
                            <td rowspan="2"><?php echo $i++; ?></td>
                            <td>
                                <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shopbill/edit', array('id' => 'shop_bill_id'), array(), $data->values); ?>" class="text-green"><?php echo $child->getElementValue('shop_bill_id', 'old_id'); ?></a> (<b><?php echo Func::getNumberStr($child->getElementValue('shop_bill_id', 'quantity')); ?></b>)
                                <br><a target="_blank" class="text-blue" href="https://kaspi.kz/merchantcabinet/#/orders/details/<?php echo $child->getElementValue('shop_bill_id', 'old_id'); ?>"><?php echo $child->getElementValue('shop_source_id'); ?></a>
                                <br><?php echo $child->getElementValue('shop_company_id'); ?>
                            </td>
                            <td>
                                <span class="text-blue"><?php echo $child->getElementValue('shop_supplier_id'); ?></span>
                                <br><b><?php echo Helpers_DateTime::getDateTimeFormatRus($child->getElementValue('shop_bill_id', 'approve_source_at')); ?></b>
                                <br><?php echo Helpers_DateTime::getDateTimeFormatRus($child->getElementValue('shop_bill_id', 'delivery_plan_at')); ?>
                                <br><?php echo Helpers_DateTime::getDateTimeFormatRus($child->getElementValue('shop_bill_id', 'delivery_at')); ?>
                            </td>
                            <td>
                                <a class="text-blue" href="tel:<?php echo $child->getElementValue('shop_bill_buyer_id', 'phone'); ?>"><?php echo $child->getElementValue('shop_bill_buyer_id', 'phone'); ?></a>
                                <br><?php echo $child->getElementValue('shop_bill_id', 'buyer'); ?>
                                <br>
                                <span data-id="address">
                                    <?php if($child->getElementValue('shop_bill_id', 'shop_other_address_id') > 0){ ?>
                                        <span style="text-decoration: line-through;"><?php echo $child->getElementValue('shop_bill_id', 'delivery_address'); ?></span>
                                        <br><b><?php echo $child->getElementValue('shop_other_address_id'); ?></b>
                                    <?php }else{ ?>
                                        <?php echo $child->getElementValue('shop_bill_id', 'delivery_address'); ?>
                                    <?php } ?>
                                </span>
                                <br><a class="text-red" data-action="set-address" href="<?php echo Func::getFullURL($siteData, '/shopbill/set_address', array('shop_bill_id' => 'shop_bill_id'), array(), $child->values); ?>">Изменить</a>
                            </td>
                            <td class="text-right">
                                <?php echo Func::getNumberStr($child->values['price'], true); ?>
                                <br><span <?php if($child->getElementValue('shop_bill_id', 'quantity') != $child->values['quantity']){ ?>class="text-red" <?php } ?>><?php echo Func::getNumberStr($child->values['quantity'], true); ?></span>
                                <br><?php echo Func::getNumberStr($child->values['amount'], true); ?>
                            </td>
                            <td>
                                <ul class="list-inline tr-button">
                                    <li><a class="text-blue" data-status="<?php echo Model_AutoPart_Shop_Bill_Item_Status::STATUS_NEW;?>" href="<?php echo Func::getFullURL($siteData, '/shopbillitem/set_status', array('current_shop_bill_item_status_id' => Model_AutoPart_Shop_Bill_Item_Status::STATUS_NEW, 'shop_bill_item_id' => 'id', 'shop_product_id' => 'shop_product_id', 'name' => 'name'), array(), $child->values); ?>">Изменить статус <br><?php echo $child->getElementValue('shop_bill_item_status_id'); ?></a></li>
                                    <li style="margin-top: 10px"><a class="text-red" data-action="set-courier" href="<?php echo Func::getFullURL($siteData, '/shopbill/set_courier', array('shop_bill_id' => 'shop_bill_id'), array(), $child->values); ?>">Курьер <?php if($child->getElementValue('shop_bill_id', 'shop_courier_id') > 0){ ?> <br><?php echo $child->getElementValue('shop_courier_id'); ?><?php } ?></a></li>
                                    <li style="margin-top: 10px"><a class="text-green" data-action="set-receive" href="<?php echo Func::getFullURL($siteData, '/shopbillitem/set_pre_order', array('shop_bill_item_id' => 'id'), array(), $child->values); ?>">Закуп <?php if($child->values['shop_receive_id'] > 0){ ?> <br><?php echo $child->getElementValue('shop_pre_order_id', 'number'); ?><?php } ?></a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr data-bill="<?php echo $child->getElementValue('shop_bill_id', 'old_id'); ?>">
                            <td colspan="4" data-id="comment"><?php echo htmlspecialchars($child->values['text'], ENT_QUOTES); ?></td>
                            <td>
                                <ul class="list-inline tr-button">
                                    <li><a class="text-blue" data-action="set-comment" href="<?php echo Func::getFullURL($siteData, '/shopbillitem/set_comment', array('shop_bill_item_id' => 'id'), array(), $child->values); ?>">Комментарий</a></li>
                                </ul>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if(count($data->additionDatas['suppliers']->childs) > 0){ ?>
                <?php
                $priceCost = $data->values['price_cost'];
                if($priceCost < 0.001){
                    $priceCost = floatval($data->getElementValue('shop_product_id', 'price_cost'));
                }
                ?>
                <div class="col-md-6">
                <label class="text-blue">Товары других поставщиков</label>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="width-30 text-right">№</th>
                        <th class="tr-header-public">
                            <span>
                                <input type="checkbox" class="minimal" checked disabled>
                            </span>
                        </th>
                        <th class="tr-header-public">Нал.</th>
                        <th style="width: calc((100% - 295px) / 2);">Поставщик</th>
                        <th style="width: calc((100% - 295px) / 2);">Название</th>
                        <th class="text-right width-80">Цена</th>
                        <th class="text-right width-80">Доход</th>
                        <th class="width-95" style="font-size: 12px">Ссылка поставщика</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; foreach ($data->additionDatas['suppliers']->childs as $child) { ?>
                        <tr>
                            <?php $priceCost = floatval($child->values['price_cost']);?>
                            <td><?php echo $i++; ?></td>
                            <td>
                                <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopproduct/save', array('id' => 'id'), array(), $child->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $child->values['id']; ?>">
                            </td>
                            <td class="text-center">
                                <input data-field="is_in_stock" name="set-is-public" <?php if ($child->values['is_in_stock'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopproduct/save', array('id' => 'id'), array(), $child->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $child->values['id']; ?>">
                            </td>
                            <td><?php echo $child->getElementValue('shop_supplier_id'); ?></td>
                            <td><?php echo $child->values['name']; ?></td>
                            <td class="text-right">
                                <?php echo Func::getNumberStr($priceCost, true); ?>
                            </td>
                            <td class="text-right">
                                <?php echo Func::getNumberStr($data->values['price'] - ($data->values['price'] / 100 * $commission) - $priceCost, true); ?>
                            </td>
                            <td>
                                <?php if (!Func::_empty($child->values['url'])){ ?>
                                    <a target="_blank" href="<?php echo $child->values['url']; ?>" class="text-blue text-sm">Товар</a><br>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } ?>
        </div>
    </td>
</tr>