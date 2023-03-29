<div class="ks-nav-body">
    <div id="room-free-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#room-free-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="room-free-new" data-action="table-new" data-table="#room-free-data-table" data-modal="#room-free-new-record" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoproom/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="room-free-edit" data-action="table-edit" data-table="#room-free-data-table" data-modal="#room-free-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoproom/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#room-free-data-table" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoproom/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="room-free-data-table" data-action="pyramid-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#room-free-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoproom/json_free?is_total=1&_fields[]=shop_building_name&_fields[]=shop_floor_name&_fields[]=shop_room_type_name&_fields[]=human&_fields[]=price&_fields[]=price_child&_fields[]=human_extra&_fields[]=price_extra&_fields[]=name&_fields[]=id"
           data-toolbar="#room-free-toolbar" style="max-height: 460px"    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">Номер</th>
            <th data-field="human" data-sortable="true">Кол-во <br>человек</th>
            <th data-formatter="getAmount" data-field="price" data-sortable="true">Стоимость</th>
            <th data-field="human_extra" data-sortable="true">Доп. <br>мест</th>
            <th data-formatter="getAmount" data-field="price_extra" data-sortable="true">Стоимость <br>взрослого</th>
            <th data-formatter="getAmount" data-field="price_child" data-sortable="true">Стоимость <br>детского</th>
        </tr>
        </thead>
    </table>
</div>
<script>
    function getAmount(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.');
        }else{
            return '';
        }
    }
</script>

