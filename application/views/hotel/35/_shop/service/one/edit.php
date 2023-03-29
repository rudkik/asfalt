<div id="service-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование услуги</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/hotel/shopservice/save">
                <div class="modal-body pb0">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="name" class="col-3 col-form-label">Название</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <textarea data-validation="length" data-validation-length="min3" name="name" class="form-control valid" placeholder="Название" ><?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-3 col-form-label">Цена</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="price" class="form-control valid" placeholder="Цена" value="<?php echo Func::getNumberStr($data->values['name'], FALSE);?>">
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
        $('#service-edit-record form').on('submit', function(e){
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
                        $('#service-edit-record').modal('hide');
                        $('#service-data-table').bootstrapTable('updateByUniqueId', {
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