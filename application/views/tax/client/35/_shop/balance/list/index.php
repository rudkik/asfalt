<div class="ks-nav-body">
    <div id="balance-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#balance-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="balance-new" data-action="table-new" data-table="#balance-data-table" data-modal="#balance-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbalance/new"  class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="balance-edit" data-action="table-edit" data-table="#balance-data-table" data-modal="#balance-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbalance/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#balance-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbalance/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="balance-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#balance-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbalance/json?is_total=1&_fields[]=amount&_fields[]=date&_fields[]=text&_fields[]=shop_contractor_name&_fields[]=id"
           data-toolbar="#balance-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-formatter="getIsDate" data-field="date" data-sortable="true">Дата</th>
            <th data-formatter="getIsAmount"  data-field="amount" data-sortable="true">Сумма</th>
            <th data-field="shop_contractor_name" data-sortable="true">Контрагент</th>
            <th data-field="text" data-sortable="true">Примечание</th>
        </tr>
        </thead>
    </table>
</div>