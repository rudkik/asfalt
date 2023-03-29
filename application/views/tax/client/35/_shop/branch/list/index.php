<div class="ks-nav-body">
    <div id="branch-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#branch-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button style="display: none" id="branch-new" data-action="table-new" data-table="#branch-data-table" data-modal="#branch-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbranch/new"  class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="branch-edit" data-action="table-edit" data-table="#branch-data-table" data-modal="#branch-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbranch/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Просмотр</span></button>
            <button data-action="table-delete" data-table="#branch-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbranch/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="branch-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#branch-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbranch/json?is_total=1&_fields[]=name&_fields[]=created_at&_fields[]=referral_shop_name&_fields[]=shop_operation_email&_fields[]=options.phone&_fields[]=id"
           data-toolbar="#branch-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">Название</th>
            <th data-field="options.phone">Телефон</th>
            <th data-formatter="getIsDate" data-field="created_at" data-sortable="true">Дата регистрации</th>
            <th data-field="referral_shop_name" data-sortable="true">Реферал</th>
            <th data-field="shop_operation_email">E-mail</th>
        </tr>
        </thead>
    </table>
</div>