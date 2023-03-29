<h2><a href="/customer/shopbranch/edit?id=<?php echo $data->values['id'];?>"><?php echo $data->values['name']; ?></a></h2>
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-column-5">
            <thead>
            <tr>
                <th>Наименование товара</th>
                <th class="tr-header-count">Кол-во</th>
                <th class="tr-header-amount">Цена</th>
                <th class="tr-header-amount">Итого</th>
                <th class="tr-header-buttom"></th>
            </tr>
            </thead>
            <tbody>
            <?php echo trim($data->additionDatas['view::shopgoods/cart']); ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <div class="amount">Итого: <b class="price" data-name="amount-<?php echo $data->values['id']; ?>"><?php echo $data->additionDatas['view::shopcart_amount_str']; ?></b></div>
    </div>
</div>
<div class="row">
    <form class="col-md-12" method="post" action="/customer/shopcart/save">
        <div class="box box-success">
            <div class="box-body" style="max-width: 500px">
                <div class="form-group">
                    <label>Доставка</label>
                </div>
                <div class="form-group">
                    <label class="span">
                        <input type="radio" name="delivery_type_id" value="3104" class="minimal" checked>
                        Курьером
                    </label>
                </div>
                <div class="form-group">
                    <label class="span">
                        <input type="radio" name="delivery_type_id" value="3530" class="minimal">
                        Самовывоз
                    </label>
                </div>
                <div class="form-group">
                    <label for="datetime">Предпочтительная дата получения заказа</label>
                    <input class="form-control" name="client_delivery_date" id="datetime-<?php echo  $data->id; ?>" type="datetime" value="<?php echo date('d.m.Y H:i:s', strtotime("+".(floatval(Arr::path($data->values['options'], 'site_time_delivery', 0)))." hours"))  ?>" style="max-width: 150px">
                </div>
                <script>
                    $('#datetime-<?php echo  $data->id; ?>').datetimepicker({
                        dayOfWeekStart : 1,
                        lang:'ru',
                        format:	'd.m.Y H:i',
                        minDate: '<?php echo date('Y/m/d H:i:s', strtotime("+".(floatval(Arr::path($data->values['options'], 'site_time_delivery', 0)))." hours"))  ?>'
                    });
                </script>
                <div class="form-group">
                    <label class="span">
                        <input type="checkbox" name="data[ch_b]" value="1" class="minimal">
                        Номенклатура --- (ч/б)
                    </label>
                </div>
                <div class="form-group">
                    <label class="span">
                        <input type="checkbox" name="data[is_certificate]" value="1" class="minimal">
                        Предоставить сертификаты на товар
                    </label>
                </div>
                <div class="form-group">
                    <label>Примечание к заказу</label>
                    <textarea name="client_comment" class="form-control" rows="3" placeholder="Примечание к заказу"></textarea>
                </div>
            </div>
            <div class="box-footer">
                <div><span>В корзине</span> - <label data-name="count-<?php echo $data->values['id']; ?>"><?php echo $data->additionDatas['view::shopcart_count']; ?></label> <label>позиций(я)</label></div>
                <div><span>На сумму</span>  - <label class="price" data-name="amount-<?php echo $data->values['id']; ?>"><?php echo $data->additionDatas['view::shopcart_amount_str']; ?></label></div>
                <div><span>Минимальная сумма заказа</span>  - <label class="price text-red" id="min-bill-<?php echo $data->values['id']; ?>" data-value="<?php $bilMin = Arr::path($data->values['options'], 'site_min_bill', 0); echo $bilMin; ?>"><?php echo Func::getPriceStr($siteData->currency, $bilMin); ?></label></div>
                <div class="bill-save">
                    <input name="shop_id" value="<?php echo $data->values['id']; ?>" hidden>
                    <input name="pay_type_id" value="3106" hidden>
                    <input name="shop_bill_status_id" value="1" hidden>
                    <input name="url" value="/customer/shopbill/index" hidden>
                    <button id="apply-bill-<?php echo $data->values['id']; ?>" <?php if($bilMin > $data->additionDatas['view::shopcart_amount']){ echo 'disabled';} ?> type="submit" class="btn btn-success">Подтвердить заказ</button>
                </div>
            </div>
        </div>
    </form>
</div>