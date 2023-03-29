<div id="consumable-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление расходника</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/hotel/shopconsumable/save">
            <div class="modal-body pb0">
                <div class="container-fluid">
                    <div class="row">
                        <label for="number" class="col-2 col-form-label">Номер</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group margin-0">
                                        <input name="number" class="form-control" placeholder="Номер" id="number" type="text">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <label for="amount" class="col-4 col-form-label">Сyмма</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <input name="amount" data-decimals="2" class="form-control money-format" placeholder="Сyмма" id="amount" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="date" class="col-2 col-form-label">Корреспондирующий счёт</label>
                        <div class="col-10">
                            <select name="code" id="consumable-new-code" class="form-control ks-select" data-parent="#consumable-new-record" style="width: 100%">
                                <option value="1021" data-id="1021">1021</option>
                                <option value="3510" data-id="3510">3510</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label for="from_at" class="col-2 col-form-label">Период от</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group margin-0">
                                        <input name="from_at" class="form-control" id="from_at" type="datetime">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <label for="to_at" class="col-4 col-form-label">Период до</label>
                                        <div class="col-8">
                                            <div class="form-group margin-0">
                                                <input name="to_at" class="form-control"  id="to_at" type="datetime">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="created_at" class="col-2 col-form-label">Дата создания</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group margin-0">
                                        <input name="created_at" class="form-control" id="created_at" type="datetime">
                                    </div>
                                </div>
                                <div class="col-8">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="extradite" class="col-2 col-form-label">Выдать</label>
                        <div class="col-10">
                            <div class="form-group margin-0">
                                <input name="extradite" class="form-control valid" placeholder="Выдать" id="extradite" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="base" class="col-2 col-form-label">Основание</label>
                        <div class="col-10">
                            <textarea name="base" class="form-control" placeholder="Основание"></textarea>
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

        $('#consumable-new-record input[type="datetime"]').datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y',
            timepicker:false,
        });
        $('#consumable-new-record form').on('submit', function(e){
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
                        $('#consumable-new-record').modal('hide');
                        $('#consumable-data-table').bootstrapTable('insertRow', {
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
        $('#consumable-new-bank_id').change(function () {
            var bik = $(this).find('option:selected').data('bik');
            $('#consumable-new-bik').val(bik).attr('value', bik);

            var name = $(this).find('option:selected').data('name');
            $('#consumable-new-bank').val(name).attr('value', name);
        });
    });
</script>