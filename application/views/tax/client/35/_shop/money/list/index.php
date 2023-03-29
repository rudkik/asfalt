<?php
$isCash = intval(Request_RequestParams::getParamInt('is_cash'));
$isComing = intval(Request_RequestParams::getParamInt('is_coming'));
$key = '-is_cash-'.$isCash.'-is_coming-'.$isComing; ?>
<div class="ks-nav-body">
    <div id="money<?php echo $key; ?>-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#money<?php echo $key; ?>-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="money<?php echo $key; ?>-new" data-action="table-new" data-table="#money<?php echo $key; ?>-data-table" data-modal="#money<?php echo $key; ?>-new-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmoney/new?is_cash=<?php echo $isCash; ?>&is_coming=<?php echo $isComing; ?>"  class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <div class="btn-group">
                <button id="money<?php echo $key; ?>-edit" data-action="table-edit" data-table="#money<?php echo $key; ?>-data-table" data-modal="#money<?php echo $key; ?>-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmoney/edit?is_cash=<?php echo $isCash; ?>&is_coming=<?php echo $isComing; ?>" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
                <button type="button" class="btn btn-info-outline ks-solid dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a href="#" id="money<?php echo $key; ?>-clone" data-action="table-edit" data-table="#money<?php echo $key; ?>-data-table" data-modal="#money<?php echo $key; ?>-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmoney/clone?is_cash=<?php echo $isCash; ?>&is_coming=<?php echo $isComing; ?>" class="dropdown-item">Дублировать</a>
                </div>
            </div>
            <button data-action="table-delete" data-table="#money<?php echo $key; ?>-data-table" data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmoney/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
        </div>
    </div>
    <table id="money<?php echo $key; ?>-data-table" data-action="tax-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#money<?php echo $key; ?>-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/tax/shopmoney/json?is_cash=<?php echo $isCash; ?>&is_coming=<?php echo $isComing; ?>&is_total=1&_fields[]=shop_contract_number&_fields[]=shop_contract_date&_fields[]=amount&_fields[]=date&_fields[]=text&_fields[]=shop_contractor_name&_fields[]=id"
           data-toolbar="#money<?php echo $key; ?>-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true" data-visible="false">ID</th>
            <th data-formatter="getIsDate" data-field="date" data-sortable="true">Дата</th>
            <th data-formatter="getIsAmount"  data-field="amount" data-sortable="true">Сумма</th>
            <th data-field="shop_contractor_name" data-sortable="true">Контрагент</th>
            <th data-field="shop_contract_number" data-sortable="true">№ договора</th>
            <th data-formatter="getIsDate" data-field="shop_contract_date" data-sortable="true">Дата договора</th>
            <th data-field="text" data-sortable="true">Примечание</th>
        </tr>
        </thead>
    </table>
</div>