<div id="bill-cancel-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" style="max-width: 300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Код брони: <b><?php echo $data->id; ?></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/hotel/shopbill/cancel">
                <div class="modal-body pb0" style="padding-top: 5px;">
                    <?php
                    $isFinish = Arr::path($data->values, 'paid_amount', '0') > 0.001;
                    if($isFinish && $siteData->operation->getShopTableRubricID() != 1){ ?>
                        <h5 style="margin: 15px 0px; font-weight: 400;">Нельзя отменить оплаченную заявку.</h5>
                    <?php }else{?>
                        <?php
                        $isFinish = Arr::path($data->values, 'is_finish', '0') == 1;
                        if($isFinish){ ?>
                            <h5 style="margin: 15px 0px; font-weight: 400;">Нельзя отменить заявку после того, как клиент отдохнул.</h5>
                        <?php }else{?>
                        <div class="form-group">
                            <label>Статус</label>
                            <select name="bill_cancel_status_id" id="bill-cancel-bill_cancel_status_id" class="form-control ks-select" data-parent="#bill-cancel-record" data-parent="#bill-cancel-record" style="width: 100%">
                                <option value="0" data-id="0">Введите причину отказа</option>
                                <?php echo $siteData->globalDatas['view::bill-cancel-status/list/list']; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Примечание</label>
                            <textarea name="text" class="form-control" placeholder="Примечание"></textarea>
                        </div>
                        <?php }?>
                    <?php }?>
                </div>
                <div class="modal-footer" style="display: block;">
                    <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                    <?php if(!$isFinish){?>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <?php }?>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            __initTable();
            $('#bill-cancel-record form').on('submit', function(e){
                e.preventDefault();
                if ($('#bill-cancel-bill_cancel_status_id').val() < 1){
                    return false;
                }
                var id = $('#bill-cancel-record [name="id"]').val();

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
                        $('#bill-cancel-record').modal('hide');
                        $('#bill-data-table').bootstrapTable('removeByUniqueId', id);

                        $.notify('Бронь №<b>'+id+'</b> отменена.');
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