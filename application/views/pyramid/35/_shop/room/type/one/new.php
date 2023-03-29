<div id="room-type-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 750px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление группы</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/pyramid/shoproomtype/save">
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
                    <label for="price" class="col-2 col-form-label">Стоимость номера</label>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group margin-0">
                                    <input name="price" class="form-control money-format" placeholder="Стоимость номера" id="price" type="text">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <label for="price_feast" class="col-4 col-form-label">Стоимость номера в выходные дни</label>
                                    <div class="col-8">
                                        <div class="form-group margin-0">
                                            <input name="price_feast" class="form-control money-format" placeholder="Стоимость номера в выходные и праздничные дни" id="price" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="number" class="col-2 col-form-label">Кол-во мест</label>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group margin-0">
                                    <input name="human" class="form-control money-format valid" placeholder="Кол-во мест" id="human" type="text">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <label for="number_extra" class="col-4 col-form-label">Кол-во доп. мест</label>
                                    <div class="col-8">
                                        <div class="form-group margin-0">
                                            <input name="human_extra" class="form-control money-format valid" placeholder="Кол-во дополнительных мест" id="human_extra" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="price_extra" class="col-2 col-form-label">Стоимость одного доп. <b>взрослого</b></label>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group margin-0">
                                    <input name="price_extra" class="form-control money-format" placeholder="Стоимость одного дополнительного взрослого места" id="price_extra" type="text">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <label for="price_child" class="col-4 col-form-label money-format">Стоимость одного доп. <b>детского</b></label>
                                    <div class="col-8">
                                        <div class="form-group margin-0">
                                            <input name="price_child" class="form-control" placeholder="Стоимость одного дополнительного детского места" id="price_child" type="text">
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

        $('#room-type-new-record form').on('submit', function(e){
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
                        $('#room-type-new-record').modal('hide');
                        $('#room-type-data-table').bootstrapTable('insertRow', {
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