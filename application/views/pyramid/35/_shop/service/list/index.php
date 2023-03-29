<div class="ks-nav-body">
    <div id="service-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#service-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="service-new" data-action="table-new" data-table="#service-data-table" data-modal="#service-new-record" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shopservice/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="service-edit" data-action="table-edit" data-table="#service-data-table" data-modal="#service-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shopservice/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#service-data-table" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shopservice/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="service-data-table" data-action="pyramid-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#service-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shopservice/json?is_total=1&_fields[]=price&_fields[]=name&_fields[]=id"
           data-toolbar="#service-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">Наименование</th>
            <th data-field="price" data-formatter="getAmount" data-sortable="true">Цена</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getAmount(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 0}).format(value).replace(',', '.');
        }else{
            return '';
        }
    }
</script>