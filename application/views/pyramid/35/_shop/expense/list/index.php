<div class="ks-nav-body">
    <div id="expense-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#expense-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="expense-new" data-action="table-new" data-table="#expense-data-table" data-modal="#expense-new-record" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shopexpense/new"  class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
        </div>
    </div>

    <table id="expense-data-table" data-action="pyramid-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#expense-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shopexpense/json?is_total=1&_fields[]=currency_symbol&_fields[]=created_at&_fields[]=date&_fields[]=amount&_fields[]=shop_expense_type_name&_fields[]=id"
           data-toolbar="#expense-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-formatter="getIsDateTimeExpense" data-field="date" data-sortable="true">Время перевода</th>
            <th data-formatter="getIsAmountExpense" data-field="amount" data-sortable="true">Сумма</th>
            <th data-field="shop_expense_type_name" data-sortable="true">Куда вывели</th>
            <th data-formatter="getIsDateTimeExpense" data-field="created_at" data-sortable="true">Дата подачи заявки</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getIsDateTimeExpense(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return value.replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
        }else{
            return '';
        }
    }
    function getIsAmountExpense(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return row['currency_symbol'].replace('{amount}', Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.'));
        }else{
            return '';
        }
    }
</script>

