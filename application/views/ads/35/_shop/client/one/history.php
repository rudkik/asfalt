<div id="client-history-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">История клиента</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <div class="has-validation-callback">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Клиент</label>
                            <div class="col-10">
                                <input name="name" data-validation="length" class="form-control" placeholder="Клиент" id="name" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Телефон</label>
                            <div class="col-10">
                                <input name="phone" data-validation="length" class="form-control" placeholder="Телефон" id="phone" type="text" value="<?php echo htmlspecialchars(Arr::path($data->values, 'phone', ''), ENT_QUOTES); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-form-label text-left">Посылки</label>
                        </div>
                        <div  class="form-group row">
                            <?php echo $siteData->globalDatas['view::_shop/parcel/list/history']; ?>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-form-label text-left">Счета на оплату</label>
                        </div>
                        <div class="form-group row">
                            <?php echo $siteData->globalDatas['view::_shop/invoice/list/history']; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            __initTable();
        });
    </script>
</div>