<div class="ks-nav-body">
    <div id="payment-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#payment-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="payment-new" data-action="table-new" data-table="#payment-data-table" data-modal="#payment-new-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shoppayment/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить оплату</span></button>
            <?php if ($siteData->operation->getShopTableRubricID() != 2){ ?>
            <button id="payment-edit" data-action="table-edit" data-table="#payment-data-table" data-modal="#payment-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shoppayment/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <?php } ?>
            <div class="btn-group">
                <a data-action="table-download" data-table="#payment-data-table" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/invoice_proforma" href="#" type="button" class="btn btn-info-outline ks-solid">Печать</a>
                <button type="button" class="btn btn-info-outline ks-solid dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a data-action="table-download" data-table="#payment-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/invoice_proforma" href="#">Счет на оплату</a>
                    <a data-action="table-download" data-table="#payment-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/pko" href="#">ПКО</a>
                    <a data-action="table-download" data-table="#payment-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/payment_order" href="#">Платежное поручение</a>
                </div>
            </div>
        </div>
    </div>

    <table id="payment-data-table" data-action="hotel-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#payment-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/hotel/shoppayment/json?is_total=1&_fields[]=update_user_name&_fields[]=is_paid&_fields[]=shop_paid_type_name&_fields[]=shop_bill_id&_fields[]=is_paid&_fields[]=paid_at&_fields[]=amount&_fields[]=number&_fields[]=created_at&_fields[]=shop_client_name&_fields[]=text&_fields[]=id"
           data-toolbar="#payment-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="number" data-sortable="true">№</th>
            <th data-formatter="getIsDate" data-field="created_at" data-sortable="true">Дата</th>
            <th data-field="shop_client_name" data-sortable="true">Клиент</th>
            <th data-formatter="getAmount" data-field="amount" data-sortable="true">Сумма</th>
            <th data-formatter="getPaid" data-field="paid_at" data-sortable="true">Оплата</th>
            <th data-field="shop_paid_type_name" data-sortable="true">Способ оплаты</th>
            <th data-field="shop_bill_id" data-sortable="true">Код брони</th>
            <th data-field="update_user_name" data-sortable="true">Кто редактировал</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getIsDate(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return value.replace(/(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/, '$3.$2.$1 $4:$5').replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
        }else{
            return '';
        }
    }
    function getAmount(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.');
        }else{
            return '';
        }
    }
    function getPaid(value, row) {
        if ((row.is_paid == 1) && (value !== undefined) && (value !== null)) {
            return value.replace(/(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/, '$3.$2.$1 $4:$5').replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
        }else{
            return 'не оплачен';
        }
    }
</script>

