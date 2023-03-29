<div id="operation-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление оператора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/pyramid/shopoperation/save">
            <div class="modal-body pb0">
                <div class="container-fluid">
                    <div class="form-group row">
                        <label for="shop_table_rubric_id" class="col-3 col-form-label">Вид оператора</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <select name="shop_table_rubric_id" id="operation-new-shop_table_rubric_id" class="form-control ks-select" data-parent="#operation-new-record" style="width: 100%">
                                    <option value="1" data-id="1">Администратор</option>
                                    <option value="2" data-id="2" selected>Оператор Кара Далы</option>
                                    <option value="3" data-id="3">Оператор Асфальтобетон</option>
                                    <option value="4" data-id="4">Просмотр</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-3 col-form-label">ФИО</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="name" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="ФИО" id="name" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-3 col-form-label">E-mail</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="email" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="E-mail" id="email" type="email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-3 col-form-label">Пароль</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="password" class="form-control" placeholder="Пароль" id="password" type="password">
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

        $.validate({
            modules : 'location, date, security, file',
            lang: 'ru',
            onModulesLoaded : function() {

            }
        });

        $('#operation-new-record form').on('submit', function(e){
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
                        $('#operation-new-record').modal('hide');
                        $('#operation-data-table').bootstrapTable('insertRow', {
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