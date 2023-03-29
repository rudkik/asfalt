<?php if(($data->values['shop_paid_type_id'] == 903) || ($data->values['shop_paid_type_id'] == 899)){?>
    <div class="form-group row" style="margin: 0px">
        <label class="col-2 col-form-label" style="padding: 15px 0px;">Оплачено</label>
        <div class="col-10 col-form-label text-left">
            <?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['paid_at']);?>: <b style="padding-right: 10px;"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']);?></b><a target="_blank" href="/hotel/shopexcel/pko?id=<?php echo $data->id; ?>" class="btn btn-primary">ПКО</a>
        </div>
    </div>
<?php }else{?>
    <div class="form-group row" style="margin: 0px">
        <label class="col-2 col-form-label">Оплачено</label>
        <div class="col-10 col-form-label text-left">
            <?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['paid_at']);?>: <b style="padding-right: 10px;"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']);?></b>
        </div>
    </div>
<?php }?>
