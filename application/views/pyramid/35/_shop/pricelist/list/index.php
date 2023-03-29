<div class="ks-nav-body">
    <div id="pricelist-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#pricelist-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="pricelist-new" data-action="table-new" data-table="#pricelist-data-table" data-modal="#pricelist-new-record" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoppricelist/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="pricelist-edit" data-action="table-edit" data-table="#pricelist-data-table" data-modal="#pricelist-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoppricelist/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#pricelist-data-table" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoppricelist/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="pricelist-data-table" data-action="pyramid-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#pricelist-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoppricelist/json?is_total=1&_fields[]=date_from&_fields[]=date_to&_fields[]=name&_fields[]=id"
           data-toolbar="#pricelist-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">Название</th>
            <th data-formatter="getIsDate" data-field="date_from" data-sortable="true">Дата начала</th>
            <th data-formatter="getIsDate" data-field="date_to" data-sortable="true">Дата окончания</th>
        </tr>
        </thead>
    </table>
</div>