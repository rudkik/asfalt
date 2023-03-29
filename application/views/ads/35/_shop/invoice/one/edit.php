<div id="invoice-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование клиента</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/ads/shopinvoice/save">
                <div class="modal-body pb0">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="shop_parcel_id" class="col-3 col-form-label">№ посылки</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input data-client-name="#invoice-edit-record-shop_client_name" data-client-id="#invoice-edit-record-shop_client_id" name="shop_parcel_id" class="form-control parcels typeahead" id="shop_parcel_id" type="text" value="<?php echo $data->values['shop_parcel_id']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shop_client_name" class="col-3 col-form-label">Клиент</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input data-client="#invoice-edit-record-shop_client_id" data-id="shop_client_name" class="form-control clients typeahead" id="invoice-edit-record-shop_client_name" type="text" value="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', ''); ?>">
                                </div>
                                <input id="invoice-edit-record-shop_client_id" name="shop_client_id" value="<?php echo $data->values['shop_client_id']; ?>" style="display: none">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-3 col-form-label">Сумма</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input data-decimals="2" name="amount" class="form-control money-format" placeholder="Сумма" id="amount" type="text" value="<?php echo Func::getNumberStr($data->values['amount']);?>">
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
        $('#invoice-edit-record form').on('submit', function(e){
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
                        $('#invoice-edit-record').modal('hide');
                        $('#invoice-data-table').bootstrapTable('updateByUniqueId', {
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
        $('#invoice-edit-bank_id').change(function () {
            var bik = $(this).find('option:selected').data('bik');
            $('#invoice-edit-bik').val(bik).attr('value', bik);

            var name = $(this).find('option:selected').data('name');
            $('#invoice-edit-bank').val(name).attr('value', name);
        });
    });
</script>