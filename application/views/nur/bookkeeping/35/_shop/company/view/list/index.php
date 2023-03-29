<div class="ks-nav-body">
    <div id="company-view-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#company-view-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <a href="<?php echo $siteData->urlBasic; ?>/nur-bookkeeping/shopcompanyview/new" class="btn btn-primary ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></a>
            <button data-action="table-delete" data-table="#company-view-data-table" data-url="<?php echo $siteData->urlBasic; ?>/nur-bookkeeping/shopcompanyview/del" class="btn btn-danger ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="company-view-data-table" data-action="nur-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#company-view-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/nur-bookkeeping/shopcompanyview/json?is_total=1&_fields[]=name&_fields[]=id"
           data-toolbar="#company-view-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">Название</th>
            <th data-formatter="getEditURL" style="width: 110px"></th>
        </tr>
        </thead>
    </table>
</div>
<script>
    function getEditURL(value, row) {
        return '<a href="/nur-bookkeeping/shopcompanyview/edit?id='+ row['id']+'"><span class="ks-icon fa fa-pencil-square-o"></span> изменить</a>';
    }
</script>

