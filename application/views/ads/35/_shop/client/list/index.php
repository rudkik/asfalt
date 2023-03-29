<div class="ks-nav-body">
    <div id="client-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#client-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="client-new" data-action="table-new" data-table="#client-data-table" data-modal="#client-new-record" data-url="<?php echo $siteData->urlBasic; ?>/ads/shopclient/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="client-edit" data-action="table-edit" data-table="#client-data-table" data-modal="#client-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/ads/shopclient/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <button data-action="table-delete" data-table="#client-data-table" data-url="<?php echo $siteData->urlBasic; ?>/ads/shopclient/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
            <button data-action="table-edit" data-table="#client-data-table" data-modal="#client-history-record" data-url="<?php echo $siteData->urlBasic; ?>/ads/shopclient/history" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">История</span></button>
            <a style="display: none" href="<?php echo $siteData->urlBasic; ?>/ads/shopexcel/clients<?php echo URL::query(array_merge($_POST, array('limit_page' => 0, 'page' => 0))); ?>" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-save"></span> <span class="ks-text">Сохранить в Excel</span></a>
        </div>
    </div>

    <table id="client-data-table" data-action="ads-table" class="table table-striped table-bordered" width="100%"
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
           data-url="<?php echo $siteData->urlBasic; ?>/ads/shopclient/json?is_total=1&_fields[]=address_code&_fields[]=created_at&_fields[]=delivery_amount&_fields[]=phone&_fields[]=name&_fields[]=email&_fields[]=id"
           data-toolbar="#client-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">ФИО</th>
            <th data-field="phone" data-sortable="true">Телефон</th>
            <th data-field="email" data-sortable="true">E-mail</th>
            <th data-formatter="getAmountClient" data-field="delivery_amount" data-sortable="true">Стоимость доставки</th>
            <th data-field="address_code" data-sortable="true">Адрес код</th>
            <th data-formatter="getIsDateClient" data-field="created_at" data-sortable="true">Дата регистрации</th>
        </tr>
        </thead>
    </table>
    <script>
        function getAmountClient(value, row) {
            if ((value !== undefined) && (value !== null)) {
                return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.');
            }else{
                return '';
            }
        }
        function getIsDateClient(value, row) {
            if ((value !== undefined) && (value !== null) && (value !== '1970-01-01') && (value !== '1970-01-01 06:00:00')) {
                return value.replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
            }else{
                return '';
            }
        }
    </script>
</div>

