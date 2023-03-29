<div class="ks-nav-body">
    <div id="good-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#good-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="good-new" data-action="table-new" data-table="#good-data-table" data-modal="#good-new-record" data-url="<?php echo $siteData->urlBasic; ?>/sladushka/shopgood/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="good-edit" data-action="table-edit" data-table="#good-data-table" data-modal="#good-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/sladushka/shopgood/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#good-data-table" data-url="<?php echo $siteData->urlBasic; ?>/sladushka/shopgood/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="good-data-table" data-action="sladushka-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#good-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/sladushka/shopgood/json?is_total=1&_fields[]=options&_fields[]=name&_fields[]=price&_fields[]=id"
           data-toolbar="#good-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">Продукция</th>
            <th data-formatter="getWeight"data-field="options.weight" data-sortable="true">Вес (кг)</th>
            <th data-field="price" data-sortable="true">Цена</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getWeight(value, row) {
        return row.options.weight;
    }
</script>

