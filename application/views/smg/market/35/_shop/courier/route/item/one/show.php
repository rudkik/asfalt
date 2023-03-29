<div class="profile" data-id="bill" style="vertical-align: top;">
    <div class="user-info" style="padding: 10px 0 15px 15px;">
        <div class="row">
            <div class="col-xs-12">
                <p>Маршрут №<strong><?php echo $data->values['id']; ?></strong> <?php if ($data->values['is_finish'] == 1) { ?><span class="label label-blue mrs">завершен</span><?php }else{ ?><span class="label label-red mrs">новый</span><?php } ?></p>
                <h4>
                    <?php if ($data->values['shop_other_address_id'] > 0) { ?>
                        <?php $address = $data->getElementValue('shop_other_address_id'); ?>
                    <?php }elseif ($data->values['shop_bill_delivery_address_id'] > 0) { ?>
                        <?php $address = $data->getElementValue('shop_bill_delivery_address_id'); ?>
                    <?php }elseif ($data->values['shop_supplier_address_id'] > 0) { ?>
                        <?php $address = $data->getElementValue('shop_supplier_address_id'); ?>
                    <?php } ?>
                    <a class="text-blue" href="yandexmaps://maps.yandex.ru/<?php echo URL::query(['text' => $address], false); ?>"><?php echo $address; ?></a>
                </h4>
                <p style="font-size: 14px; margin-bottom: 25px;">
                    <?php if ($data->values['shop_supplier_id'] > 0) { ?>
                        <strong>Поставщик</strong> <?php echo $data->getElementValue('shop_supplier_id'); ?><br>
                    <?php } ?>
                    <?php if ($data->values['shop_pre_order_id'] > 0) { ?>
                        <a href="<?php echo Func::getFullURL($siteData, '/shoppreorder/show', array('id' => 'shop_pre_order_id'), array(), $data->values); ?>"><strong>Закуп</strong> №<span class="text-blue"><?php echo $data->getElementValue('shop_pre_order_id', 'number'); ?></span></a><br>
                    <?php } ?>
                    <?php if ($data->values['shop_bill_id'] > 0) { ?>
                        <a href="<?php echo Func::getFullURL($siteData, '/shopbill/courier', array('id' => 'shop_bill_id'), array(), $data->values); ?>"><strong>Заказ</strong> №<span class="text-blue"><?php echo $data->getElementValue('shop_bill_id', 'old_id'); ?></span></a><br>
                    <?php } ?>
                </p>
                <?php if($data->values['is_finish'] == 0){ ?>
                    <div class="input-group" style="width: 100%">
                        <?php if(empty($data->values['from_at'])){ ?>
                            <a href="<?php echo Func::getFullURL($siteData, '/shopcourierrouteitem/start', ['id' => 'id'], [], $data->values);  ?>" class="btn btn-green" style="padding: 6px 22px;">Старт</a>
                        <?php }else{ ?>
                            <a href="<?php echo Func::getFullURL($siteData, '/shopcourierrouteitem/finish', ['id' => 'id'], [], $data->values);  ?>" class="btn btn-blue" style="padding: 6px 22px;">На месте</a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
