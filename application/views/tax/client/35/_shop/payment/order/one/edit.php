<div id="payment-order-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование платежного поручения</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shoppaymentorder/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <label for="number" class="col-3 col-form-label">Номер</label>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group margin-0">
                                            <input name="number" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control valid" placeholder="Номер" id="number" type="text"<?php if ($siteData->action == 'edit'){ ?> value="<?php echo $data->values['number']; ?>"<?php } ?>>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <label for="amount" class="col-4 col-form-label">Сумма</label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input data-id="sum-total" name="amount" class="form-control money-format" placeholder="Сумма" id="amount" type="text" value="<?php echo Func::getNumberStr($data->values['amount'], FALSE); ?>" <?php if ($data->values['is_items'] == 1){ echo 'readonly';} ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <label for="date" class="col-3 col-form-label">Дата</label>
                                            <div class="col-9">
                                                <div class="form-group margin-0">
                                                    <input name="date" data-validation="length" class="form-control" placeholder="Дата" id="date" type="datetime" autocomplete="off" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(Arr::path($siteData->shop->getRequisitesArray(), 'is_many_bank_account', FALSE)){ ?>
                            <div class="form-group row">
                                <label for="payment-order-edit-shop_bank_account_id" class="col-2 col-form-label">Банковский счет</label>
                                <div class="col-10">
                                    <div class="form-group margin-0">
                                        <select name="shop_bank_account_id" id="payment-order-edit-shop_bank_account_id" class="form-control ks-select" data-parent="#payment-order-edit-record" data-parent="#payment-order-edit-record" style="width: 100%">
                                            <?php echo $siteData->globalDatas['view::_shop/bank/account/list/list']; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <input class="form-group row" name="shop_bank_account_id" value="<?php if($data->values['shop_bank_account_id'] > 0){echo $data->values['shop_bank_account_id'];}else{echo intval(Arr::path($siteData->shop->getRequisitesArray(), 'shop_bank_account_id', 0));} ?>" style="display: none">
                        <?php } ?>
                        <?php if($data->values['authority_id'] > 0){ ?>
                            <div class="form-group row">
                                <label for="payment-order-edit-authority_id" class="col-3 col-form-label">Налоговый коммитет</label>
                                <div class="col-9">
                                    <div class="form-group margin-0">
                                        <select name="authority_id" id="payment-order-edit-authority_id" class="form-control ks-select" data-parent="#payment-order-edit-record" style="width: 100%">
                                            <?php echo $siteData->globalDatas['view::authority/list/list'];?>
                                        </select>
                                        <input name="gov_contractor_id" value="<?php echo $data->values['gov_contractor_id']; ?>" style="display:none;">
                                    </div>
                                </div>
                            </div>
                        <?php }elseif ($data->values['gov_contractor_id'] > 0){ ?>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Бенефициар</label>
                                <div class="col-9">
                                    <div class="form-group margin-0">
                                        <input class="form-control" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.gov_contractor_id.name', ''), ENT_QUOTES); ?>" readonly>
                                        <input name="gov_contractor_id"  value="<?php echo $data->values['gov_contractor_id']; ?>" style="display:none;">
                                    </div>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div class="form-group row">
                                <label for="payment-order-edit-shop_contractor_id" class="col-3 col-form-label">Контрагент</label>
                                <div class="col-9">
                                    <div class="form-group margin-0">
                                        <div class="input-group">
                                            <select name="shop_contractor_id" id="payment-order-edit-shop_contractor_id" class="form-control ks-select" data-parent="#payment-order-edit-record" style="width: 100%">
                                                <option value="0" data-id="0">Без контрагента</option>
                                                <option value="-1" data-id="-1">Новый контратент</option>
                                                <?php echo $siteData->globalDatas['view::_shop/contractor/list/list'];?>
                                            </select>
                                            <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" data-select="#payment-order-edit-shop_contractor_id" data-action="add-new-panel">Добавить</button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $view = View::factory('tax/client/35/_shop/contractor/one/new-panel');
                            $view->siteData = $siteData;
                            $view->data = $data;
                            $view->panelID = 'payment-order-edit-contractor';
                            $view->selectID = 'payment-order-edit-shop_contractor_id';
                            echo Helpers_View::viewToStr($view);
                            ?>
                        <?php } ?>
                        <div class="form-group row">
                            <label for="payment-order-edit-kbe_id" class="col-3 col-form-label">КБе</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="kbe_id" id="payment-order-edit-kbe_id" class="form-control ks-select" data-parent="#payment-order-edit-record" style="width: 100%">
                                        <?php echo $siteData->globalDatas['view::kbe/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="payment-order-edit-knp_id" class="col-3 col-form-label">Код назначения платежа</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="knp_id" id="payment-order-edit-knp_id" class="form-control ks-select" data-parent="#payment-order-edit-record" style="width: 100%">
                                        <?php echo $siteData->globalDatas['view::knp/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="payment-order-edit-kbk_id" class="col-3 col-form-label">Код бюджетной классификации</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="kbk_id" id="payment-order-edit-kbk_id" class="form-control ks-select" data-parent="#payment-order-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::kbk/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-3 col-form-label">Назначение платежа</label>
                            <div class="col-9">
                                <textarea name="text" class="form-control" placeholder="Назначение платежа"><?php echo $data->values['text']; ?></textarea>
                            </div>
                        </div>
                        <?php if ($data->values['is_items'] == 1){?>
                            <div class="form-group row">
                                <?php echo $siteData->globalDatas['view::_shop/payment/order/item/list/index']; ?>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if ($siteData->action != 'clone'){ ?>
                        <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                    <?php }else{ ?>
                        <input name="is_items" value="<?php echo $data->values['is_items']; ?>" style="display: none">
                    <?php } ?>
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            __initTable();

            $('#payment-order-edit-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            }).inputmask({
                mask: "99.99.9999"
            });

            $('#payment-order-edit-record form').on('submit', function(e){
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
                            $('#payment-order-edit-record').modal('hide');

                            if ('<?php echo $siteData->action; ?>' != 'clone') {
                                $('#payment-order-data-table').bootstrapTable('updateByUniqueId', {
                                    id: obj.values.id,
                                    row: obj.values
                                });
                            }else{
                                $('#payment-order-data-table').bootstrapTable('insertRow', {
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

            $('#payment-order-edit-record form select[name="shop_contractor_id"]').change(function () {
                var id = $(this).val();
                if(id < 0){
                    var tmp = $('#payment-order-edit-contractor');
                    tmp.css('display', 'block');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 1);
                }else{
                    var tmp = $('#payment-order-edit-contractor');
                    tmp.css('display', 'none');
                    tmp.find('input[name="is_add_contractor"]').attr('value', 0);
                }
            });
        });
    </script>
</div>