<div id="invoice-commercial-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление счета-фактуры</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopinvoicecommercial/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <label for="number" class="col-2 col-form-label">Номер</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <input name="number" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control valid" placeholder="Номер" id="number" type="text">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="date" class="col-2 col-form-label">Дата</label>
                                        <div class="col-10">
                                            <div class="form-group margin-0">
                                                <input name="date" data-validation="length" class="form-control" placeholder="Дата" id="date" type="datetime" autocomplete="off" value="<?php echo date('d.m.Y'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(Arr::path($siteData->shop->getRequisitesArray(), 'is_many_bank_account', FALSE)){ ?>
                        <div class="form-group row">
                            <label for="invoice-commercial-new-shop_bank_account_id" class="col-2 col-form-label">Банковский счет</label>
                            <div class="col-10">
                                <div class="form-group margin-0">
                                    <select name="shop_bank_account_id" id="invoice-commercial-new-shop_bank_account_id" class="form-control ks-select" data-parent="#invoice-commercial-new-record" data-parent="#invoice-commercial-new-record" style="width: 100%">
                                        <?php echo $siteData->globalDatas['view::_shop/bank/account/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <input class="form-group row" name="shop_bank_account_id" value="<?php echo intval(Arr::path($siteData->shop->getRequisitesArray(), 'shop_bank_account_id', 0)); ?>" style="display: none">
                    <?php } ?>
                    <div class="form-group row">
                        <label for="invoice-commercial-new-shop_contractor_id" class="col-2 col-form-label">Контрагент</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <div class="input-group">
                                    <select name="shop_contractor_id" id="invoice-commercial-new-shop_contractor_id" class="form-control ks-select" data-parent="#invoice-commercial-new-record" data-parent="#invoice-commercial-new-record" style="width: 100%">
                                        <option value="0" data-id="0">Без контрагента</option>
                                        <option value="-1" data-id="-1">Новый контратент</option>
                                        <?php echo $siteData->globalDatas['view::_shop/contractor/list/list']; ?>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#invoice-commercial-new-shop_contractor_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $view = View::factory('tax/client/35/_shop/contractor/one/new-panel');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->panelID = 'invoice-commercial-new-contractor';
                    $view->selectID = 'invoice-commercial-new-shop_contractor_id';
                    echo Helpers_View::viewToStr($view);
                    ?>
                    <div class="form-group row">
                        <label for="invoice-commercial-new-shop_contract_id" class="col-2 col-form-label">Договор</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <div class="input-group">
                                    <select name="shop_contract_id" id="invoice-commercial-new-shop_contract_id" class="form-control ks-select" data-parent="#invoice-commercial-new-record" style="width: 100%">
                                        <option value="0" data-id="0">Без договора</option>
                                        <option value="-1" data-id="-1">Новый договор</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#invoice-commercial-new-shop_contract_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $view = View::factory('tax/client/35/_shop/contract/one/new-panel');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->panelID = 'invoice-commercial-new-contract';
                    $view->selectID = 'invoice-commercial-new-shop_contract_id';
                    echo Helpers_View::viewToStr($view);
                    ?>
                    <div class="form-group row">
                        <label for="shop_attorney_id" class="col-2 col-form-label">Доверенность</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <div class="input-group">
                                    <select name="shop_attorney_id" id="invoice-commercial-new-shop_attorney_id" class="form-control ks-select" data-parent="#invoice-commercial-new-record" style="width: 100%">
                                        <option value="0" data-id="0">Без доверенности</option>
                                        <option value="-1" data-id="-1">Новая доверенность</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#invoice-commercial-new-shop_attorney_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $view = View::factory('tax/client/35/_shop/attorney/one/new-panel');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->panelID = 'invoice-commercial-new-attorney';
                    $view->selectID = 'invoice-commercial-new-shop_attorney_id';
                    echo Helpers_View::viewToStr($view);
                    ?>
                    <div class="form-group row">
                        <label for="address_delivery" class="col-2 col-form-label">Пункт назначения</label>
                        <div class="col-10">
                            <textarea name="address_delivery" class="form-control" placeholder="Пункт назначения"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label for="paid_type_id" class="col-2 col-form-label">Способ оплаты</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <select name="paid_type_id" id="paid_type_id" class="form-control ks-select" data-parent="#invoice-commercial-new-record" style="width: 100%">
                                            <option value="0" data-id="0">Не выбран</option>
                                            <?php echo $siteData->globalDatas['view::paidtype/list/list']; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="amount" class="col-2 col-form-label">Сумма</label>
                                        <div class="col-10">
                                            <div class="form-group margin-0">
                                                <input id="invoice-commercial-new-amount" class="form-control money-format" placeholder="Сумма" type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <?php echo str_replace('#action#', 'new', $siteData->replaceDatas['view::_shop/invoice/commercial/item/list/index']); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            __initTable();

            $('#invoice-commercial-new-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            }).inputmask({
                mask: "99.99.9999"
            });

            $('#invoice-commercial-new-record form').on('submit', function(e){
                e.preventDefault();
                var $that = $(this),
                    formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
                url = $(this).attr('action')+'?json=1';

                jQuery.ajax({
                    url: url,
                    data: formData,
                    type: "POST",
                    contentType: false, // важно - убираем форматирование данных по умолчанию
                    processData: false, // важно - убираем преобразование строк по умолчанию
                    success: function (data) {
                        var obj = jQuery.parseJSON($.trim(data));
                        if (!obj.error) {
                            $('#invoice-commercial-new-record').modal('hide');
                            $('#invoice-commercial-data-table').bootstrapTable('insertRow', {
                                index: 0,
                                row: obj.values
                            });
                            $that.find('input[type="text"], input[type="date"], textarea').val('');
                            $that.find('select').val('0');
                            $that.find('input[type="checkbox"]').removeAttr("checked");

                            $.notify("Запись сохранена");
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

                return false;
            });

            $('#invoice-commercial-new-record form select[name="shop_contractor_id"]').change(function () {
                var id = $(this).val();

                if (id > 0) {
                    jQuery.ajax({
                        url: '/tax/shopcontract/list',
                        data: ({
                            'shop_contractor_id': (id),
                        }),
                        type: "POST",
                        success: function (data) {
                            var tmp = $('#invoice-commercial-new-record form select[name="shop_contract_id"]');
                            var s = tmp.val();
                            tmp.html('<option value="0" data-id="0">Без договора</option><option value="-1" data-id="1">Новый договор</option>' + data);

                            if (s >= 0) {
                                tmp.val(0).trigger('change');
                            }else{
                                tmp.val(-1);
                            }
                        },
                        error: function (data) {
                            console.log(data.responseText);
                        }
                    });

                    jQuery.ajax({
                        url: '/tax/shopattorney/list',
                        data: ({
                            'shop_contractor_id': (id),
                        }),
                        type: "POST",
                        success: function (data) {
                            var tmp = $('#invoice-commercial-new-record form select[name="shop_attorney_id"]');
                            var s = tmp.val();
                            tmp.html('<option value="0" data-id="0">Без доверенности</option><option value="-1" data-id="-1">Новая доверенность</option>' + data);

                            if (s >= 0) {
                                tmp.val(0).trigger('change');
                            }else{
                                tmp.val(-1);
                            }
                        },
                        error: function (data) {
                            console.log(data.responseText);
                        }
                    });
                }else{

                    var tmp = $('#invoice-commercial-new-record form select[name="shop_contract_id"]');
                    if (tmp.val() > 0) {
                        tmp.html('<option value="0" data-id="0">Без договора</option><option value="-1" data-id="1">Новый договор</option>');
                        tmp.val(0).trigger('change');
                    }

                    var tmp = $('#invoice-commercial-new-record form select[name="shop_attorney_id"]');
                    if (tmp.val() > 0) {
                        tmp.html('<option value="0" data-id="0">Без доверенности</option><option value="-1" data-id="-1">Новая доверенность</option>');
                        tmp.val(0).trigger('change');
                    }
                }


                if(id < 0){
                    var tmp = $('#invoice-commercial-new-contractor');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 1);
                }else{
                    var tmp = $('#invoice-commercial-new-contractor');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 0);
                }
            });

            $('#invoice-commercial-new-record form select[name="shop_contract_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#invoice-commercial-new-contract');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_contract"]').attr('value', 1);
                }else{
                    var tmp = $('#invoice-commercial-new-contract');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_contract"]').attr('value', 0);
                }
            });

            $('#invoice-commercial-new-record form select[name="shop_attorney_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#invoice-commercial-new-attorney');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_attorney"]').attr('value', 1);
                }else{
                    var tmp = $('#invoice-commercial-new-attorney');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_attorney"]').attr('value', 0);
                }
            });
        });
    </script>
</div>