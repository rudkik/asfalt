<div class="ks-nav-body">
    <div id="invoice-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#invoice-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="invoice-new" data-action="table-new" data-table="#invoice-data-table" data-modal="#invoice-new-record" data-url="<?php echo $siteData->urlBasic; ?>/ads/shopinvoice/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="invoice-edit" data-action="table-edit" data-table="#invoice-data-table" data-modal="#invoice-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/ads/shopinvoice/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#invoice-data-table" data-url="<?php echo $siteData->urlBasic; ?>/ads/shopinvoice/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>
    <table id="invoice-data-table" data-action="ads-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#invoice-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/ads/shopinvoice/json?is_total=1&_fields[]=shop_client_name&_fields[]=shop_parcel_id&_fields[]=amount&_fields[]=date_paid&_fields[]=is_paid&_fields[]=id"
           data-toolbar="#invoice-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true">№ счета</th>
            <th data-field="shop_client_name" data-sortable="true">Клиент</th>
            <th data-field="shop_parcel_id" data-sortable="true">№ посылки</th>
            <th data-formatter="getAmountInvoice" data-field="amount" data-sortable="true">Сумма</th>
            <th data-formatter="getPaidInvoice" data-field="date_paid"  data-sortable="true">Статус</th>
        </tr>
        </thead>
    </table>
    <script>
        function getPaidInvoice(value, row) {
            if(row['is_paid'] == 1) {
                if ((value !== undefined) && (value !== null) && (value !== '1970-01-01') && (value !== '1970-01-01 06:00:00')) {
                    return 'Оплачено <br>'+value.replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
                } else {
                    return 'Оплачено <br>';
                }
            }else{
                return 'Неоплачено';
            }
        }
        function getAmountInvoice(value, row) {
            if ((value !== undefined) && (value !== null)) {
                return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.');
            }else{
                return '';
            }
        }
    </script>
</div>

