<div class="ks-nav-body">
    <div id="task-current-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#task-current-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
        </div>
    </div>

    <table id="task-current-data-table" data-action="nur-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#task-current-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/nur-admin/shoptaskcurrent/json_new?period=<?php echo Request_RequestParams::getParamStr('period'); ?>&shop_branch_id=<?php echo Request_RequestParams::getParamStr('shop_branch_id'); ?>&shop_bookkeeper_id=<?php echo Request_RequestParams::getParamStr('shop_bookkeeper_id'); ?>&is_total=1&_fields[]=date_from&_fields[]=date_to&_fields[]=name&_fields[]=shop_bookkeeper_name&_fields[]=shop_name&_fields[]=id"
           data-toolbar="#task-current-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="shop_name" data-sortable="true">Клиент</th>
            <th data-field="shop_task_name" data-sortable="true">Название</th>
            <th data-field="shop_bookkeeper_name" data-sortable="true">Бухгалтер</th>
            <th data-formatter="getDateTime" data-field="date_from" data-sortable="true">Срок действия от</th>
            <th data-formatter="getDateTime" data-field="date_to" data-sortable="true">Срок действия до</th>
            <th data-formatter="getEditURL" style="width: 110px"></th>
        </tr>
        </thead>
    </table>
</div>
<script>
    function getEditURL(value, row) {
        return '<a href="/nur-admin/shoptaskcurrent/add?id='+ row['shop_task_id']+'&shop_branch_id='+row['shop_id']+'"><span class="ks-icon fa fa-pencil-square-o"></span> Взять в работу</a>';
    }
</script>
