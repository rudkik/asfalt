<div class="ks-nav-body">
    <div id="payment-order-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#payment-order-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <div class="btn-group">
                <a href="#" id="payment-order-new" data-action="table-new" data-table="#payment-order-data-table" data-modal="#payment-order-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentorder/new?kbe_id=2006&knp_id=2184" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></a>
                <button type="button" class="btn btn-success-outline ks-solid dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a href="#" id="payment-order-new" data-action="table-new" data-table="#payment-order-data-table" data-modal="#payment-order-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentorder/new?kbe_id=2000&knp_id=1816&gov_contractor_id=2099&is_items=1" class="dropdown-item" >По шаблону Социальных отчислений</a>
                    <a href="#" id="payment-order-new" data-action="table-new" data-table="#payment-order-data-table" data-modal="#payment-order-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentorder/new?kbe_id=2000&knp_id=1814&gov_contractor_id=2098&is_items=1" class="dropdown-item" >По шаблону Пенсионных отчислений</a>
                    <a href="#" id="payment-order-new" data-action="table-new" data-table="#payment-order-data-table" data-modal="#payment-order-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentorder/new?kbe_id=2000&knp_id=1938&gov_contractor_id=2097&is_items=1" class="dropdown-item" >По шаблону отчислений на ОСМС (работники)</a>
                    <a href="#" id="payment-order-new" data-action="table-new" data-table="#payment-order-data-table" data-modal="#payment-order-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentorder/new?kbe_id=2000&knp_id=2409&kbk_id=1502&gov_contractor_id=2096&authority_id=<?php echo Arr::path($siteData->shop->getRequisitesArray(), 'authority_id', 1259); ?>" class="dropdown-item" >Оплата налогов</a>
                </div>
            </div>
            <div class="btn-group">
                <button id="payment-order-edit" data-action="table-edit" data-table="#payment-order-data-table" data-modal="#payment-order-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentorder/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
                <button type="button" class="btn btn-info-outline ks-solid dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a href="#" id="payment-order-clone" data-action="table-edit" data-table="#payment-order-data-table" data-modal="#payment-order-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentorder/clone" class="dropdown-item">Дублировать</a>
                </div>
            </div>
            <button data-action="table-delete" data-table="#payment-order-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentorder/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
            <a data-action="table-download" data-table="#payment-order-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopexcel/payment_order" href="#" type="button" class="btn btn-info-outline ks-solid">Печать</a>
        </div>
    </div>

    <table id="payment-order-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#payment-order-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentorder/json?is_total=1&_fields[]=kbe_code&_fields[]=knp_code&_fields[]=kbk_code&_fields[]=text&_fields[]=date&_fields[]=amount&_fields[]=number&_fields[]=date&_fields[]=shop_contractor_name&_fields[]=shop_contract_number&_fields[]=shop_contract_date&_fields[]=id"
           data-toolbar="#payment-order-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="number" data-sortable="true">№</th>
            <th data-formatter="getIsDate" data-field="date" data-sortable="true">Дата</th>
            <th data-formatter="getIsAmount" data-field="amount" data-sortable="true">Сумма</th>
            <th data-field="shop_contractor_name" data-sortable="true">Контрагент</th>
            <th data-field="kbe_code" data-sortable="true">КБе</th>
            <th data-field="knp_code" data-sortable="true">КНП</th>
            <th data-field="kbk_code" data-sortable="true">КБК</th>
            <th data-field="text" data-sortable="true">Назначение платежа</th>
        </tr>
        </thead>
    </table>
</div>