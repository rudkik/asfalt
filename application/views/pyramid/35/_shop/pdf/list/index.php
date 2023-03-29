<div class="ks-nav-body">
    <div id="pdf-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#pdf-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="pdf-edit" data-action="table-edit" data-table="#pdf-data-table" data-modal="#pdf-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoppdf/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
        </div>
    </div>

    <table id="pdf-data-table" data-action="pyramid-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#pdf-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/pyramid/shoppdf/json?is_total=1&_fields[]=id"
           data-toolbar="#pdf-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="title" data-sortable="false">Файл</th>
        </tr>
        </thead>
    </table>
</div>

