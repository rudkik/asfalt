<div class="ks-nav-body">
    <div id="payment-book-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#payment-book-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
        </div>
    </div>

    <table id="payment-book-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#payment-book-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shoppaymentbook/json?is_total=1&_fields[]=amount&_fields[]=is_coming&_fields[]=date&_fields[]=text&_fields[]=shop_paid_type_name&_fields[]=id"
           data-toolbar="#payment-book-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-formatter="getIsDateTime" data-field="date" data-sortable="true">Дата</th>
            <th data-formatter="getAmountPaymentBook"  data-field="amount" data-sortable="true">Сумма</th>
            <th data-field="shop_paid_type_name" data-sortable="true">Способ оплаты</th>
            <th data-field="text" data-sortable="true">Примечание</th>
        </tr>
        </thead>
    </table>
</div>
<script>
    function getAmountPaymentBook(value, row) {
        if ((value !== undefined) && (value !== null)) {
            value = Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.');
            if (row['is_coming'] == 1) {
                return '<span class="ks-color-success">' + value + '</span>';
            }else{
                return '<span class="ks-color-danger">' + value + '</span>';
            }
        }else{
            return '';
        }
    }
</script>

