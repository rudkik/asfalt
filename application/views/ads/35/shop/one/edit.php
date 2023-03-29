<div id="shop-edit-record" class="modal-edit">
    <div class="modal-dialog" style="margin: 0px; max-width: 700px">
        <div class="modal-content" style="border: none">
            <form class="has-validation-callback" action="/ads/shop/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="options-delivery_amount" class="col-3 col-form-label">Стоимость доставки за кг</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="options[delivery_amount]" class="form-control money-format" placeholder="Стоимость доставки за кг" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'options.delivery_amount', 0), ENT_QUOTES);?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
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
        $('#shop-edit-record form').on('submit', function(e){
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

