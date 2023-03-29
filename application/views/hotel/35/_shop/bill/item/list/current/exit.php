<div class="ks-nav-body">
    <div id="bill-item-exit-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#bill-item-exit-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="bill-item-exit-new" data-child="#room-free-record" data-action="table-new" data-table="#bill-data-table" data-modal="#bill-new-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbill/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить бронь</span></button>
            <button id="bill-item-exit-edit" data-child="#room-free-record" data-action="table-edit" data-table="#bill-item-exit-data-table" data-modal="#bill-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbillitem/bill_edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Оплатить / Редактировать</span></button>
        </div>
    </div>

    <table id="bill-item-exit-data-table" data-action="hotel-table" class="table table-striped table-bordered" width="100%"
           data-search="true"
           data-show-export="true"
           data-click-to-select="true"
           data-show-columns="true"
           data-resizable="true"
           data-mobile-responsive="true"
           data-check-on-init="true"
           data-locale="ru-RU"
           data-side-pagination="server"
           data-unique-id="id"
           data-dlb-click-button="#bill-item-exit-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopbillitem/json_exit?is_total=1&_fields[]=shop_bill_id&_fields[]=shop_room_name&_fields[]=shop_client_name&_fields[]=date_from&_fields[]=date_to&_fields[]=shop_bill_is_finish&_fields[]=shop_bill_finish_date&_fields[]=id"
           data-toolbar="#bill-item-exit-toolbar" style="max-height: 460px"    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="shop_bill_id" data-sortable="true">Код брони</th>
            <th data-field="shop_client_name" data-sortable="true">Клиент</th>
            <th data-field="shop_room_name" data-sortable="true">Комната</th>
            <th data-formatter="getIsDateBillItemExit" data-field="date_from" data-sortable="true">Дата заезда</th>
            <th data-formatter="getIsDateBillItemExitTo" data-field="date_to" data-sortable="true">Дата выезда</th>
            <th data-formatter="getIsBillFinish" data-field="shop_bill_is_finish" data-sortable="true">Клиент отдохнул?</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getIsDateBillItemExit(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return value.replace(/(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/, '$3.$2.$1 $4:$5').replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
        }else{
            return '';
        }
    }
    function getIsDateBillItemExitTo(value, row) {
        if ((value !== undefined) && (value !== null)) {

            var D = new Date(value);
            D.setDate(D.getDate() + 1);
            return ('0'+ D.getDate()).slice(-2) + '.' + ('0'+(D.getMonth() + 1)).slice(-2) + '.' + D.getFullYear();
        }else{
            return '';
        }
    }
</script>
