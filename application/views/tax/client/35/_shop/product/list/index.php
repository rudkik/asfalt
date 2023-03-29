<div class="ks-nav-body">
    <div id="product-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#product-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button data-toggle="modal" data-target="#product-new-record" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="product-edit" data-action="table-edit" data-table="#product-data-table" data-modal="#product-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopproduct/edit"  class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#product-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopproduct/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="product-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#product-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopproduct/json?is_total=1&_fields[]=is_service&_fields[]=price&_fields[]=name&_fields[]=id"
           data-toolbar="#product-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-formatter="getIsService" data-field="is_service" data-sortable="true">Тип</th>
            <th data-field="name" data-sortable="true">Наименование</th>
            <th data-formatter="getIsAmount" data-field="price" data-sortable="true">Цена</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getIsService(value, row) {
        if (value == 1){
            return 'Услуга';
        }else{
            return 'Товар';
        }
    }
</script>