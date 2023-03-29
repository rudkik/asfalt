<div id="client-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование клиента</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/hotel/shopclient/save">
                <div class="modal-body pb0">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="old_id" class="col-3 col-form-label">ID 1C</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="old_id" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="ID 1C" id="old_id" type="text" value="<?php echo htmlspecialchars($data->values['old_id'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-3 col-form-label">ФИО</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="name" data-validation="length" data-validation-length="min3" maxlength="50" class="form-control valid" placeholder="ФИО" id="name" type="text" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-3 col-form-label">Телефон</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="phone" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="Телефон" id="phone" type="phone" value="<?php echo htmlspecialchars($data->values['phone'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bin" class="col-3 col-form-label">БИН</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="bin" data-validation="length" data-validation-length="max12" maxlength="12" class="form-control" placeholder="БИН" id="bin" type="text" value="<?php echo htmlspecialchars($data->values['bin'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="client-edit-bank_id" class="col-3 col-form-label">Банк / БИК</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="bank_id" id="client-edit-bank_id" class="form-control ks-select" data-parent="#client-edit-record" style="width: 100%">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo $siteData->globalDatas['view::bank/list/list']; ?>
                                    </select>
                                </div>
                                <input id="client-edit-bik" name="bik" data-validation="length" data-validation-length="max8" maxlength="8" class="form-control valid" placeholder="БИК" type="text" value="<?php echo htmlspecialchars($data->values['bik'], ENT_QUOTES);?>" style="display: none">
                                <input id="client-edit-bank" name="bank" data-validation="length" data-validation-length="max100" maxlength="100" class="form-control" placeholder="Банк" id="bank" type="text" value="<?php echo htmlspecialchars($data->values['bank'], ENT_QUOTES);?>" style="display: none">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="account" class="col-3 col-form-label">№ счета</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="account" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control" placeholder="№ счета" id="account" type="text" value="<?php echo htmlspecialchars($data->values['account'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-3 col-form-label">Адрес</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="address" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="Адрес" id="address" type="text" value="<?php echo htmlspecialchars($data->values['address'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
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
        $('#client-edit-record form').on('submit', function(e){
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
                        $('#client-edit-record').modal('hide');
                        $('#client-data-table').bootstrapTable('updateByUniqueId', {
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
        $('#client-edit-bank_id').change(function () {
            var bik = $(this).find('option:selected').data('bik');
            $('#client-edit-bik').val(bik).attr('value', bik);

            var name = $(this).find('option:selected').data('name');
            $('#client-edit-bank').val(name).attr('value', name);
        });
    });
</script>