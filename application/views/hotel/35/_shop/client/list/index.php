<div class="ks-nav-body">
    <div id="client-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#client-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="client-new" data-action="table-new" data-table="#client-data-table" data-modal="#client-new-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopclient/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="client-edit" data-action="table-edit" data-table="#client-data-table" data-modal="#client-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopclient/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <?php if ($siteData->operation->getShopTableRubricID() == 1){ ?>
            <button data-action="table-delete" data-table="#client-data-table" data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopclient/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
            <?php } ?>
        </div>
    </div>

    <table id="client-data-table" data-action="hotel-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#client-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/hotel/shopclient/json?is_total=1&_fields[]=amount&_fields[]=block_amount&_fields[]=phone&_fields[]=name&_fields[]=id"
           data-toolbar="#client-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">ФИО</th>
            <th data-field="phone" data-sortable="true">Телефон</th>
            <th data-formatter="getIsBalance" data-field="amount" data-sortable="true">Баланс</th>
        </tr>
        </thead>
    </table>
</div>
<script>
    function getIsBalance(value, row) {
        if((row['block_amount'] === undefined) || (row['block_amount'] === null)){
            var amount = value;
        }else{
            var amount = value - row['block_amount'];
        }

        return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(amount).replace(',', '.');
    }
</script>

