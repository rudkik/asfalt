<div id="dialog-invoice-edit" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Изменить данные на</h4>
            </div>
            <form id="form-add-car" action="<?php echo Func::getFullURL($siteData, '/shopinvoice/invoice_break'); ?>" method="get" >
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Клиент
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-parent="#dialog-invoice-edit"
                                        data-attorney="#modal_shop_client_attorney_id" data-contract="#modal_shop_client_contract_id"
                                        data-cache="<?php echo $data->values['balance_cache']; ?>"
                                        id="modal_shop_client_id" name="shop_client_id_to" class="form-control select2" style="width: 100%" disabled>
                                    <option value="<?php echo $data->values['id']; ?>" selected><?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?></option>
                                </select>
                                <span class="input-group-btn"> <a class="btn btn-flat"><b id="client-amount" class="text-navy"></b></a></span>
                            </div>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>Доверенность</label>
                        </div>
                        <div class="col-md-9">
                            <select data-contract="#modal_shop_client_contract_id" id="modal_shop_client_attorney_id" name="shop_client_attorney_id_to"  data-parent="#dialog-invoice-edit"
                                    data-amount="<?php if (Request_RequestParams::getParamInt('shop_client_attorney_id') > 0) {echo $data->values['balance'];}else{$data->values['balance_cache'];} ?>"
                                    class="form-control select2" required style="width: 100%;">
                                <option value="0" data-id="0">Наличными</option>
                                <?php echo $siteData->globalDatas['view::_shop/client/attorney/list/option']; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>Договор</label>
                        </div>
                        <div class="col-md-9">
                            <select id="modal_shop_client_contract_id" name="shop_client_contract_id_to" class="form-control select2" data-parent="#dialog-invoice-edit" required style="width: 100%;">
                                <option value="0" data-id="0">Без договора</option>
                                <?php echo $siteData->globalDatas['view::_shop/client/contract/list/list']; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Для суммы
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input data-type="money" data-fractional-length="2" id="amount" name="amount" type="text" class="form-control" placeholder="Для суммы">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Для количества
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="form-control" placeholder="Для количества">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <input name="shop_invoice_id" value="<?php echo Request_RequestParams::getParamInt('shop_invoice_id'); ?>" style="display: none">
                    <input name="shop_product_id" value="<?php echo Request_RequestParams::getParamInt('shop_product_id'); ?>" style="display: none">
                    <input name="shop_branch_id" value="<?php echo $siteData->shopID; ?>" style="display: none">
                    <button type="submit" class="btn btn-primary">Перенести</button>
                </div>
            </form>
        </div>
    </div>
</div>