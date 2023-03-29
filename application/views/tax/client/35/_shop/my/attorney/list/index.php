<div class="ks-nav-body">
    <div id="my-attorney-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#my-attorney-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="my-attorney-new" data-action="table-new" data-table="#my-attorney-data-table" data-modal="#my-attorney-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmyattorney/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="my-attorney-edit" data-action="table-edit" data-table="#my-attorney-data-table" data-modal="#my-attorney-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmyattorney/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#my-attorney-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmyattorney/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
            <a href="#" data-action="table-download" data-table="#my-attorney-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopexcel/attorney" class="btn btn-info-outline ks-solid">Печать</a>
        </div>
    </div>

    <table id="my-attorney-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#my-attorney-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmyattorney/json?is_total=1&_fields[]=number&_fields[]=date_from&_fields[]=name&_fields[]=date_to&_fields[]=text&_fields[]=shop_contractor_name&_fields[]=shop_worker_name&_fields[]=amount&_fields[]=id"
           data-toolbar="#my-attorney-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="number" data-sortable="true">Номер</th>
            <th data-field="shop_contractor_name" data-sortable="true">Контрагент</th>
            <th data-field="shop_worker_name" data-sortable="true">На кого выписана</th>
            <th data-formatter="getIsDate" data-field="date_from" data-sortable="true">Дата начала</th>
            <th data-formatter="getIsDate" data-field="date_to" data-sortable="true">Дата окончания</th>
            <th data-formatter="getIsNumber" data-field="amount" data-sortable="true">Сумма</th>
            <th data-field="text" data-sortable="true">Примечание</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getIsNumber(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.').replace('.00', '');
        }else{
            return '';
        }
    }
</script>

