<div id="attorney-new-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление доверенности</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/tax/shopattorney/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="number" class="col-3 col-form-label">Номер</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="number" data-validation="length" data-validation-length="max50" maxlength="50" class="form-control valid" placeholder="Номер" id="number" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shop_contractor_id" class="col-3 col-form-label">Контрагент</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <select name="shop_contractor_id" id="sshop_contractor_id" class="form-control ks-select" data-parent="#attorney-new-record" style="width: 100%">
                                        <option value="0" data-id="0">Без контрагента</option>
                                        <?php echo $siteData->globalDatas['view::_shop/contractor/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-3 col-form-label">На кого выписана</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="name" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control valid" placeholder="ФИО на кого выписана" id="name" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date_from" class="col-3 col-form-label">Дата начала</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="date_from" class="form-control" placeholder="Дата начала" id="date_from" type="datetime" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date_to" class="col-3 col-form-label">Дата окончания</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="date_to" class="form-control" placeholder="Дата окончания" id="date_to" type="datetime" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-3 col-form-label">Примечание</label>
                            <div class="col-9">
                                <textarea name="text" class="form-control" placeholder="Примечание"></textarea>
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

            $('#attorney-new-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            }).inputmask({
                mask: "99.99.9999"
            });

            $('#attorney-new-record form').on('submit', function(e){
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
                            $('#attorney-new-record').modal('hide');
                            $('#attorney-data-table').bootstrapTable('insertRow', {
                                index: 0,
                                row: obj.values
                            });

                            $.notify("Запись добавлена");
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