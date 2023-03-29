<div class="ks-nav-body">
    <div id="tax-return-910-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#tax-return-910-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="tax-return-910-new" data-action="table-new" data-table="#tax-return-910-data-table" data-modal="#tax-return-910-data-new-data-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoptaxreturn910/new_data"  class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="tax-return-910-edit" data-action="table-edit" data-table="#tax-return-910-data-table" data-modal="#tax-return-910-data-edit-data-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoptaxreturn910/edit_data" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-id="tax-return-910-show" id="tax-return-910-edit" data-action="table-edit" data-table="#tax-return-910-data-table" data-modal="#tax-return-910-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoptaxreturn910/edit_form" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Просмотр</span></button>
            <button data-action="table-delete" data-table="#tax-return-910-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoptaxreturn910/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
            <button hidden data-action="table-record-refresh" data-table="#tax-return-910-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoptaxreturn910/send_tax" class="btn btn-danger-outline ks-solid"><span class="ks-text">Сдать в налоговую</span></button>
            <a data-action="table-download" data-table="#tax-return-910-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shoptaxreturn910/save_pdf" href="#" type="button" class="btn btn-info-outline ks-solid">Печать PDF</a>
        </div>
    </div>

    <table id="tax-return-910-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#tax-return-910-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shoptaxreturn910/json?is_total=1&_fields[]=tax_status_name&_fields[]=ikpn&_fields[]=opv&_fields[]=so&_fields[]=ipn&_fields[]=osms&_fields[]=sn&_fields[]=revenue&_fields[]=created_at&_fields[]=half_year&_fields[]=year&_fields[]=id"
           data-toolbar="#tax-return-910-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-formatter="getIsDate" data-field="created_at" data-sortable="true">Дата создания</th>
            <th data-field="half_year" data-sortable="true">Полугодие</th>
            <th data-field="year" data-sortable="true">Год</th>
            <th data-formatter="getIsAmount" data-field="revenue" data-sortable="true">Доход</th>
            <th data-formatter="getIsAmount" data-field="ikpn" data-sortable="true">ИКПН</th>
            <th data-formatter="getIsAmount" data-field="opv" data-sortable="true">ОПВ</th>
            <th data-formatter="getIsAmount" data-field="so" data-sortable="true">СО</th>
            <th data-formatter="getIsAmount" data-field="ipn" data-sortable="true">ИПН</th>
            <th data-formatter="getIsAmount" data-field="osms" data-sortable="true">ОСМС</th>
            <th data-formatter="getIsAmount" data-field="sn" data-sortable="true">СН</th>
            <th data-field="tax_status_name" data-sortable="true">Статус налоговой</th>
        </tr>
        </thead>
    </table>
</div>