<div class="ks-nav-body">
    <div id="consumable-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#consumable-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="consumable-new" data-action="table-new" data-table="#consumable-data-table" data-modal="#consumable-new-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopconsumable/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="consumable-edit" data-action="table-edit" data-table="#consumable-data-table" data-modal="#consumable-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopconsumable/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <?php if ($siteData->operation->getShopTableRubricID() == 1){ ?>
            <button data-action="table-delete" data-table="#consumable-data-table" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopconsumable/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
            <?php } ?>
            <div class="btn-group">
                <a data-action="table-download" data-table="#consumable-order-data-table" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/consumable?" href="#" type="button" class="btn btn-info-outline ks-solid">Печать</a>
                <button type="button" class="btn btn-info-outline ks-solid dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a data-action="table-download" data-table="#consumable-data-table" class="dropdown-item" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopexcel/consumable?" href="#">Расходник</a>
                </div>
            </div>
        </div>
    </div>

    <table id="consumable-data-table" data-action="hotel-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#consumable-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopconsumable/json?is_total=1&_fields[]=created_at&_fields[]=update_user_name&_fields[]=number&_fields[]=from_at&_fields[]=to_at&_fields[]=amount&_fields[]=id"
           data-toolbar="#consumable-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="number" data-sortable="true">Номер</th>
            <th data-formatter="getIsDate" data-field="created_at" data-sortable="true">Дата создания</th>
            <th data-formatter="getIsDate" data-field="from_at" data-sortable="true">Период от</th>
            <th data-formatter="getIsDate" data-field="to_at" data-sortable="true">Период до</th>
            <th data-formatter="getAmount" data-field="amount" data-sortable="true">Сумма</th>
            <th data-field="update_user_name" data-sortable="true">Кто редактировал</th>
        </tr>
        </thead>
    </table>
</div>
<script>
    function getIsDate(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return value.replace(/(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/, '$3.$2.$1 $4:$5').replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
        }else{
            return '';
        }
    }
    function getAmount(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.');
        }else{
            return '';
        }
    }
</script>

