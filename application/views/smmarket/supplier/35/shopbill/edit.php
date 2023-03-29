<h1>Заказ №<?php echo $data->values['id']; ?> <span class="bill-company-name">от <?php echo Arr::path($data->values, '$elements$.shop_root_id.name', ''); ?></span></h1>
<div class="row padding-top-20px">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li class="active"><a href="#goods" data-toggle="tab" aria-expanded="false">Заказ</a></li>
                <li class=""><a href="#info-bill" data-toggle="tab" aria-expanded="true">Данные заказа</a></li>
                <li class=""><a href="#info" data-toggle="tab" aria-expanded="true">Данные торговой точки</a></li>
                <li class=""><a href="#info-legal" data-toggle="tab" aria-expanded="true">Юридические контакты</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="tab-content no-padding">
    <div class="tab-pane active" id="goods">
        <form method="post" action="/supplier/shopbill/save">
            <div class="col-md-12 <?php if(($data->values['shop_bill_status_id'] == 1)){echo 'yes';}else{echo 'no';} ?>-edit">
                <?php echo trim($siteData->replaceDatas['view::shopbillitems/index']); ?>
            </div>
            <div class="col-md-12">
                <div class="amount">Итого: <b class="price"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></b></div>
            </div>
            <div class="col-md-12">
                <div class="bill-save-cart">
                    <a target="_blank" href="/supplier/shopbill/load_bill_in_excel?id=<?php echo $data->values['id']; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>&file=bill.xlsx" class="btn btn-warning">Выгрузка в Excel</a>
                </div>

                <?php if(($data->values['shop_bill_status_id'] == 1)){ ?>
                    <div class="bill-save-bill">
                        <div class="row">
                            <div class="col-md-12">
                                <a class="btn btn-info pull-right" data-id="4" data-action="set-bill-status" href="#">Подтвердить заказ</a>
                                <a class="btn btn-danger pull-right" data-id="2" data-action="set-bill-status" href="#">Отменить заказ</a>
                            </div>
                        </div>

                        <div id="bill-comment" class="bill-comment" style="display: none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="delivery_at">Время доставки</label>
                                        <input class="form-control" name="delivery_at" id="delivery_at" type="datetime" style="max-width: 150px" value="<?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['delivery_at']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="4" placeholder="Примечание к заказу" name="data[supplier_comment]"></textarea>
                                    <div class="form-group">
                                        <input name="shop_bill_status_id" value="<?php echo $data->values['shop_bill_status_id']; ?>" hidden>
                                        <input name="shop_branch_id" value="<?php echo $data->values['shop_id']; ?>" hidden>
                                        <input name="id" value="<?php echo $data->id; ?>" hidden>
                                        <button class="btn btn-primary pull-right" type="submit">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </form>
    </div>
    <div class="tab-pane body-partner-goods" id="info-bill">
        <div class="col-md-12">
            <table class="table table-hover table-info-bill">
                <tbody>
                <tr>
                    <td>Статус заказа</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_bill_status_id.name', ''); ?></td>
                </tr>
                <tr>
                    <td>Номенклатура --- (ч/б)</td>
                    <td><?php if(Arr::path($data->values['data'], 'ch_b', '') == 1){echo 'да';}else{echo 'нет';} ?></td>
                </tr>
                <tr>
                    <td>Предоставить сертификаты на товар</td>
                    <td><?php if(Arr::path($data->values['data'], 'is_certificate', '') == 1){echo 'да';}else{echo 'нет';} ?></td>
                </tr>
                <tr>
                    <td>Доставка</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_delivery_type_id.name', ''); ?></td>
                </tr>
                <tr>
                    <td>Фактическое время доставки от поставщика</td>
                    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['delivery_at']); ?></td>
                </tr>
                <tr>
                    <td>Желаемое время доставки заказчика</td>
                    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['client_delivery_date']); ?></td>
                </tr>
                <tr>
                    <td>Примечание к заказу</td>
                    <td>
                        <?php echo $data->values['client_comment']; ?>
                        <?php $s = Arr::path($data->values['data'], 'supplier_comment', ''); if((!empty($s)) && (!empty($data->values['client_comment']))){echo '<br>';} echo $s; ?>
                        <?php $s1 = Arr::path($data->values['data'], 'customer_comment', ''); if((!empty($s1)) && ((!empty($data->values['client_comment'])) || (!empty($s)))){echo '<br>';} echo $s1; ?>
                    </td>
                </tr>
                <tr>
                    <td>Дата создания</td>
                    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane body-partner-goods" id="info">
        <div class="col-md-12">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <td>Торговая точка</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.name', ''); ?></td>
                </tr>
                <tr>
                    <td>Телефоны</td>
                    <td>
                        <?php
                        $phones = Arr::path($data->values, '$elements$.shop_root_id.options.site_phones', array());
                        if((is_array($phones)) && (count($phones))) {
                            $s = '';
                            foreach ($phones as $phone) {
                                $s = $s . trim(Arr::path($phone, 'phone', '') . ' ' . Arr::path($phone, 'info', '')) . ', ';
                            }
                            echo mb_substr($s, 0, -2);
                        }elseif((!is_array($phones))) {
                            echo $phones;
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.site_email', ''); ?></td>
                </tr>
                <tr>
                    <td>Адрес</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.site_address', ''); ?></td>
                </tr>
                <?php
                $map = Arr::path($data->values, '$elements$.shop_root_id.options.site_map', '');
                if(!empty($map)){
                    ?>
                    <tr>
                        <td>Карта</td>
                        <td style="height: 400px"><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor<?php echo $map; ?>&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>Прочее описание</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.site_comment', ''); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane body-partner-goods" id="info-legal">
        <div class="col-md-12">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <td>Юридическое название</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.legal_name', ''); ?></td>
                </tr>
                <tr>
                    <td>Юридический адрес</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.legal_address', ''); ?></td>
                </tr>
                <tr>
                    <td>БИН/ИИН</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.legal_bin', ''); ?></td>
                </tr>
                <tr>
                    <td>Номер счета</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.legal_order', ''); ?></td>
                </tr>
                <tr>
                    <td>Банк</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.legal_bank', ''); ?></td>
                </tr>
                <tr>
                    <td>БИК</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.legal_bik', ''); ?></td>
                </tr>
                <tr>
                    <td>Директор</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.legal_director', ''); ?></td>
                </tr>
                <tr>
                    <td>Должность директора</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.legal_position_director', ''); ?></td>
                </tr>
                <tr>
                    <td>Примечание</td>
                    <td><?php echo Arr::path($data->values, '$elements$.shop_root_id.options.legal_comment', ''); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>