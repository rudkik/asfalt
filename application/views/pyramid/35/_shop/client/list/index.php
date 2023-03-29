<div class="ks-nav-body">
    <div id="client-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#client-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
        </div>
    </div>

    <table id="client-data-table" data-action="pyramid-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#client-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shopclient/json?is_total=1&root_id=<?php echo Request_RequestParams::getParamInt('root_id'); ?>&_fields[]=amount&_fields[]=name&_fields[]=currency_symbol&_fields[]=child_count&_fields[]=id"
           data-toolbar="#client-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-formatter="getIsNameClient" data-field="name" data-sortable="true">ФИО</th>
            <th data-formatter="getIsAmountClient" data-field="amount" data-sortable="true">Прибыль</th>
            <th data-field="child_count" data-sortable="true">Кол-во привлеченных</th>
        </tr>
        </thead>
    </table>
</div>
<script>
    function getIsAmountClient(value, row) {
        if(row['currency_symbol'] !== undefined) {
            return row['currency_symbol'].replace('{amount}', Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.'));
        }else{
            return '';
        }
    }
    function getIsNameClient(value, row) {
        return '<a href="/pyramid/shopclient/index?root_id='+row['id']+'">'+value+'</a>';
    }
</script>

