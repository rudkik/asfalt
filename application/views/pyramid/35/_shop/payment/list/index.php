<div class="ks-nav-body">
    <div id="payment-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#payment-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
        </div>
    </div>

    <table id="payment-data-table" data-action="pyramid-table" class="table table-striped table-bordered" width="100%"
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
           data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoppayment/json?is_total=1&_fields[]=created_at&_fields[]=shop_product_name&_fields[]=currency_symbol&_fields[]=amount&_fields[]=id"
           data-toolbar="#payment-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-formatter="getIsDateTimePayment" data-field="created_at" data-sortable="true">Дата</th>
            <th data-field="shop_product_name" data-sortable="true">Тренинг</th>
            <th data-formatter="getAmountPayment" data-field="amount" data-sortable="true">Сумма</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getIsDateTimePayment(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return value.replace(/(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/, '$3.$2.$1 $4:$5').replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
        }else{
            return '';
        }
    }
    function getAmountPayment(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return row['currency_symbol'].replace('{amount}', Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.'));
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

