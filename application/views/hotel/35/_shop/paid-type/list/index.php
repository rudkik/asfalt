<div class="ks-nav-body">
    <div id="paid-type-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#paid-type-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="paid-type-edit" data-action="table-edit" data-table="#paid-type-data-table" data-modal="#paid-type-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shoppaidtype/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
        </div>
    </div>

    <table id="paid-type-data-table" data-action="hotel-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#paid-type-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/hotel/shoppaidtype/json?is_total=1&_fields[]=options_reserve_time&_fields[]=name&_fields[]=id"
           data-toolbar="#paid-type-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">Название</th>
            <th data-field="options_reserve_time" data-sortable="false">Время брони</th>
        </tr>
        </thead>
    </table>
</div>

