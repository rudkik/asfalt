<div id="parcel-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление посылки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/ads/shopparcel/save">
            <div class="modal-body pb0">
                <div class="container-fluid">
                    <div class="form-group row">
                        <label for="shop_client_name" class="col-3 col-form-label">Клиент</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input data-client="#parcel-new-shop_client_id" data-id="shop_client_name" class="form-control clients typeahead" id="shop_client_name" type="text">
                            </div>
                            <input id="parcel-new-shop_client_id" name="shop_client_id" value="0" style="display: none">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tracker" class="col-3 col-form-label">Трекинг ID</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="tracker" class="form-control" placeholder="Трекинг ID" id="tracker" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-3 col-form-label">Цена посылки</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input data-decimals="2" name="price" class="form-control money-format" placeholder="Цена посылки" id="price" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="text" class="col-3 col-form-label">Описание посылки</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="text" class="form-control" placeholder="Описание посылки" id="text" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="weight" class="col-3 col-form-label">Вес посылки (мин. 1 кг)</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input id="parcel-new-weight" data-decimals="2" name="weight" class="form-control money-format" placeholder="Вес посылки" id="weight" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="parcel-new-parcel_status_id" class="col-3 col-form-label">Статус</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <select name="parcel_status_id" id="parcel-new-parcel_status_id" class="form-control ks-select" data-parent="#parcel-new-record" style="width: 100%">
                                    <option value="0" data-id="0">Выберите статус</option>
                                    <option value="<?php echo Model_Ads_ParcelStatus::PARCEL_STATUS_IN_STOCK; ?>" data-id="<?php echo Model_Ads_ParcelStatus::PARCEL_STATUS_IN_STOCK; ?>">Hа складе</option>
                                    <option value="<?php echo Model_Ads_ParcelStatus::PARCEL_STATUS_SEND; ?>" data-id="<?php echo Model_Ads_ParcelStatus::PARCEL_STATUS_SEND; ?>">Отправлено</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="parcel-new-delivery_type_id" class="col-3 col-form-label">Доставка</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <select name="delivery_type_id" id="parcel-new-delivery_type_id" class="form-control ks-select" data-parent="#parcel-new-record" style="width: 100%">
                                    <option value="0" data-id="0">Выберите доставку</option>
                                    <?php echo $siteData->globalDatas['view::delivery-type/list/list'];?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-3 col-form-label">Стоимость доставки</label>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group margin-0">
                                        <input name="amount" id="parcel-new-amount" data-amount="0" class="form-control money-format" data-decimals="2" type="text">
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="row">
                                                <label class="col-7 col-form-label">Выставлена в счетах</label>
                                                <div class="col-5">
                                                    <div class="form-group margin-0">
                                                        <input class="form-control money-format" data-decimals="2" type="text" value="0" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="row">
                                                <label class="col-5 col-form-label">Оплачено</label>
                                                <div class="col-7">
                                                    <div class="form-group margin-0">
                                                        <input class="form-control money-format" data-decimals="2" type="text" value="0" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            $.validate({
                modules : 'location, date, security, file',
                lang: 'ru',
                onModulesLoaded : function() {

                }
            });
            $('#parcel-new-shop_client_id, #parcel-new-weight').change(function () {
                if($('#parcel-new-amount').data('amount') != 10) {
                    var amount = $('#parcel-new-shop_client_id').data('delivery-amount');
                    if (!(amount > 0)) {
                        amount = <?php echo Arr::path($siteData->shop->getOptionsArray(), 'delivery_amount', 0) *1; ?>;
                    }

                    var weight = $('#parcel-new-weight').val();
                    if (weight < 1){
                        weight = 1;
                    }

                    $('#parcel-new-amount').val(amount * weight);
                }
            });

            $('#parcel-new-record form').on('submit', function(e){
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
                            $('#parcel-new-record').modal('hide');
                            $('#parcel-data-table').bootstrapTable('insertRow', {
                                index: 0,
                                row: obj.values
                            });
                            $that.find('input[type="text"], input[type="date"], textarea').val('');
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
        });
    </script>
</div>