<div class="ks-nav-body">
    <div id="branch-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#branch-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
        </div>
    </div>

    <table id="branch-data-table" data-action="nur-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#branch-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/nur-bookkeeping/shopbranch/json?is_total=1&_fields[]=bin&_fields[]=name&_fields[]=organization_tax_type_name&_fields[]=organization_type_name&_fields[]=id"
           data-toolbar="#branch-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">Название</th>
            <th data-field="bin" data-sortable="true">БИН</th>
            <th data-field="organization_type_name" data-sortable="true">Правовая форма</th>
            <th data-field="organization_tax_type_name" data-sortable="true">Налоговый режим</th>
            <th data-formatter="getEditURL" style="width: 110px"></th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getEditURL(value, row) {
        return '<a href="/nur-bookkeeping/shopbranch/edit?id='+ row['id']+'"><span class="ks-icon fa fa-pencil-square-o"></span> посмотреть</a>';
    }
</script>
