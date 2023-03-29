<div id="confidant-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование доверенного лица</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopconfidant/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="name" class="col-3 col-form-label">ФИО</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="name" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="ФИО" id="name" type="text" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name_d" class="col-3 col-form-label">ФИО в дательном падеже</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="name_d" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="ФИО в дательном падеже" id="name_d" type="text" value="<?php echo htmlspecialchars($data->values['name_d'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="passport_number" class="col-3 col-form-label">№ удостоверения личности</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="passport_number" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="№ удостоверения личности" id="passport_number" type="text" value="<?php echo htmlspecialchars($data->values['passport_number'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="passport_date" class="col-3 col-form-label">Дата выдачи</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="passport_date" class="form-control valid" placeholder="Дата выдачи" id="passport_date" type="date" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['passport_date'], ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="passport_issued" class="col-3 col-form-label">Кем выдано</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="passport_issued" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="Кем выдано" id="passport_issued" type="text" value="<?php echo htmlspecialchars($data->values['passport_issued'], ENT_QUOTES);?>">
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
    <script>
        $(document).ready(function () {
            $.validate({
                modules : 'location, date, security, file',
                lang: 'ru',
                onModulesLoaded : function() {

                }
            });
            $('#confidant-edit-record form').on('submit', function(e){
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
                            $('#confidant-edit-record').modal('hide');
                            $('#confidant-data-table').bootstrapTable('updateByUniqueId', {
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
        });
    </script>
</div>