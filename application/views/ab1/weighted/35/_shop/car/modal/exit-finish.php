<div id="dialog-exit-finish" class="modal">
    <div class="modal-dialog" style="max-width: 600px; width: 100%">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0097bc;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Взвесить машину</h4>
            </div>
            <div class="modal-body">
                <div class="box-body input-size-18">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Номер машины</label>
                                <input class="form-control text-number" name="name" data-type="auto-number" placeholder="Номер машины" type="text">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Клиент</label>
                                <input class="form-control" name="client-name" placeholder="Клиент" type="text" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Водитель</label>
                                <input class="form-control text-number" name="shop_driver_name" placeholder="Водитель" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Транспортная компания</label>
                                <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" required style="width: 100%;">
                                    <option value="0" data-id="0">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/transport/company/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="packed-tare">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Количество фасованной тары</label>
                                <input class="form-control" name="packed_count" placeholder="Количество фасованной тары" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Брутто</label>
                                <input class="form-control" name="brutto" placeholder="Брутто" type="text" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Тара</label>
                                <input class="form-control" name="tarra" placeholder="Тара" type="text" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Нетто</label>
                                <input class="form-control text-number" name="netto" placeholder="Нетто" type="text" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Просыпал</label>
                                <input class="form-control" name="spill" placeholder="Просыпал" type="text">
                            </div>
                        </div>
                    </div>
                    <div id="is_not_overload" class="row">
                        <div class="col-md-12">
                            <p class="text-red" style="margin: 0px">Не перегружать: <b name="quantity"></b></p>
                        </div>
                    </div>
                    <input name="id" style="display: none">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary pull-right" onclick="sendBrutto()">Зафиксировать</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#dialog-exit-finish #packed-tare input[name="packed_count"]').change(function () {
            var count = $(this).valNumber() * Number($(this).data('tare'));

            var netto = $('#dialog-exit-finish input[name="netto"]');
            netto.valNumber(
                $('#dialog-exit-finish input[name="brutto"]').valNumber()
                - $('#dialog-exit-finish input[name="tarra"]').valNumber()
                - count,
                3
            )
        }).trigger('change');
    });
</script>