<?php $key = '-is_cash-'.$data->values['is_cash'].'-is_coming-'.$data->values['is_coming']; ?>
<div id="money<?php echo $key; ?>-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopmoney/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <label for="number" class="col-3 col-form-label">Сумма</label>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group margin-0">
                                            <input name="amount" class="form-control money-format" placeholder="Сумма" id="amount" type="text" value="<?php echo Func::getNumberStr($data->values['amount'], FALSE); ?>">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <label for="date" class="col-4 col-form-label">Дата</label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="date" class="form-control" placeholder="Дата" id="date_from" type="datetime" autocomplete="off" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date'], ENT_QUOTES);?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="money<?php echo $key; ?>-edit-shop_contractor_id" class="col-3 col-form-label">Контрагент</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_contractor_id" id="money<?php echo $key; ?>-edit-shop_contractor_id" class="form-control ks-select" data-parent="#money<?php echo $key; ?>-edit-record" style="width: 100%">
                                            <option value="0" data-id="0">Без контрагента</option>
                                            <option value="-1" data-id="-1">Новый контратент</option>
                                            <?php echo $siteData->globalDatas['view::_shop/contractor/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#money<?php echo $key; ?>-edit-shop_contractor_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $view = View::factory('tax/client/35/_shop/contractor/one/new-panel');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->panelID = 'money'.$key.'-edit-contractor';
                        $view->selectID = 'money'.$key.'-edit-shop_contractor_id';
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <div class="form-group row">
                            <label for="money<?php echo $key; ?>-edit-shop_contract_id" class="col-3 col-form-label">Договор</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_contract_id" id="money<?php echo $key; ?>-edit-shop_contract_id" class="form-control ks-select" data-parent="#money<?php echo $key; ?>-edit-record" style="width: 100%">
                                            <option value="0" data-id="0">Без договора</option>
                                            <option value="-1" data-id="-1">Новый договор</option>
                                            <?php echo $siteData->globalDatas['view::_shop/contract/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#money<?php echo $key; ?>-edit-shop_contract_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $view = View::factory('tax/client/35/_shop/contract/one/new-panel');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->panelID = 'money'.$key.'-edit-contract';
                        $view->selectID = 'money'.$key.'-edit-shop_contract_id';
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <div class="form-group row">
                            <label for="text" class="col-3 col-form-label">Примечание</label>
                            <div class="col-9">
                                <textarea name="text" class="form-control" placeholder="Примечание"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES);?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>

                    <?php if ($siteData->action != 'clone'){ ?>
                        <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                    <?php }else{ ?>
                        <input name="is_cash" value="<?php echo $isCash; ?>" style="display: none">
                        <input name="is_coming" value="<?php echo $isComing; ?>" style="display: none">
                    <?php } ?>
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

            $('#money<?php echo $key; ?>-edit-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            }).inputmask({
                mask: "99.99.9999"
            });

            $('#money<?php echo $key; ?>-edit-record form').on('submit', function(e){
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
                            $('#money<?php echo $key; ?>-edit-record').modal('hide');

                            if ('<?php echo $siteData->action; ?>' != 'clone') {
                                $('#money<?php echo $key; ?>-data-table').bootstrapTable('updateByUniqueId', {
                                    id: obj.values.id,
                                    row: obj.values
                                });
                            }else{
                                $('#money<?php echo $key; ?>-data-table').bootstrapTable('insertRow', {
                                    index: 0,
                                    row: obj.values
                                });
                            }



                            $that.find('input[type="text"], textarea').val('');
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

            $('#money<?php echo $key; ?>-edit-record form select[name="shop_contractor_id"]').change(function () {
                var id = $(this).val();

                if (id > 0) {
                    jQuery.ajax({
                        url: '/tax/shopcontract/list',
                        data: ({
                            'shop_contractor_id': (id),
                        }),
                        type: "POST",
                        success: function (data) {
                            var tmp = $('#money<?php echo $key; ?>-edit-record form select[name="shop_contract_id"]');
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
                }else{

                    var tmp = $('#money<?php echo $key; ?>-edit-record form select[name="shop_contract_id"]');
                    if (tmp.val() > 0) {
                        tmp.html('<option value="0" data-id="0">Без договора</option><option value="-1" data-id="1">Новый договор</option>');
                        tmp.val(0).trigger('change');
                    }
                }


                if(id < 0){
                    var tmp = $('#money<?php echo $key; ?>-edit-contractor');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 1);
                }else{
                    var tmp = $('#money<?php echo $key; ?>-edit-contractor');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 0);
                }
            });

            $('#money<?php echo $key; ?>-edit-record form select[name="shop_contract_id"]').change(function () {
                var id = $(this).val();

                if(id < 0){
                    var tmp = $('#money<?php echo $key; ?>-edit-contract');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_contract"]').attr('value', 1);
                }else{
                    var tmp = $('#money<?php echo $key; ?>-edit-contract');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_contract"]').attr('value', 0);
                }
            });
        });
    </script>
</div>