<div id="parcel-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование посылки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/ads/shopparcel/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="shop_client_name" class="col-3 col-form-label">Клиент</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input data-client="#parcel-edit-shop_client_id" data-id="shop_client_name" class="form-control clients typeahead" id="shop_client_name" type="text" value="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', ''); ?>">
                                </div>
                                <input id="parcel-edit-shop_client_id" name="shop_client_id" value="<?php echo $data->values['shop_client_id']; ?>" style="display: none">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tracker" class="col-3 col-form-label">Трекинг ID</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="tracker" class="form-control" placeholder="Трекинг ID" id="tracker" type="text" value="<?php echo htmlspecialchars($data->values['tracker'], ENT_QUOTES); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-3 col-form-label">Цена посылки</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input data-decimals="2" name="price" class="form-control money-format" placeholder="Цена посылки" id="price" type="text" value="<?php echo htmlspecialchars(floatval($data->values['price']), ENT_QUOTES); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-3 col-form-label">Описание посылки</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="text" class="form-control" placeholder="Описание посылки" id="text" type="text" value="<?php echo htmlspecialchars($data->values['text'], ENT_QUOTES); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="weight" class="col-3 col-form-label">Вес посылки (мин. 1 кг)</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input id="parcel-edit-weight" data-decimals="2" name="weight" class="form-control money-format" placeholder="Вес посылки" id="weight" type="text" value="<?php echo htmlspecialchars(floatval($data->values['weight']), ENT_QUOTES); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="parcel-edit-parcel_status_id" class="col-3 col-form-label">Статус</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="parcel_status_id" id="parcel-edit-parcel_status_id" class="form-control ks-select" data-parent="#parcel-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Выберите статус</option>
                                        <?php echo $siteData->globalDatas['view::parcel-status/list/list'];?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="parcel-edit-delivery_type_id" class="col-3 col-form-label">Доставка</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="delivery_type_id" id="parcel-edit-delivery_type_id" class="form-control ks-select" data-parent="#parcel-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Выберите доставку</option>
                                        <?php echo $siteData->globalDatas['view::delivery-type/list/list'];?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php $addresses = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.addresses', array()); ?>
                        <div class="form-group row">
                            <label for="parcel-edit-address" class="col-3 col-form-label">Адрес</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="address" id="parcel-edit-address" class="form-control ks-select" data-parent="#parcel-edit-record" style="width: 100%">
                                        <?php if (count($addresses) > 0){  ?>
                                            <?php
                                            foreach ($addresses as $address){
                                                $s = Arr::path($address, 'land_name', '').', '
                                                    . Arr::path($address, 'city_name', '').', '
                                                    . Arr::path($address, 'address', '');

                                                $value = 'value="'.$s.'""';
                                                if($s == $data->values['address']){
                                                    $value = $value . ' selected';
                                                }
                                                ?>
                                                <option <?php echo $value; ?>><?php echo $s; ?></option>
                                            <?php } ?>
                                        <?php } else{ ?>
                                            <option value="">Адрес клиентом не задан</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-2 col-form-label">Стоимость доставки</label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group margin-0">
                                            <input  name="amount" id="parcel-edit-amount" data-amount="0" class="form-control money-format" data-decimals="2" type="text" value="<?php echo Func::getNumberStr($data->values['amount']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-7">
                                                <div class="row">
                                                    <label class="col-7 col-form-label">Выставлена в счетах</label>
                                                    <div class="col-5">
                                                        <div class="form-group margin-0">
                                                            <input class="form-control money-format" data-decimals="2" type="text" value="<?php echo Func::getNumberStr($data->values['invoice_amount']); ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="row">
                                                    <label class="col-3 col-form-label">Оплачено</label>
                                                    <div class="col-9">
                                                        <div class="form-group margin-0">
                                                            <input class="form-control money-format" data-decimals="2" type="text" value="<?php echo Func::getNumberStr($data->values['paid_amount']); ?>" readonly>
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
                    <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                </div>
            </form>
        </div>
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

        $('#parcel-edit-shop_client_id, #parcel-edit-weight').change(function () {
            if($('#parcel-edit-amount').data('amount') != 10) {
                var amount = $('#parcel-edit-shop_client_id').data('delivery-amount');
                if (!(amount > 0)) {
                    amount = <?php echo Arr::path($siteData->shop->getOptionsArray(), 'delivery_amount', 0) *1; ?>;
                }

                var weight = $('#parcel-edit-weight').val();
                if (weight < 1){
                    weight = 1;
                }

                $('#parcel-edit-amount').val(amount * weight);
            }
        });
        $('#parcel-edit-record form').on('submit', function(e){
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
                        $('#parcel-edit-record').modal('hide');
                        $('#parcel-data-table').bootstrapTable('updateByUniqueId', {
                                id: obj.values.id,
                                row: obj.values
                        });

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
        $('#parcel-edit-bank_id').change(function () {
            var bik = $(this).find('option:selected').data('bik');
            $('#parcel-edit-bik').val(bik).attr('value', bik);

            var name = $(this).find('option:selected').data('name');
            $('#parcel-edit-bank').val(name).attr('value', name);
        });
    });
</script>