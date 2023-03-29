<div class="ks-nav-body">
    <div id="bank-account-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#bank-account-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="bank-account-new" data-action="table-new" data-table="#bank-account-data-table" data-modal="#bank-account-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbankaccount/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="bank-account-edit" data-action="table-edit" data-table="#bank-account-data-table" data-modal="#bank-account-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbankaccount/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#bank-account-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbankaccount/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="bank-account-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#bank-account-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbankaccount/json?is_total=1&is_public_ignore=1&_fields[]=bank_name&_fields[]=iik&_fields[]=id"
           data-toolbar="#bank-account-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="bank_name" data-sortable="true">Банк</th>
            <th data-field="iik" data-sortable="true">ИИК</th>
        </tr>
        </thead>
    </table>
</div>

