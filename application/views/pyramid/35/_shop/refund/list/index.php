<div class="ks-nav-body">
    <div id="refund-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#refund-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="refund-new" data-action="table-new" data-table="#refund-data-table" data-modal="#refund-new-record" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoprefund/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <?php if ($siteData->operation->getShopTableRubricID() != 2){ ?>
            <button id="refund-edit" data-action="table-edit" data-table="#refund-data-table" data-modal="#refund-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoprefund/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <?php } ?>
        </div>
    </div>

    <table id="refund-data-table" data-action="pyramid-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#refund-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoprefund/json?is_total=1&_fields[]=refund_type_name&_fields[]=update_user_name&_fields[]=date&_fields[]=amount&_fields[]=number&_fields[]=created_at&_fields[]=shop_client_name&_fields[]=text&_fields[]=id"
           data-toolbar="#refund-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="number" data-sortable="true">№</th>
            <th data-formatter="getIsDateRefund" data-field="date" data-sortable="true">Дата</th>
            <th data-field="shop_client_name" data-sortable="true">Клиент</th>
            <th data-formatter="getAmountRefund" data-field="amount" data-sortable="true">Сумма</th>
            <th data-field="refund_type_name" data-sortable="true">Тип возврата</th>
            <th data-field="update_user_name" data-sortable="true">Кто редактировал</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getIsDateRefund(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return value.replace(/(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/, '$3.$2.$1 $4:$5').replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
        }else{
            return '';
        }
    }
    function getAmountRefund(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.');
        }else{
            return '';
        }
    }
</script>

