<div id="feast-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 750px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление праздничных дней</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/hotel/shopfeast/save">
            <div class="modal-body pb0">
                <div class="container-fluid">
                    <div class="form-group row">
                        <label for="name" class="col-2 col-form-label">Название</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <input name="name" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="Название" id="name" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="date_from" class="col-2 col-form-label">Начало</label>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group margin-0">
                                    <input name="date_from" class="form-control" id="date_from" type="datetime">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <label for="date_to" class="col-4 col-form-label">Окончание</label>
                                    <div class="col-8">
                                        <div class="form-group margin-0">
                                            <input name="date_to" class="form-control" id="date_to" type="datetime">
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
</div>
<script>
    $(document).ready(function () {
        __initTable();

        $('#feast-new-record input[type="datetime"]').datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y',
            timepicker:false,
        });

        $('#feast-new-record form').on('submit', function(e){
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
                        $('#feast-new-record').modal('hide');
                        $('#feast-data-table').bootstrapTable('insertRow', {
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