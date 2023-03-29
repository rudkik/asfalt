<div id="my-attorney-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование доверенности</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopmyattorney/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <label for="number" class="col-2 col-form-label">Номер</label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group margin-0">
                                            <input name="number" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control valid" placeholder="Номер" id="number" type="text" value="<?php echo $data->values['number']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <label for="date" class="col-2 col-form-label">Сумма</label>
                                            <div class="col-10">
                                                <div class="form-group margin-0">
                                                    <input name="amount" class="form-control money-format valid" placeholder="Сумма" id="my-attorney-new-amount" type="text" value="<?php echo Func::getNumberStr($data->values['amount'], FALSE);?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(Arr::path($siteData->shop->getRequisitesArray(), 'is_many_bank_account', FALSE)){ ?>
                            <div class="form-group row">
                                <label for="my-attorney-edit-shop_bank_account_id" class="col-2 col-form-label">Банковский счет</label>
                                <div class="col-10">
                                    <div class="form-group margin-0">
                                        <select name="shop_bank_account_id" id="my-attorney-edit-shop_bank_account_id" class="form-control ks-select" data-parent="#my-attorney-edit-record" data-parent="#my-attorney-edit-record" style="width: 100%">
                                            <?php echo $siteData->globalDatas['view::_shop/bank/account/list/list']; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <input class="form-group row" name="shop_bank_account_id" value="<?php if($data->values['shop_bank_account_id'] > 0){echo $data->values['shop_bank_account_id'];}else{echo intval(Arr::path($siteData->shop->getRequisitesArray(), 'shop_bank_account_id', 0));} ?>" style="display: none">
                        <?php } ?>
                        <div class="form-group row">
                            <label for="shop_contractor_id" class="col-2 col-form-label">Контрагент</label>
                            <div class="col-10">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_contractor_id" id="my-attorney-edit-shop_contractor_id" class="form-control ks-select" data-parent="#my-attorney-edit-record" style="width: 100%">
                                            <option value="0" data-id="0">Без контрагента</option>
                                            <option value="-1" data-id="-1">Новый контратент</option>
                                            <?php echo $siteData->globalDatas['view::_shop/contractor/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#my-attorney-edit-shop_contractor_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $view = View::factory('tax/client/35/_shop/contractor/one/new-panel');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->panelID = 'my-attorney-edit-contractor';
                        $view->selectID = 'my-attorney-edit-shop_contractor_id';
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <div class="row">
                            <label for="number" class="col-2 col-form-label">Дата начала</label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group margin-0">
                                            <input name="date_from" class="form-control valid" placeholder="Дата начала" id="date_from" type="datetime" autocomplete="off" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from'], ENT_QUOTES);?>">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="row">
                                            <label for="date" class="col-3 col-form-label">Дата окончания</label>
                                            <div class="col-9">
                                                <div class="form-group margin-0">
                                                    <input name="date_to" class="form-control valid" placeholder="Дата окончания" id="date_to" type="datetime" autocomplete="off" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to'], ENT_QUOTES);?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shop_worker_id" class="col-2 col-form-label">Кому выдана</label>
                            <div class="col-10">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_worker_id" id="my-attorney-edit-shop_worker_id" class="form-control ks-select" data-parent="#my-attorney-edit-record" style="width: 100%">
                                            <option value="0" data-id="0">Без сотрудника</option>
                                            <option value="-1" data-id="-1">Новый сотрудник</option>
                                            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#my-attorney-edit-shop_worker_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $view = View::factory('tax/client/35/_shop/worker/one/new-panel');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->panelID = 'my-attorney-edit-worker';
                        $view->selectID = 'my-attorney-edit-shop_worker_id';
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <div class="form-group row">
                            <label for="text" class="col-2 col-form-label">Активов по</label>
                            <div class="col-10">
                                <textarea name="text" class="form-control" placeholder="Наименование, номер и дата документа"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES);?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <?php echo $siteData->globalDatas['view::_shop/my/attorney/item/list/index']; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $.validate({
                modules : 'location, date, security, file',
                lang: 'ru',
                onModulesLoaded : function() {

                }
            });
            __initTable();

            $('#my-attorney-edit-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            }).inputmask({
                mask: "99.99.9999"
            });

            $('#my-attorney-edit-record form select[name="shop_contractor_id"]').change(function () {
                var id = $(this).val();

                if (id > 0) {
                    jQuery.ajax({
                        url: '/tax/shopcontract/list',
                        data: ({
                            'shop_contractor_id': (id),
                        }),
                        type: "POST",
                        success: function (data) {
                            var tmp = $('#my-attorney-edit-record form select[name="shop_contract_id"]');
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
                            var tmp = $('#my-attorney-edit-record form select[name="shop_attorney_id"]');
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

                    var tmp = $('#my-attorney-edit-record form select[name="shop_contract_id"]');
                    if (tmp.val() > 0) {
                        tmp.html('<option value="0" data-id="0">Без договора</option><option value="-1" data-id="1">Новый договор</option>');
                        tmp.val(0).trigger('change');
                    }

                    var tmp = $('#my-attorney-edit-record form select[name="shop_attorney_id"]');
                    if (tmp.val() > 0) {
                        tmp.html('<option value="0" data-id="0">Без доверенности</option><option value="-1" data-id="-1">Новая доверенность</option>');
                        tmp.val(0).trigger('change');
                    }
                }


                if(id < 0){
                    var tmp = $('#my-attorney-edit-contractor');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 1);
                }else{
                    var tmp = $('#my-attorney-edit-contractor');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 0);
                }
            });

            $('#my-attorney-edit-record form select[name="shop_worker_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#my-attorney-edit-worker');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_worker"]').attr('value', 1);
                }else{
                    var tmp = $('#my-attorney-edit-worker');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_worker"]').attr('value', 0);
                }
            });

            $('#my-attorney-edit-record form').on('submit', function(e){
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
                            $('#my-attorney-edit-record').modal('hide');
                            $('#my-attorney-data-table').bootstrapTable('updateByUniqueId', {
                                id: obj.values.id,
                                row: obj.values
                            });

                            $.notify("Запись сохранена");
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

                return false;
            });
        });
    </script>
</div>