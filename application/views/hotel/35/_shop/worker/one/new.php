<div id="worker-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление персоны</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/hotel/shopworker/save">
            <div class="modal-body pb0">
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
                        <label for="iin" class="col-3 col-form-label">ИИН</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="iin" data-validation="length" data-validation-length="12" maxlength="12" class="form-control" placeholder="ИИН" id="iin" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date_of_birth" class="col-3 col-form-label">Дата рождения</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="date_of_birth" class="form-control" placeholder="Дата рождения" id="date_of_birth" type="datetime">
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
</div>
<script>
    $(document).ready(function () {
        __initTable();

        $('#worker-new-record input[type="datetime"]').datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y',
            timepicker:false,
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