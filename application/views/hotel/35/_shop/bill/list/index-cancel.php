<div class="ks-nav-body">
    <div id="bill-cancel-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#bill-cancel-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="bill-cancel-edit" data-child="#room-free-record" data-action="table-edit" data-table="#bill-cancel-data-table" data-modal="#bill-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#bill-cancel-data-table" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/un_cancel" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Восстановить</span></button>
            <div class="btn-group">
                <a data-action="table-download" data-table="#bill-cancel-data-table" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/act_service" href="#" type="button" class="btn btn-info-outline ks-solid">Печать</a>
                <button type="button" class="btn btn-info-outline ks-solid dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a data-action="table-download" data-table="#bill-cancel-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_pdf" href="#">Бронь</a>
                    <a data-action="table-download" data-table="#bill-cancel-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_halyk_pdf" href="#">Оплата через Народный Банк</a>
                    <a data-action="table-download" data-table="#bill-cancel-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_bank_pdf" href="#">Оплата через Любой банк</a>
                    <a data-action="table-download" data-table="#bill-cancel-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_bank_and_halyk_pdf" href="#">Оплата через Любой банк и Народный Банк</a>
                    <a data-action="table-download" data-table="#bill-cancel-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/act_service" href="#">Акт выполненных работ</a>
                </div>
            </div>
        </div>
    </div>

    <table id="bill-cancel-data-table" data-action="hotel-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#bill-cancel-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/json?is_total=1&is_public=0&_fields[]=text&_fields[]=bill_cancel_status_name&_fields[]=update_user_name&_fields[]=residual_amount&_fields[]=created_at&_fields[]=amount&_fields[]=paid_amount&_fields[]=shop_client_name&_fields[]=shop_client_phone&_fields[]=date_from&_fields[]=date_to&_fields[]=id"
           data-toolbar="#bill-cancel-toolbar" style="max-height: 460px"    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true">Код брони</th>
            <th data-formatter="getCancel"data-field="text" data-sortable="true">Причина отмены</th>
            <th data-formatter="getAmount" data-field="amount" data-sortable="true">Сумма</th>
            <th data-formatter="getAmount" data-field="paid_amount" data-sortable="true">Оплаченная <br>сумма</th>
            <th data-formatter="getResidual" data-sortable="true">Остаток</th>
            <th data-field="shop_client_name" data-sortable="true">ФИО</th>
            <th data-field="shop_client_phone" data-sortable="true">Телефон</th>
            <th data-formatter="getIsDate" data-field="date_from" data-sortable="true">Дата заезда</th>
            <th data-formatter="getIsDate" data-field="date_to" data-sortable="true">Дата выезда</th>
            <th data-formatter="getIsDate" data-field="created_at" data-sortable="true">Дата создания</th>
            <th data-field="update_user_name" data-sortable="true">Кто редактировал</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getCancel(value, row) {
        if ((row['bill_cancel_status_name'] !== undefined) && (row['bill_cancel_status_name'] !== null) && (row['bill_cancel_status_name'] !== '')) {
            return row['bill_cancel_status_name']+'<br>'+value;
        }else{
            return value;
        }
    }
    function getResidual(value, row) {
        if((row['paid_amount'] === undefined) || (row['paid_amount'] === null)){
            var paidAmout = 0;
        }else{
            var paidAmout = row['paid_amount'];
        }

        return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(row['amount'] - paidAmout).replace(',', '.');
    }
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
</script>
