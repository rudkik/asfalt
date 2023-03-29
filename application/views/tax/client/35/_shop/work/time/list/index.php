<div class="ks-nav-body">
    <div id="work-time-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#work-time-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="work-time-new" data-action="table-new" data-table="#work-time-data-table" data-modal="#work-time-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopworktime/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="work-time-edit" data-action="table-edit" data-table="#work-time-data-table" data-modal="#work-time-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopworktime/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#work-time-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopworktime/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="work-time-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#work-time-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopworktime/json?is_total=1&_fields[]=date_from&_fields[]=date_to&_fields[]=shop_worker_name&_fields[]=work_time_type_name&_fields[]=wage&_fields[]=days&_fields[]=work_days&_fields[]=id"
           data-toolbar="#work-time-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="shop_worker_name" data-sortable="true">Работник</th>
            <th data-field="work_time_type_name" data-sortable="true">Вид периода</th>
            <th data-formatter="getIsDate" data-field="date_from" data-sortable="true">Дата от</th>
            <th data-formatter="getIsDate" data-field="date_to" data-sortable="true">Дата до</th>
            <th data-formatter="getIsAmount" data-field="wage" data-sortable="true">Зарплата</th>
            <th data-field="days" data-sortable="true">Кол-во дней</th>
            <th data-field="work_days" data-sortable="true">Кол-во раб. дней</th>
        </tr>
        </thead>
    </table>
</div>