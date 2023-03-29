<div class="ks-nav-body">
    <div id="floor-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#floor-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="floor-new" data-action="table-new" data-table="#floor-data-table" data-modal="#floor-new-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopfloor/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="floor-edit" data-action="table-edit" data-table="#floor-data-table" data-modal="#floor-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopfloor/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#floor-data-table" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopfloor/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
            <div class="btn-group">
                <a data-action="table-download" data-table="#floor-data-table" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/floor_all" href="#" type="button" class="btn btn-info-outline ks-solid">Печать</a>
                <button type="button" class="btn btn-info-outline ks-solid dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a data-action="table-download" data-table="#floor-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/floor" href="#">Счет-фактура</a>
                    <a data-action="table-download" data-table="#floor-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/act_service" href="#">Акт выполненных работ</a>
                    <a data-action="table-download" data-table="#floor-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/waybill_product" href="#">Накладная на отпуск товаров</a>
                    <a data-action="table-download" data-table="#floor-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/act_product" href="#">Акт приема-передачи товаров</a>
                </div>
            </div>
        </div>
    </div>

    <table id="floor-data-table" data-action="hotel-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#floor-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopfloor/json?is_total=1&_fields[]=shop_building_name&_fields[]=name&_fields[]=id"
           data-toolbar="#floor-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">Этаж</th>
            <th data-field="shop_building_name" data-sortable="true">Здание</th>
        </tr>
        </thead>
    </table>
</div>

