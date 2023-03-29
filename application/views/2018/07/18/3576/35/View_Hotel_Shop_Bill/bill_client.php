<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>

<h3 class="text-left">Ваша бронь №<?php echo $data->id; ?> на <span style="color: rgb(0, 51, 142);"><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']) .' - '. Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?></h3>
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
                    <?php echo $siteData->globalDatas['view::View_Hotel_Shop_Bill_Items\bill_client']; ?>
                    <tr data-tr="total" class="tr-total total-all" style="background-color: rgb(0, 51, 142); color: #fff !important;">
                        <td class="text-right"><b>Итого:</b></td>
                        <?php echo $siteData->globalDatas['view::total_human']; ?>
                        <td style="background-color: rgb(0, 51, 142) !important;">
                            <?php
                            $diffDays = Helpers_DateTime::diffDays($data->values['date_to'], $data->values['date_from']);
                            echo '<b>'.Func::getPriceStr($siteData->currency, $data->values['amount']). '</b> за '.Func::getCountElementStrRus($diffDays, 'дней','день', 'дня');
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9">
            </div>
            <div class="col-sm-12">
                <h3 class="text-left">Ваши контакты</h3>
                <form action="<?php echo $siteData->urlBasicLanguage;?>/hotel/room/save_bill" method="get" class="client-info" style="max-width: 100%">
                    <div class="row">
                            <?php $_GET['client_id'] = $data->values['shop_client_id'];  echo $siteData->globalDatas['view::View_Hotel_Shop_Client\bill_client']; ?>
                            <div class="form-group">
                                <label>Примечание</label>
                                <textarea class="form-control" name="text" rows="3" placeholder="Примечание"><?php echo htmlspecialchars($data->values['text']); ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="span-checkbox">
                                    <input name="is_check"  value="1" checked type="checkbox" class="minimal">
                                    Ознакомлен с <a href="<?php echo $siteData->urlBasicLanguage;?>/document?id=4078&bill=<?php echo Request_RequestParams::getParamInt('id');?>">Правилами обслуживания и размещения гостей</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12 box-button-rooms">
                            <input name="shop_id" value="3576" style="display: none;" >
                            <input name="url" value="<?php echo $siteData->urlBasicLanguage;?>/bill/pay?id=<?php echo $data->id; ?>" style="display: none">
                            <input name="id" value="<?php echo $data->id; ?>" style="display: none;" >
                            <input data-id="shop_rooms" name="shop_rooms[]" value="<?php echo $data->id; ?>" style="display: none" type="checkbox">

                            <button id="btn-save" class="btn btn-flat btn-blue-un pull-right" type="submit" style="width: 200px">Далее</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('input[name="is_check"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    }).on('ifChecked', function (event) {
        $('#btn-save').removeAttr('disabled');
    }).on('ifUnchecked', function (event) {
        $('#btn-save').attr('disabled', '');
    });
</script>