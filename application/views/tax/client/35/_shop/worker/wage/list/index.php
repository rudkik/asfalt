<div class="ks-nav-body">
    <div id="worker-wage-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#worker-wage-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="worker-wage-new" data-action="table-new" data-table="#worker-wage-data-table" data-modal="#worker-wage-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopworkerwage/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="worker-wage-edit" data-action="table-edit" data-table="#worker-wage-data-table" data-modal="#worker-wage-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopworkerwage/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#worker-wage-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopworkerwage/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="worker-wage-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#worker-wage-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopworkerwage/json?is_total=1&_fields[]=date&_fields[]=shop_worker_name&_fields[]=worker_status_name&_fields[]=wage&_fields[]=opv&_fields[]=so&_fields[]=ipn&_fields[]=osms&_fields[]=sn&_fields[]=id"
           data-toolbar="#worker-wage-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="shop_worker_name" data-sortable="true">Работник</th>
            <th data-field="worker_status_name" data-sortable="true">Статус</th>
            <th data-formatter="getIsDateMonth" data-field="date" data-sortable="true">Дата</th>
            <th data-formatter="getIsAmount" data-field="wage" data-sortable="true">Зарплата (на руки)</th>
            <th data-formatter="getIsAmount" data-field="opv" data-sortable="true">ОПВ</th>
            <th data-formatter="getIsAmount" data-field="so" data-sortable="true">СО</th>
            <th data-formatter="getIsAmount" data-field="ipn" data-sortable="true">ИПН</th>
            <th data-formatter="getIsAmount" data-field="osms" data-sortable="true">ОСМС</th>
            <th data-formatter="getIsAmount" data-field="sn" data-sortable="true">СН</th>
        </tr>
        </thead>
    </table>
</div>