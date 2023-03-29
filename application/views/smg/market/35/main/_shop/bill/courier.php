<div class="tab-pane active">
    <?php $siteData->titleTop = 'Заказы курьера'; ?>
    <?php
    $view = View::factory('smg/market/35/main/_shop/bill/filter/courier');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="body-table dataTables_wrapper ">
    <div class="box-body table-responsive" style="padding-top: 0px; border: none; overflow-x: hidden">
        <?php echo trim($data['view::_shop/bill/list/courier']); ?>
    </div>
</div>
<div id="modal-status" class="modal fade">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Статус</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-blue" style="margin: 0 0 20px;">Заказ №<span data-id="number"></span></h4>
                <h3 class="form-group"><b data-id="status"></b></h3>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Закрыть</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('[data-action="send-sms-bill"]').click(function (e) {
            e.preventDefault();

            var modal = $('#modal-status');
            modal.find('[data-id="number"]').text($(this).data('number'));

            jQuery.ajax({
                url: '/smg/kaspi/send_sms_bill',
                data: ({
                    'shop_bill_id': $(this).data('id'),
                }),
                type: "GET",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));
                    if(obj.status){
                        modal.find('[data-id="status"]')
                            .text('Код отправлен')
                            .addClass('text-blue')
                            .removeClass('text-red');
                    }else{
                        modal.find('[data-id="status"]')
                            .text('Ошибка. Код не отправлен')
                            .text('Ошибка. Код не подтвержден')
                            .addClass('text-red')
                            .removeClass('text-blue');
                    }

                    modal.modal('show');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });

        $('[data-action="completed-bill"]').click(function (e) {
            e.preventDefault();

            var modal = $('#modal-status');
            modal.find('[data-id="number"]').text($(this).data('number'));

            var parent = $(this).closest('[data-id="bill"]');

            jQuery.ajax({
                url: '/smg/kaspi/complete_bill',
                data: ({
                    'shop_bill_id': $(this).data('id'),
                    'secret_code': $(this).parent().parent().find('[name="secret-code"]').val(),
                }),
                type: "GET",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));
                    if(obj.status){
                        modal.find('[data-id="status"]')
                            .text('Код подтвержден')
                            .addClass('text-blue')
                            .removeClass('text-red');

                        parent.remove();
                    }else{
                        modal.find('[data-id="status"]')
                            .text('Ошибка. Код не подтвержден')
                            .addClass('text-red')
                            .removeClass('text-blue');
                    }

                    modal.modal('show');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });
    });
</script>
<style>
    .profile .user-info, .profile .user-info a {
        color: #111;
    }
</style>