<div class="ks-nav-body">
    <div id="person-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#person-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="person-new" data-action="table-new" data-table="#person-data-table" data-modal="#person-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopperson/new"  class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="person-edit" data-action="table-edit" data-table="#person-data-table" data-modal="#person-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopperson/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#person-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopperson/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="person-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#person-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopperson/json?is_total=1&_fields[]=date_from&_fields[]=number&_fields[]=issued_by&_fields[]=name&_fields[]=id"
           data-toolbar="#person-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">ФИО</th>
            <th data-field="number" data-sortable="true">№ удостоверения личности</th>
            <th data-formatter="getIsDate" data-field="date_from" data-sortable="true">Дата выдачи</th>
            <th data-field="issued_by" data-sortable="true">Кем выдано</th>
        </tr>
        </thead>
    </table>
</div>

