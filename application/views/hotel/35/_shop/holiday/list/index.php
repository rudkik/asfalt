<div class="ks-nav-body">
    <div id="holiday-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#holiday-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="holiday-new" data-action="table-new" data-table="#holiday-data-table" data-modal="#holiday-new-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopholiday/new"  class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="holiday-edit" data-action="table-edit" data-table="#holiday-data-table" data-modal="#holiday-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopholiday/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#holiday-data-table" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopholiday/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="holiday-data-table" data-action="hotel-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#holiday-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopholiday/json?is_total=1&_fields[]=name&_fields[]=date_from&_fields[]=date_to&_fields[]=id"
           data-toolbar="#holiday-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">Название</th>
            <th data-formatter="getIsDate" data-field="date_from" data-sortable="true">Начало</th>
            <th data-formatter="getIsDate" data-field="date_to" data-sortable="true">Окончание</th>
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

