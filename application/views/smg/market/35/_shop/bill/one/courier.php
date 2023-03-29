<div class="profile" data-id="bill">
    <div class="user-info" style="padding: 15px 0px;">
        <div style="margin-bottom: 15px" class="row">
            <div class="col-xs-12">
                <?php if($siteData->operation->getShopPositionID() == 0){ ?>
                    <p>Курьер: <b><?php echo $data->getElementValue('shop_courier_id'); ?></b></p>
                <?php } ?>
                <p>Заказ №<strong><?php echo $data->values['old_id']; ?></strong> <span class="label label-green mrs"><?php echo $data->getElementValue('shop_company_id'); ?></span></p>
                <h4><a class="text-blue" href="yandexmaps://maps.yandex.ru/<?php echo URL::query(['text' => $data->values['delivery_address']], false); ?>"><?php echo $data->values['delivery_address']; ?></a></h4>
                <p>
                    <strong>Телефон:</strong> <a class="text-blue" href="tel:+7<?php echo $data->getElementValue('shop_bill_buyer_id', 'phone'); ?>">+7<?php echo $data->getElementValue('shop_bill_buyer_id', 'phone'); ?></a>
                    <br><strong>Покупатель:</strong> <?php echo $data->values['buyer']; ?>
                </p>
                <p>
                    <strong>Товары:</strong><br>
                    <?php echo trim($data->additionDatas['view::_shop/bill/item/list/courier']); ?>
                    <strong>Итого:</strong> <strong class="text-green" style="font-size: 16px"><?php echo Func::getNumberStr($data->values['amount'], true); ?></strong> тг
                </p>
                <div class="input-group">
                    <div class="input-group-addon padding-0"><button data-action="send-sms-bill" data-id="<?php echo $data->id; ?>" data-number="<?php echo $data->values['old_id']; ?>" type="button" class="btn btn-green">Выслать смс</button></div>
                    <input type="text" name="secret-code" class="form-control">
                    <div class="input-group-addon padding-0"><button data-action="completed-bill" data-id="<?php echo $data->id; ?>" data-number="<?php echo $data->values['old_id']; ?>" type="button" class="btn btn-blue">Подтвердить</button></div>
                </div>
            </div>
        </div>
    </div>
</div>
