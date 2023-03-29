<h2>Confirmation</h2>
<img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
<div class="row box-pays">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-4">
        <h3>Your Order is ready for payment</h3>
        <p>Booking Code  <b style="font-size: 28px;"><?php echo Request_RequestParams::getParamInt('bill_id'); ?></b></p>
        <?php if (Request_RequestParams::getParamInt('id') == 900){?>
        <form action="<?php echo $data->values['url_bank'];?>" method="POST">
            <div style="display: none">
                <?php echo $data->values['data'];?>
            </div>
            <div class="btn-pay">
                <button class="btn btn-flat btn-blue-un" type="submit">Pay</button>
            </div>
        </form>
        <?php } ?>
    </div>
</div>
