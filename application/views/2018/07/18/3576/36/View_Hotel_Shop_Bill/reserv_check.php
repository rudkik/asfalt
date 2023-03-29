<?php if (Arr::path($data->values, 'id', 0)  < 1){ ?>
    <?php if (Request_RequestParams::getParamInt('id') > 0){ ?>
        <h3 class="text-left text-red">Order not found</h3>
    <?php } ?>
<?php }else{ ?>
<h3 class="text-left">Your Order <?php echo $data->id; ?> <span style="color: rgb(0, 51, 142);"><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']) .' - '. Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?></h3>
<img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
<div class="row" style="margin-top: 20px;">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover table-rooms table-column-5 table-en">
                    <thead>
                    <tr>
                        <th>Room</th>
                        <th style="width: 200px;">Persons</th>
                        <th style="width: 200px;">Extra Bed, Adults</th>
                        <th style="width: 200px;">Extra Bed, Children</th>
                        <th style="width: 240px;">Amount, KZT</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo $siteData->globalDatas['view::View_Hotel_Shop_Bill_Items\reserv_check']; ?>
                    <tr data-tr="total" class="tr-total total-all-en" style="background-color: rgb(0, 51, 142); color: #fff !important;">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Total, KZT:</b></td>
                        <td>
                            <?php
                            $diffDays = Helpers_DateTime::diffDays($data->values['date_to'], $data->values['date_from']);
                            echo '<b>'.Func::getPriceStr($siteData->currency, $data->values['amount']). '</b> '.$diffDays. ' Per Night';
                            ?>
                        </td>
                    </tr>
                    <tr class="tr-total total-pay-en">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Paid, KZT:</b></td>
                        <td>
                            <?php echo Func::getPriceStr($siteData->currency, $data->values['paid_amount']);?>
                        </td>
                    </tr>
                    <tr class="tr-total total-not-pay-en">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Balance, KZT:</b></td>
                        <td>
                            <b><?php echo Func::getPriceStr($siteData->currency, $data->values['amount'] - $data->values['paid_amount']);?></b>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($data->values['paid_amount'] < $data->values['amount']){?>
        <div class="client-info">
            <div class="row">
                <div class="col-sm-12 box-button-rooms">
                    <a href="<?php echo $siteData->urlBasicLanguage;?>/bill/pay?id=<?php echo $data->id; ?>&is_pay=<?php echo $data->values['paid_amount'] > 0; ?>" class="btn btn-flat btn-blue-un" style="width: 200px">Pay</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>