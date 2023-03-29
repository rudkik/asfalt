<div id="product-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление товар/услугу</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopproduct/save">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group row">
                        <label for="name" class="col-3 col-form-label">Услуга?</label>
                        <div class="col-9 col-form-label" style="text-align: left;">
                            <input name="is_service" value="0" style="display: none">
                            <label class="ks-checkbox-slider ks-on-off ks-primary">
                                <input name="is_service" type="checkbox" value="1">
                                <span class="ks-indicator"></span>
                                <span class="ks-on">да</span>
                                <span class="ks-off">нет</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-3 col-form-label">Название</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <textarea data-validation="length" data-validation-length="min3" name="name" class="form-control valid" placeholder="Название" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-3 col-form-label">Цена</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input class="form-control money-format" placeholder="Цена" name="price" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit_name" class="col-3 col-form-label">Единица измерения</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input class="form-control units typeahead" placeholder="Единица измерения" name="unit_name" type="text">
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
            $('#product-new-record form').on('submit', function(e){
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
                            $('#product-new-record').modal('hide');
                            $('#product-data-table').bootstrapTable('insertRow', {
                                index: 0,
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