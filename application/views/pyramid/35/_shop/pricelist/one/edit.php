<div id="pricelist-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование прайс-листа</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/pyramid/shoppricelist/save">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="pricelist-edit-name" class="col-3 col-form-label">Название</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="name" data-validation="length" data-validation-length="max100" maxlength="100" class="form-control valid" placeholder="Название" id="name" type="text" value="<?php echo $data->values['name']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="date_from" class="col-3 col-form-label">Дата начала</label>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group margin-0">
                                            <input name="date_from" class="form-control" id="date_from" type="datetime" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <label for="date" class="col-3 col-form-label">Дата окончания</label>
                                            <div class="col-9">
                                                <div class="form-group margin-0">
                                                    <input name="date_to" class="form-control" id="date_to" type="datetime" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <?php echo $siteData->globalDatas['view::_shop/pricelist/item/list/index']; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if ($siteData->action != 'clone'){ ?>
                        <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                    <?php } ?>
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            __initTable();

            $('#pricelist-edit-record input[type="datetime"]').datetimepicker({
                dayOfWeekStart : 1,
                lang:'ru',
                format:	'd.m.Y',
                timepicker:false,
            }).inputmask({
                mask: "99.99.9999"
            });

            $('#pricelist-edit-record form').on('submit', function(e){
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
                            $('#pricelist-edit-record').modal('hide');

                            if ('<?php echo $siteData->action; ?>' != 'clone') {
                                $('#pricelist-data-table').bootstrapTable('updateByUniqueId', {
                                    id: obj.values.id,
                                    row: obj.values
                                });
                            }else{
                                $('#pricelist-data-table').bootstrapTable('insertRow', {
                                    index: 0,
                                    row: obj.values
                                });
                            }

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