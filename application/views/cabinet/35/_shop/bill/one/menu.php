<li>
    <a href="<?php echo $siteData->urlBasic; ?>/cabinet/shopbill/edit?id=<?php echo $data->values['id']; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?>">
        <h4 style="margin: 0px">
            №<?php echo $data->values['id']; ?>
            <small><i class="fa fa-clock-o"></i> <?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></small>
        </h4>
        <p style="margin: 0px">Сумма: <?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></p>
    </a>
</li>