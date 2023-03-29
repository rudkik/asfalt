<div class="ks-nav-body">
    <div id="confidant-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#confidant-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button data-toggle="modal" data-target="#confidant-new-record" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="confidant-edit" data-action="table-edit" data-table="#confidant-data-table" data-modal="#confidant-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopconfidant/edit"  class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#confidant-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopconfidant/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="confidant-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#confidant-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopconfidant/json?is_total=1&_fields[]=passport_number&_fields[]=name&_fields[]=passport_date&_fields[]=passport_issued&_fields[]=id"
           data-toolbar="#confidant-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">ФИО</th>
            <th data-field="passport_number" data-sortable="true">№ удостоверения личности</th>
            <th data-formatter="getIsDate" data-field="passport_date" data-sortable="true">Дата выдачи</th>
            <th data-field="passport_issued" data-sortable="true">Кем выдан</th>
        </tr>
        </thead>
    </table>
</div>

