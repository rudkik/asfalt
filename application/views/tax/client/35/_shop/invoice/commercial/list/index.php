<div class="ks-nav-body">
    <div id="invoice-commercial-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#invoice-commercial-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="invoice-commercial-new" data-action="table-new" data-table="#invoice-commercial-data-table" data-modal="#invoice-commercial-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopinvoicecommercial/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="invoice-commercial-edit" data-action="table-edit" data-table="#invoice-commercial-data-table" data-modal="#invoice-commercial-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopinvoicecommercial/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button id="invoice-commercial-clone" data-action="table-edit" data-table="#invoice-commercial-data-table" data-modal="#invoice-commercial-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopinvoicecommercial/clone" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Дублировать</span></button>
            <button data-action="table-delete" data-table="#invoice-commercial-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopinvoicecommercial/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
            <div class="btn-group">
                <a data-action="table-download" data-table="#invoice-commercial-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopexcel/invoice_all" href="#" type="button" class="btn btn-info-outline ks-solid">Печать</a>
                <button type="button" class="btn btn-info-outline ks-solid dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a data-action="table-download" data-table="#invoice-commercial-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopexcel/invoice" href="#">Счет-фактура</a>
                    <a data-action="table-download" data-table="#invoice-commercial-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopexcel/act_service" href="#">Акт выполненных работ</a>
                    <a data-action="table-download" data-table="#invoice-commercial-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopexcel/waybill_product" href="#">Накладная на отпуск товаров</a>
                    <a data-action="table-download" data-table="#invoice-commercial-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopexcel/act_product" href="#">Акт приема-передачи товаров</a>
                </div>
            </div>
        </div>
    </div>

    <table id="invoice-commercial-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
           data-search="true"
           data-show-export="true"
           data-pagination="true"
           data-click-to-select="true"
           data-show-columns="true"
           data-resizable="true"
           data-mobile-responsive="true"
           data-check-on-init="true"
           data-locale="ru-RU"
           data-side-pagination="server"
           data-unique-id="id"
           data-page-list="[15, 25, 50, 100, 200, 500]"
           data-dlb-click-button="#invoice-commercial-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopinvoicecommercial/json?is_total=1&_fields[]=date&_fields[]=amount&_fields[]=number&_fields[]=date&_fields[]=shop_contractor_name&_fields[]=shop_contract_number&_fields[]=shop_contract_date_from&_fields[]=shop_invoice_proforma_ids&_fields[]=id"
           data-toolbar="#invoice-commercial-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="number" data-sortable="true">№</th>
            <th data-formatter="getIsDate" data-field="date" data-sortable="true">Дата</th>
            <th data-formatter="getIsAmount" data-field="amount" data-sortable="true">Сумма</th>
            <th data-field="shop_contract_number" data-sortable="true">№ договора</th>
            <th data-formatter="getIsDate" data-field="shop_contract_date_from" data-sortable="true">Дата договора</th>
            <th data-field="shop_contractor_name" data-sortable="true">Контрагент</th>
            <th data-formatter="getIsInvoiceCommercialList" data-field="shop_invoice_proforma_ids" data-sortable="true">Счет на оплату?</th>
        </tr>
        </thead>
    </table>
</div>