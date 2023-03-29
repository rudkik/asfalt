<div class="ks-nav-body">
    <div id="my-invoice-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#my-invoice-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="my-invoice-new" data-action="table-new" data-table="#my-invoice-data-table" data-modal="#my-invoice-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmyinvoice/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="my-invoice-edit" data-action="table-edit" data-table="#my-invoice-data-table" data-modal="#my-invoice-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmyinvoice/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#my-invoice-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmyinvoice/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="my-invoice-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#my-invoice-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmyinvoice/json?is_total=1&_fields[]=date&_fields[]=amount&_fields[]=number&_fields[]=date&_fields[]=shop_contractor_name&_fields[]=shop_contract_number&_fields[]=shop_contract_date&_fields[]=id"
           data-toolbar="#my-invoice-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="number" data-sortable="true">№</th>
            <th data-formatter="getIsDate" data-field="date" data-sortable="true">Дата</th>
            <th data-formatter="getIsAmount" data-field="amount" data-sortable="true">Сумма</th>
            <th data-field="shop_contract_number" data-sortable="true">№ договора</th>
            <th data-formatter="getIsDate" data-field="shop_contract_date" data-sortable="true">Дата договора</th>
            <th data-field="shop_contractor_name" data-sortable="true">Контрагент</th>
        </tr>
        </thead>
    </table>
</div>