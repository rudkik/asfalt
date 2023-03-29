<div class="ks-subscription">
    <div class="ks-header">
        <span class="ks-name"><img src="<?php echo $siteData->urlBasic; ?>/css/tax/img/wooppay.png"></span>
        <span class="ks-price">
            <span class="ks-amount"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></span> <?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.options.period', ''); ?>
        </span>
    </div>
    <div class="ks-body">
        <ul>
            <li class="ks-item">
                <span class="ks-icon fa fa-credit-card-alt"></span>
                <span class="ks-text">Прием платежей с помощью банковской карты <b>Visa/MasterCard</b>.</span>
            </li>
            <li class="ks-item">
                <span class="ks-icon fa fa-google-wallet"></span>
                <span class="ks-text">Оплата электронными деньгами кошелька <b>Wooppay</b>.</span>
            </li>
        </ul>
        <a href="<?php echo $siteData->urlBasic; ?>/tax/site/pay?shop_bill_id=<?php echo $data->id; ?>&shop_paid_type_id=903" class="btn btn-info btn-block ks-active">Выбрать</a>
    </div>
</div>