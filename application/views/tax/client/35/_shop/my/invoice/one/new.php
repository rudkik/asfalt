<div id="my-invoice-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление счета-фактуры</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopmyinvoice/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <label for="number" class="col-2 col-form-label">Входящий номер</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group margin-0">
                                        <input name="number" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control valid" placeholder="Входящий номер" id="number" type="text" readonly>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="row">
                                                <label for="date" class="col-2 col-form-label">Дата</label>
                                                <div class="col-10">
                                                    <div class="form-group margin-0">
                                                        <input name="date" data-validation="length" class="form-control" placeholder="Дата" id="date" type="datetime" autocomplete="off"  value="<?php echo date('d.m.Y'); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="row">
                                                <label for="name" class="col-3 col-form-label">НДС?</label>
                                                <div class="col-9 col-form-label" style="text-align: left;">
                                                    <input name="is_nds" value="0" style="display: none">
                                                    <label class="ks-checkbox-slider ks-on-off ks-primary">
                                                        <input data-nds="<?php echo Api_Tax_NDS::getNDS(); ?>" id="my-invoice-new-is_nds" name="is_nds" type="checkbox" value="1">
                                                        <span class="ks-indicator"></span>
                                                        <span class="ks-on">да</span>
                                                        <span class="ks-off">нет</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="my-invoice-new-shop_contractor_id" class="col-2 col-form-label">Контрагент</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <div class="input-group">
                                    <select name="shop_contractor_id" id="my-invoice-new-shop_contractor_id" class="form-control ks-select" data-parent="#my-invoice-new-record" data-parent="#my-invoice-new-record" style="width: 100%">
                                        <option value="0" data-id="0">Без контрагента</option>
                                        <option value="-1" data-id="-1">Новый контратент</option>
                                        <?php echo $siteData->globalDatas['view::_shop/contractor/list/list']; ?>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#my-invoice-new-shop_contractor_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $view = View::factory('tax/client/35/_shop/contractor/one/new-panel');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->panelID = 'invoice-new-contractor';
                    $view->selectID = 'invoice-new-shop_contractor_id';
                    echo Helpers_View::viewToStr($view);
                    ?>
                    <div class="form-group row">
                        <label for="my-invoice-new-shop_contract_id" class="col-2 col-form-label">Договор</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <div class="input-group">
                                    <select name="shop_contract_id" id="my-invoice-new-shop_contract_id" class="form-control ks-select" data-parent="#my-invoice-new-record" style="width: 100%">
                                        <option value="0" data-id="0">Без договора</option>
                                        <option value="-1" data-id="-1">Новый договор</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#my-invoice-new-shop_contract_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $view = View::factory('tax/client/35/_shop/contract/one/new-panel');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->panelID = 'invoice-new-contract';
                    $view->selectID = 'invoice-new-shop_contract_id';
                    echo Helpers_View::viewToStr($view);
                    ?>
                    <div class="form-group row">
                        <label for="amount" class="col-2 col-form-label">Сумма</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <input id="my-invoice-new-amount" class="form-control money-format" placeholder="Сумма" id="amount" type="text" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <?php echo $siteData->globalDatas['view::_shop/my/invoice/item/list/index']; ?>
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

            $('#my-invoice-new-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            }).inputmask({
                mask: "99.99.9999"
            });

            $('#my-invoice-new-record form').on('submit', function(e){
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
                            $('#my-invoice-new-record').modal('hide');
                            $('#my-invoice-data-table').bootstrapTable('insertRow', {
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

            $('#my-invoice-new-record form select[name="shop_contractor_id"]').change(function () {
                var id = $(this).val();

                if (id > 0) {
                    jQuery.ajax({
                        url: '/tax/shopcontract/list',
                        data: ({
                            'shop_contractor_id': (id),
                        }),
                        type: "POST",
                        success: function (data) {
                            var tmp = $('#my-invoice-new-record form select[name="shop_contract_id"]');
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
                            var tmp = $('#my-invoice-new-record form select[name="shop_attorney_id"]');
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

                    var tmp = $('#my-invoice-new-record form select[name="shop_contract_id"]');
                    if (tmp.val() > 0) {
                        tmp.html('<option value="0" data-id="0">Без договора</option><option value="-1" data-id="1">Новый договор</option>');
                        tmp.val(0).trigger('change');
                    }

                    var tmp = $('#my-invoice-new-record form select[name="shop_attorney_id"]');
                    if (tmp.val() > 0) {
                        tmp.html('<option value="0" data-id="0">Без доверенности</option><option value="-1" data-id="-1">Новая доверенность</option>');
                        tmp.val(0).trigger('change');
                    }
                }


                if(id < 0){
                    var tmp = $('#my-invoice-new-contractor');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 1);
                }else{
                    var tmp = $('#my-invoice-new-contractor');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 0);
                }
            });

            $('#my-invoice-new-record form select[name="shop_contract_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#my-invoice-new-contract');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_contract"]').attr('value', 1);
                }else{
                    var tmp = $('#my-invoice-new-contract');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_contract"]').attr('value', 0);
                }
            });

            $('#my-invoice-new-record form select[name="shop_attorney_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#my-invoice-new-attorney');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_attorney"]').attr('value', 1);
                }else{
                    var tmp = $('#my-invoice-new-attorney');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_attorney"]').attr('value', 0);
                }
            });

            $('#my-invoice-new-is_nds').change(function (){
                var form = $('#my-invoice-new-record form');

                var nds = 0;
                if($(this).prop('checked')){
                    form.find('[data-id="price-nds"]').css('display', '');
                    nds = $(this).data('nds');
                }else{
                    form.find('[data-id="price-nds"]').css('display', 'none');
                }

                form.find('[data-action="tr-calc-amount"]').data('nds', nds).trigger('change');
            });
        });
    </script>
</div>