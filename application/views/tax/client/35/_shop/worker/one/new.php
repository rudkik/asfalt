<div id="worker-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление сотрудника</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopworker/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group row">
                        <label for="name" class="col-2 col-form-label">ФИО</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <input name="name" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="ФИО" id="name" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name_d" class="col-2 col-form-label">ФИО в дательном падеже</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <input name="name_d" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="ФИО в дательном падеже" id="name_d" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="position" class="col-2 col-form-label">Должность</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <input name="position" class="form-control" placeholder="Должность" id="position" type="text">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="date_of_birth" class="col-4 col-form-label">Дата рождения</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <input name="date_of_birth" class="form-control" placeholder="Дата рождения" id="date_of_birth" type="datetime" date-type="date" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="number" class="col-2 col-form-label">№ удостоверения личности</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <input name="number" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control" placeholder="№ удостоверения личности" id="number" type="text">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="iin" class="col-4 col-form-label">ИИН</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <input name="iin" data-validation="length" data-validation-length="12" maxlength="12" class="form-control" placeholder="ИИН" id="iin" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="date_from" class="col-2 col-form-label">Дата выдачи</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <input name="date_from" class="form-control" placeholder="Дата выдачи" id="date_from" type="datetime" date-type="date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="issued_by" class="col-4 col-form-label">Кем выдано</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <input name="issued_by" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="Кем выдано" id="issued_by" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="wage_basic" class="col-2 col-form-label">Оклад</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <input name="wage_basic" class="form-control money-format" placeholder="Оклад" id="wage_basic" type="text" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="worker-wage-new-worker_status_id" class="col-4 col-form-label">Статус</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <select name="worker_status_id" id="worker-new-worker_status_id" class="form-control ks-select" data-parent="#worker-new-record" style="width: 100%">
                                                    <option value="0" data-id="0">Без статуса</option>
                                                    <?php echo $siteData->globalDatas['view::workerstatus/list/list']; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="date_work_from" class="col-2 col-form-label">Дата приема на работу</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <input name="date_work_from" class="form-control" id="date_work_from" type="datetime" data-type="date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="date_work_to" class="col-4 col-form-label">Дата увольнения</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <input name="date_work_to" class="form-control" id="date_from" type="datetime" data-type="date" autocomplete="off">
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

            $('#worker-new-record form').on('submit', function(e){
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
                            $('#worker-new-record').modal('hide');
                            $('#worker-data-table').bootstrapTable('insertRow', {
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