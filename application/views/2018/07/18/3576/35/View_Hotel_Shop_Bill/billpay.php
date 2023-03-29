<?php if(Func::_empty($data->getElementValue('shop_client_id')) || Func::_empty($data->getElementValue('shop_client_id', 'phone'))){ ?>
    <header class="header-reserve">
        <div class="container">
            <?php echo trim($siteData->globalDatas['view::View_Hotel_Shop_Bill\bill_client']); ?>
        </div>
    </header>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
    <script>
        $('input[type="phone"]').inputmask({
            mask: "+9 (999) 999 99 99"
        });
    </script>
<?php }else{ ?>
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>
    <header class="header-reserve">
        <div class="container">
            <h2>Минимальная сумма предоплаты - 20%</h2>
            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
            <div class="row box-reserve">
                <?php if (Request_RequestParams::getParamBoolean('is_pay')){?>
                    <div class="col-sm-5" style="text-align: right">
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group text-center">
                            <label>Введите сумму оплаты</label>
                            <input id="total" data-amount="<?php echo $data->values['amount'] - $data->values['paid_amount']; ?>" name="paid_amount" class="form-control box-pay-amount" required="" value="<?php echo intval($data->values['amount'] - $data->values['paid_amount']); ?>" type="text">
                        </div>
                    </div>
                    <div class="col-sm-5">
                    </div>
                <?php }else{?>
                    <div class="col-sm-5" style="text-align: right">
                        <label class="span-checkbox box-percent" style="display: none">
                            20%
                            <input id="pay-20" data-child="#pay-100" data-action="pay-amount" data-value="20" class="minimal" type="checkbox">
                        </label>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group text-center">
                            <label>Выберите сумму предоплаты</label>
                            <input id="total" data-amount="<?php echo $data->values['amount'] - $data->values['paid_amount']; ?>" name="paid_amount" class="form-control box-pay-amount" required="" value="<?php echo intval($data->values['amount'] - $data->values['paid_amount']); ?>" type="text">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <label class="span-checkbox box-percent">
                            <input id="pay-100" data-child="#pay-20" data-action="pay-amount" data-value="100" checked class="minimal" type="checkbox">
                            100%
                        </label>
                    </div>
                <?php }?>
            </div>
            <div class="row box-pays">
                <div class="col-sm-4">
                    <h3>Банковской картой</h3>
                    <p>Оплата производится с любой банковской карты Казахстана (Visa, MasterCard)</p>
                    <p>Система авторизации гарантирует, что платёжные реквизиты вашей карточки не попадут в руки мошенников (поскольку данные пластиковой карты не сохраняются на сервере продавца).</p>
                    <div class="btn-pay">
                        <form action="<?php echo $siteData->urlBasicLanguage;?>/bill/pay/online" method="get">
                            <input name="amount" value="0" style="display: none">
                            <input name="id" value="900" style="display: none">
                            <input name="bill_id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>" style="display: none">
                            <button type="submit" class="btn btn-flat btn-blue-un" style="margin-top: 7px;" type="submit">Далее</button>
                        </form>
                    </div>
                </div>
                <!--
                <div class="col-sm-4">
                    <h3>Через терминал АО "Народный Банк Казахстана"</h3>
                    <p>Вы можете оплатить заказ в ближайшем терминале АО "Народный Банк Казахстана"</p>
                    <div class="btn-pay">
                        <form action="<?php echo $siteData->urlBasicLanguage;?>/bill/pay/online" method="get">
                            <input name="amount" value="0" style="display: none">
                            <input name="id" value="901" style="display: none">
                            <input name="bill_id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>" style="display: none">
                            <button type="submit" class="btn btn-flat btn-blue-un" style="margin-top: 7px;" type="submit">Далее</button>
                        </form>
                    </div>
                </div>
                <div class="col-sm-4">
                    <h3>Через любой банк Казахстана</h3>
                    <p>Вы сможете предоставить счет на оплату оператору любого банка Казахстан, по котору он сможет произвести оплату.</p>
                    <div class="btn-pay">
                        <form action="<?php echo $siteData->urlBasicLanguage;?>/bill/pay/online" method="get">
                            <input name="amount" value="0" style="display: none">
                            <input name="id" value="902" style="display: none">
                            <input name="bill_id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>" style="display: none">
                            <button type="submit" class="btn btn-flat btn-blue-un" style="margin-top: 7px;" type="submit">Далее</button>
                        </form>
                    </div>
                </div>
                -->
            </div>
        </div>
    </header>
    <script>
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        $('[data-action="pay-amount"]').on('ifChecked', function (event) {
            var total = $('#total');

            $($(this).data('child')).iCheck('uncheck').trigger('change');
            $('[name="paid_amount"]').val((Number(total.data('amount')) / 100 * Number($(this).data('value'))).toFixed());

            $('[name="amount"]').val(total.val()).attr('value', total.val());
        }).on('ifUnchecked', function (event) {
            if (!$($(this).data('child')).iCheck('update')[0].checked){
                $($(this).data('child')).iCheck('check').trigger('change');
            }
        });
        $('#total').change(function (event) {
            var total = $('#total');
            var amount = Number(total.val());
            if (amount < Number(total.data('amount')) / 100 * 20){
                total.val((total.data('amount') / 100 * 20).toFixed());
            }else{
                if ((amount == undefined) || (amount > Number(total.data('amount')))){
                    total.val((total.data('amount')).toFixed());
                }
            }

            $('[name="amount"]').val(total.val()).attr('value', total.val());
        });
        var total = $('#total');
        $('[name="amount"]').val(total.val()).attr('value', total.val());
    </script>
<?php } ?>