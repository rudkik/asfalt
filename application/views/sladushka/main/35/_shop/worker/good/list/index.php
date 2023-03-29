<div class="ks-nav-body">
    <div id="worker-good-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#worker-good-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="worker-good-new" data-action="table-new" data-table="#worker-good-data-table" data-modal="#worker-good-new-record" data-url="<?php echo $siteData->urlBasic; ?>/sladushka/shopworkergood/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="worker-good-edit" data-action="table-edit" data-table="#worker-good-data-table" data-modal="#worker-good-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/sladushka/shopworkergood/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#worker-good-data-table" data-url="<?php echo $siteData->urlBasic; ?>/sladushka/shopworkergood/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
            <a data-action="table-download" data-table="#worker-good-data-table" data-url="<?php echo $siteData->urlBasic; ?>/sladushka/shopworkergood/report" href="#" type="button" class="btn btn-info-outline ks-solid">Отчет</a>
        </div>
    </div>

    <table id="worker-good-data-table" data-action="sladushka-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#worker-good-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/sladushka/shopworkergood/json?is_total=1&_fields[]=date&_fields[]=shop_worker_name&_fields[]=took&_fields[]=return&_fields[]=quantity&_fields[]=amount&_fields[]=id"
           data-toolbar="#worker-good-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-formatter="getIsDate" data-field="date" data-sortable="true">Дата</th>
            <th data-field="shop_worker_name" data-sortable="true">Сотрудник</th>
            <th data-field="took" data-sortable="true">Забрал</th>
            <th data-field="return" data-sortable="true">Вернул</th>
            <th data-field="quantity" data-sortable="true">Продано</th>
            <th data-field="amount" data-sortable="true">Сумма</th>
        </tr>
        </thead>
    </table>
</div>
<script>
    function getIsDate(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return value.replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
        }else{
            return '';
        }
    }
</script>

