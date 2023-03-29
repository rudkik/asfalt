<div class="ks-nav-body">
    <div id="invoice-proforma-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#invoice-proforma-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <div class="btn-group">
                <button id="invoice-proforma-new" data-action="table-new" data-table="#invoice-proforma-data-table" data-modal="#invoice-proforma-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopinvoiceproforma/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
                <button type="button" class="btn btn-success-outline ks-solid dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a href="#" data-action="table-edit" data-table="#invoice-proforma-data-table" data-modal="#invoice-commercial-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopinvoiceproforma/invoice_commercial" class="dropdown-item">На основе счета создать счет-фактуру</a>
                </div>
            </div>
            <div class="btn-group">
                <button id="invoice-proforma-edit" data-action="table-edit" data-table="#invoice-proforma-data-table" data-modal="#invoice-proforma-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopinvoiceproforma/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
                <button type="button" class="btn btn-info-outline ks-solid dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a href="#" id="invoice-proforma-clone" data-action="table-edit" data-table="#invoice-proforma-data-table" data-modal="#invoice-proforma-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopinvoiceproforma/clone" class="dropdown-item">Дублировать</a>
                </div>
            </div>
            <button data-action="table-delete" data-table="#invoice-proforma-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopinvoiceproforma/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
            <a href="#" data-action="table-download" data-table="#invoice-proforma-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopexcel/invoice_proforma" class="btn btn-info-outline ks-solid">Печать</a>
        </div>
    </div>

    <table id="invoice-proforma-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#invoice-proforma-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopinvoiceproforma/json?is_total=1&_fields[]=date&_fields[]=amount&_fields[]=number&_fields[]=date&_fields[]=shop_contractor_name&_fields[]=shop_contract_number&_fields[]=shop_contract_date_from&_fields[]=is_paid&_fields[]=shop_invoice_commercial_ids&_fields[]=id"
           data-toolbar="#invoice-proforma-toolbar" style="max-height: 460px"
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
            <th data-formatter="getIsPaid" data-field="is_paid" data-sortable="true">Оплачен?</th>
            <th data-formatter="getIsInvoiceCommercialList" data-field="shop_invoice_commercial_ids" data-sortable="true">Счет-фактура?</th>
        </tr>
        </thead>
    </table>
</div>