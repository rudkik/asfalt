<?php if (Arr::path($data->values, 'id', 0)  < 1){ ?>
    <?php if (Request_RequestParams::getParamInt('id') > 0){ ?>
        <h3 class="text-left text-red">Заказ не найден</h3>
    <?php } ?>
<?php }elseif (Arr::path($data->values, 'is_public', 0)  < 1){ ?>
    <h3 class="text-left">Ваша бронь №<?php echo $data->id;?> <span style="color: rgb(192, 51, 0);">отменена</span></h3>
    <h4 class="text-left">По всем вопросам обращайтесь по телефона: <span class="phones"><?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-sverkhu']); ?></span></h4>
    <style>
        .header-reserve .phones a{
            margin-left: 5px;
        }
    </style>
<?php }else{ ?>
    <h3 class="text-left">Ваша бронь №<?php echo $data->id;?> на <span style="color: rgb(0, 51, 142);"><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']) .' - '. Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?></h3>
    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-rooms table-column-5">
                        <thead>
                        <tr>
                            <th>Номер</th>
                            <th style="width: 200px;">Кол-во мест</th>
                            <th style="width: 200px;">Доп. места, взрослые</th>
                            <th style="width: 200px;">Доп. места, дети</th>
                            <th style="width: 240px;">Сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php echo $siteData->globalDatas['view::View_Hotel_Shop_Bill_Items\reserv_check']; ?>
                        <tr data-tr="total" class="tr-total total-all" style="background-color: rgb(0, 51, 142); color: #fff !important;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>Итого:</b></td>
                            <td>
                                <?php
                                $diffDays = Helpers_DateTime::diffDays($data->values['date_to'], $data->values['date_from']);
                                echo '<b>'.Func::getPriceStr($siteData->currency, $data->values['amount']). '</b> за '.Func::getCountElementStrRus($diffDays, 'дней','день', 'дня');
                                ?>
                            </td>
                        </tr>
                        <tr class="tr-total total-pay">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>Оплачено:</b></td>
                            <td>
                                <?php echo Func::getPriceStr($siteData->currency, $data->values['paid_amount']);?>
                            </td>
                        </tr>
                        <tr class="tr-total total-not-pay">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>Остаток:</b></td>
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
                            <a href="<?php echo $siteData->urlBasicLanguage;?>/bill/pay?id=<?php echo $data->id; ?>&is_pay=<?php echo $data->values['paid_amount'] > 0; ?>" class="btn btn-flat btn-blue-un" style="width: 200px">
                                Оплатить
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>