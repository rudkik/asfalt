<div class="ks-nav-body">
    <div id="bill-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#bill-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <?php if ($siteData->operation->getShopTableRubricID() != 4){ ?>
            <button id="bill-new" data-child="#room-free-record" data-action="table-new" data-table="#bill-data-table" data-modal="#bill-new-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <?php } ?>
            <button id="bill-edit" data-child="#room-free-record" data-action="table-edit" data-table="#bill-data-table" data-modal="#bill-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <?php if ($siteData->operation->getShopTableRubricID() != 4){ ?>
            <button data-action="table-edit" data-modal="#bill-cancel-record" data-table="#bill-data-table" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/modal_cancel" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Отменить</span></button>
            <?php } ?>
            <div class="btn-group">
                <a data-action="table-download" data-table="#bill-data-table" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/act_service" href="#" type="button" class="btn btn-info-outline ks-solid">Печать</a>
                <button type="button" class="btn btn-info-outline ks-solid dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a data-action="table-download" data-table="#bill-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_pdf?data_language_id=35" href="#">Подтверждение брони (на русском)</a>
                    <a data-action="table-download" data-table="#bill-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_halyk_pdf?data_language_id=35" href="#">Оплата через Народный Банк (на русском)</a>
                    <a data-action="table-download" data-table="#bill-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_bank_pdf?data_language_id=35" href="#">Оплата через Любой банк (на русском)</a>
                    <a data-action="table-download" data-table="#bill-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_bank_and_halyk_pdf?data_language_id=35" href="#">Оплата через Любой банк и Народный Банк (на русском)</a>
                    <a data-action="table-download" data-table="#bill-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_pdf?data_language_id=36" href="#">Подтверждение брони (на английском)</a>
                    <a data-action="table-download" data-table="#bill-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_halyk_pdf?data_language_id=36" href="#">Оплата через Народный Банк (на английском)</a>
                    <a data-action="table-download" data-table="#bill-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_bank_pdf?data_language_id=36" href="#">Оплата через Любой банк (на английском)</a>
                    <a data-action="table-download" data-table="#bill-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/save_bank_and_halyk_pdf?data_language_id=36" href="#">Оплата через Любой банк и Народный Банк (на английском)</a>
                    <a data-action="table-download" data-table="#bill-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/act_service" href="#">Акт выполненных работ</a>
                </div>
            </div>
        </div>
    </div>

    <table id="bill-data-table" data-action="hotel-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#bill-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/json?is_total=1&_fields[]=limit_time&_fields[]=create_user_name&_fields[]=update_user_name&_fields[]=name&_fields[]=residual_amount&_fields[]=created_at&_fields[]=amount&_fields[]=paid_amount&_fields[]=shop_client_name&_fields[]=shop_client_phone&_fields[]=date_from&_fields[]=date_to&_fields[]=is_finish&_fields[]=finish_date&_fields[]=id"
           data-toolbar="#bill-toolbar" style="max-height: 460px"    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true">Код брони</th>
            <th data-formatter="getIsDate" data-field="limit_time" data-sortable="true">Бронь до</th>
            <th data-formatter="getAmount" data-field="amount" data-sortable="true">Сумма</th>
            <th data-formatter="getAmount" data-field="paid_amount" data-sortable="true">Оплаченная <br>сумма</th>
            <th data-formatter="getResidual" data-sortable="true">Остаток</th>
            <th data-formatter="getIsBillName" data-field="shop_client_name" data-sortable="true">ФИО</th>
            <th data-field="shop_client_phone" data-sortable="true">Телефон</th>
            <th data-formatter="getIsDate" data-field="date_from" data-sortable="true">Дата заезда</th>
            <th data-formatter="getIsDate" data-field="date_to" data-sortable="true">Дата выезда</th>
            <th data-formatter="getIsDate" data-field="created_at" data-sortable="true">Дата создания</th>
            <th data-field="update_user_name" data-sortable="true">Кто редактировал</th>
            <th data-field="create_user_name" data-sortable="true">Кто создал</th>
            <th data-formatter="getIsBillFinish" data-field="is_finish" data-sortable="true">Клиент отдохнул?</th>
        </tr>
        </thead>
    </table>
</div>

<script>
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
    function getIsBillName(value, row) {
        if((row['name'] !== undefined) && (row['name'] !== null) && (row['name'] !== '') && (row['name'] != value)){
            value = value + '<br>' + 'ФИО при заказе: ' + row['name'];
        }
        return value;
    }
</script>
