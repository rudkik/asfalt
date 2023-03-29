<div id="modal-client-invoice" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Документы <b><?php echo $data->values['name']; ?></b> за <b><?php echo Helpers_DateTime::getPeriodRus(Request_RequestParams::getParamDate('date_from_equally'), Request_RequestParams::getParamDate('date_to'));?></b></h4>
            </div>
            <div class="modal-body">
                <div class="modal-fields">
                    <p>Накладные: <b><?php echo $data->additionDatas['invoices']; ?></b></p>
                    <p>Акты выполненных работ: <b><?php echo $data->additionDatas['act_services']; ?></b></p>
                    <p>Реестры: <b><?php echo $data->additionDatas['act_services']; ?></b></p>
                    <div class="modal-footer text-center">
                        <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/invoice_print_list', array('shop_client_id' => 'shop_client_id', 'date_from_equally' => 'date_from_equally', 'date_to' => 'date_to',), array('is_issued' => true)); ?>">Накладные для печати</a></li>
                        <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/act_service_print_list', array('shop_client_id' => 'shop_client_id', 'date_from_equally' => 'date_from_equally', 'date_to' => 'date_to',), array('is_issued' => true)); ?>">Акты для печати</a></li>
                        <a class="btn btn-primary" href="<?php echo Func::getFullURL($siteData, '/shopreport/act_service_print_registry', array('shop_client_id' => 'shop_client_id', 'date_from_equally' => 'date_from_equally', 'date_to' => 'date_to',), array('is_issued' => true)); ?>">Реестры для печати</a></li>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>