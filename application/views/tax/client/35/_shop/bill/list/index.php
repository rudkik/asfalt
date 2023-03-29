<div class="ks-nav-body">
    <div id="bill-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#bill-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="bill-show" data-action="table-edit" data-table="#bill-data-table" data-modal="#bill-show-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbill/show"  class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Просмотр</span></button>
            <button data-action="table-delete" data-table="#bill-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbill/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>

    <table id="bill-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#bill-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopbill/json?is_total=1&_fields[]=amount&_fields[]=paid_at&_fields[]=created_at&_fields[]=shop_good_name&_fields[]=id"
           data-toolbar="#bill-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true">№ счета</th>
            <th data-formatter="getIsDate" data-field="created_at" data-sortable="true">Дата</th>
            <th data-formatter="getIsAmount"  data-field="amount" data-sortable="true">Сумма</th>
            <th data-field="shop_good_name" data-sortable="true">Услуга</th>
            <th data-formatter="getPaid" data-field="paid_at" data-sortable="true">Оплата</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    function getPaid(value, row) {
        if ((value !== undefined) && (value !== null)) {
            return '<span class="ks-color-success">Оплачено</span><br><b>' + value.replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '')+'</b>';
        }else{
            return '<span class="ks-color-danger">Не оплачено <span class="fa fa-warning ks-icon"></span></span><br><a href="<?php echo $siteData->urlBasic; ?>/tax/site/pays?shop_bill_id='+row['id']+'" class="btn btn-info btn-sm">Оплатить</a>';
        }
    }
</script>

