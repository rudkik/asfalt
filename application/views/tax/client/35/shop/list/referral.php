<div class="ks-nav-body">
    <div id="referral-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#referral-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
        </div>
    </div>

    <table id="referral-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#referral-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shop/json?is_total=1&_fields[]=name&_fields[]=created_at&_fields[]=id"
           data-toolbar="#referral-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-field="name" data-sortable="true">Название</th>
            <th data-formatter="getIsDateReferral" data-field="created_at" data-sortable="true">Дата регистрации</th>
        </tr>
        </thead>
    </table>
</div>
<script>
    function getIsDateReferral(value, row) {
        if ((value !== undefined) && (value !== null) && (value !== '1970-01-01') && (value !== '1970-01-01 06:00:00')) {
            return value.replace(/(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/, '$3.$2.$1 $4:$5').replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
        }else{
            return '';
        }
    }
</script>

