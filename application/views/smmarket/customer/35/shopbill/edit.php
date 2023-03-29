<h1 class="margin-bottom-10px">Заказ №<?php echo $data->id; ?> <span class="bill-company-name">для <?php echo Arr::path($data->values, '$elements$.shop_id.name', ''); ?></span></h1>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li class="active"><a href="#goods" data-toggle="tab" aria-expanded="false">Заказ</a></li>
                <li class=""><a href="#info" data-toggle="tab" aria-expanded="true">Данные о заказе</a></li>
                <li class=""><a href="#info-legal-supplier" data-toggle="tab" aria-expanded="true">Юридические данные поставщика</a></li>
            </ul>
            <div class="tab-content no-padding">
                <div class="chart tab-pane active" id="goods">
                    <div class="col-md-12">
                        <?php echo trim($siteData->globalDatas['view::shopbillitems/index']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="amount" style="padding-right: 25px;">Итого: <b class="price" data-id="amount-bill"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></b></div>
                    </div>
                    <div class="col-md-12">
                        <div class="bill-save-cart">
                            <a target="_blank" href="/customer/shopbill/load_bill_in_excel?id=<?php echo $data->values['id']; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>&file=bill.xlsx"  class="btn btn-warning">Выгрузка в Excel</a>
                        </div>

                        <?php if(($data->values['shop_bill_status_id'] == 3) || ($data->values['shop_bill_status_id'] == 1)){ ?>
                        <div class="bill-save-bill">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if(($data->values['shop_bill_status_id'] == 3)){ ?>
                                        <a class="btn btn-info pull-right" data-id="5" data-action="set-bill-status" href="">Подтвердить заказ</a>
                                    <?php } ?>
                                    <a class="btn btn-danger pull-right" data-id="6" data-action="set-bill-status" href="">Отменить заказ</a>
                                </div>
                            </div>

                            <form id="bill-comment" class="bill-comment" style="display: none" method="post" action="/customer/shopbill/save">
                                <textarea class="form-control" name="data[customer_comment]" rows="4" placeholder="Примечание к заказу"></textarea>
                                <div class="form-group">
                                    <input name="shop_bill_status_id" value="<?php echo $data->values['shop_bill_status_id']; ?>" hidden>
                                    <input name="id" value="<?php echo $data->id; ?>" hidden>
                                    <input name="shop_branch_id" value="<?php echo $data->values['shop_id']; ?>" hidden>
                                    <button class="btn btn-primary pull-right" type="submit">Сохранить</button>
                                </div>
                            </form>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="chart tab-pane " id="info">
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
                <div class="tab-pane body-partner-goods" id="info-legal-supplier">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>Юридическое название</td>
                                <td><?php echo Arr::path($data->values, '$elements$.shop_id.options.legal_name', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Юридический адрес</td>
                                <td><?php echo Arr::path($data->values, '$elements$.shop_id.options.legal_address', ''); ?></td>
                            </tr>
                            <tr>
                                <td>БИН/ИИН</td>
                                <td><?php echo Arr::path($data->values, '$elements$.shop_id.options.legal_bin', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Номер счета</td>
                                <td><?php echo Arr::path($data->values, '$elements$.shop_id.options.legal_order', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Банк</td>
                                <td><?php echo Arr::path($data->values, '$elements$.shop_id.options.legal_bank', ''); ?></td>
                            </tr>
                            <tr>
                                <td>БИК</td>
                                <td><?php echo Arr::path($data->values, '$elements$.shop_id.options.legal_bik', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Директор</td>
                                <td><?php echo Arr::path($data->values, '$elements$.shop_id.options.legal_director', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Должность директора</td>
                                <td><?php echo Arr::path($data->values, '$elements$.shop_id.options.legal_position_director', ''); ?></td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td><?php echo Arr::path($data->values, '$elements$.shop_id.options.legal_comment', ''); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>