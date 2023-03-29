<div id="person-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление персоны</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopperson/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group row">
                        <label for="name" class="col-3 col-form-label">ФИО</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="name" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="ФИО" id="name" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name_d" class="col-3 col-form-label">ФИО в дательном падеже</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="name_d" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="ФИО в дательном падеже" id="name_d" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="number" class="col-3 col-form-label">№ удостоверения личности</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="number" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control" placeholder="№ удостоверения личности" id="number" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date_from" class="col-3 col-form-label">Дата выдачи</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="date_from" class="form-control" placeholder="Дата выдачи" id="date_from" type="datetime">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="issued_by" class="col-3 col-form-label">Кем выдано</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="issued_by" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="Кем выдано" id="issued_by" type="text">
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
            $.validate({
                modules : 'location, date, security, file',
                lang: 'ru',
                onModulesLoaded : function() {

                }
            });
            __initTable();

            $('#person-new-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            });

            $('#person-new-record form').on('submit', function(e){
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
                            $('#person-new-record').modal('hide');
                            $('#person-data-table').bootstrapTable('insertRow', {
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