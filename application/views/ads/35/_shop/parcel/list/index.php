<div id="parcel-index" class="ks-nav-body">
    <form id="parcel-index-find" style="padding-top: 10px;">
        <div class="row" style="margin: 0px">
            <div class="col-2">
                <div class="form-group">
                    <label>Дата создания от</label>
                    <input name="created_at_from" type="datetime" class="form-control" data-type="datetime">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label>Дата создания до</label>
                    <input name="created_at_to" type="datetime" class="form-control" data-type="datetime">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label>Клиент</label>
                    <input data-client="#parcel-index-shop_client_id" data-id="shop_client_name" class="form-control clients typeahead" id="shop_client_name" type="text">
                </div>
                <input id="parcel-index-shop_client_id" name="shop_client_id" value="-1" style="display: none">
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label>Статус</label>
                    <select name="parcel_status_id" class="form-control select2" style="width: 100%;">
                        <option value="-1" data-id="-1">Вывебите статус</option>
                        <option value="0" data-id="0">Без статуса</option>
                        <?php
                        $s = 'data-id="'.Request_RequestParams::getParamInt('parcel_status_id').'"';
                        echo trim(str_replace($s, $s.' selected',$siteData->replaceDatas['view::parcel-status/list/list']));
                        ?>
                    </select>
                </div>
                <input id="parcel-index-shop_client_id" name="shop_client_id" value="-1" style="display: none">
            </div>
            <div class="form-group" style="padding-top: 28px;">
                <button data-action="find" data-find="#parcel-index-find" data-table="#parcel-data-table" type="submit" class="btn btn-primary">Поиск</button>
            </div>
        </div>
    </form>
    <div id="parcel-toolbar" class="ks-datatable-toolbar">
        <div class="ks-items-block">
            <button data-action="table-refresh" data-table="#parcel-data-table" class="btn btn-primary-outline ks-solid"><span class="ks-icon fa fa-refresh"></span> <span class="ks-text">Обновить</span></button>
            <button id="parcel-new" data-action="table-new" data-table="#parcel-data-table" data-modal="#parcel-new-record" data-url="<?php echo $siteData->urlBasic; ?>/ads/shopparcel/new" class="btn btn-success-outline ks-solid"><span class="ks-icon fa fa-plus"></span> <span class="ks-text">Добавить</span></button>
            <button id="parcel-edit" data-action="table-edit" data-table="#parcel-data-table" data-modal="#parcel-edit-record" data-url="<?php echo $siteData->urlBasic; ?>/ads/shopparcel/edit" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-pencil-square-o"></span> <span class="ks-text">Редактировать</span></button>
            <?php if ($siteData->operation->getShopTableRubricID() != 2){ ?>
            <button data-action="table-delete" data-table="#parcel-data-table" data-url="<?php echo $siteData->urlBasic; ?>/ads/shopparcel/del" class="btn btn-danger-outline ks-solid"><span class="ks-icon fa fa-remove "></span> <span class="ks-text">Удалить</span></button>
            <?php } ?>
            <a style="display: none" href="<?php echo $siteData->urlBasic; ?>/ads/shopexcel/parcels<?php echo URL::query(array_merge($_POST, array('limit_page' => 0, 'page' => 0))); ?>" class="btn btn-info-outline ks-solid"><span class="ks-icon fa fa-save"></span> <span class="ks-text">Сохранить в Excel</span></a>
        </div>
    </div>
    <table id="parcel-data-table" data-action="ads-table" class="table table-striped table-bordered" width="100%"
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
           data-dlb-click-button="#parcel-edit"
           data-url="<?php echo $siteData->urlBasic; ?>/ads/shopparcel/json?is_total=1&_fields[]=warehouse_weight&_fields[]=warehouse_id&_fields[]=shop_client_name&_fields[]=address&_fields[]=price&_fields[]=text&_fields[]=tracker&_fields[]=parcel_status_name&_fields[]=weight&_fields[]=tracker_send&_fields[]=created_at&_fields[]=date_receipt_at&_fields[]=date_send&_fields[]=amount&_fields[]=paid_amount&_fields[]=id"
           data-toolbar="#parcel-toolbar" style="max-height: 460px"
    >
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true">№ посылки</th>
            <th data-field="text" data-sortable="true">Описание</th>
            <th data-field="shop_client_name" data-sortable="true">Клиент</th>
            <th data-field="address" data-sortable="true">Адрес</th>
            <th data-formatter="getAmountParcel" data-field="price" data-sortable="true">Цена посылки</th>
            <th data-field="tracker" data-sortable="true">Трекер ID</th>
            <th data-field="parcel_status_name" data-sortable="true">Статус</th>
            <th data-formatter="getAmountParcel" data-field="weight" data-sortable="true">Вес (кг)</th>
            <th data-field="tracker_send" data-sortable="true">№ отслеживания</th>
            <th data-formatter="getIsDateParcel" data-field="created_at" data-sortable="true">Создана</th>
            <th data-formatter="getIsDateParcel" data-field="date_receipt_at" data-sortable="true">Получена на склад</th>
            <th data-formatter="getIsDateParcel" data-field="date_send" data-sortable="true">Отправлен</th>
            <th data-formatter="getAmountParcel" data-field="amount" data-sortable="true">Стоимость доставки</th>
            <th data-formatter="getAmountParcel" data-field="paid_amount" data-sortable="true">Оплачено</th>
            <th data-field="warehouse_id" data-sortable="true">Номер на складе</th>
            <th data-formatter="getAmountParcel" data-field="warehouse_weight" data-sortable="true">Вес на складе</th>
        </tr>
        </thead>
    </table>
    <script>
        function getIsDateParcel(value, row) {
            if ((value !== undefined) && (value !== null) && (value !== '1970-01-01') && (value !== '1970-01-01 06:00:00')) {
                return value.replace(/(\d+)-(\d+)-(\d+)/, '$3.$2.$1').replace(' 00:00:00', '');
            }else{
                return '';
            }
        }
        function getAmountParcel(value, row) {
            if ((value !== undefined) && (value !== null)) {
                return Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(value).replace(',', '.');
            }else{
                return '';
            }
        }
    </script>
    <style>
        #parcel-index .fixed-table-toolbar{
            position: inherit;
        }
        #parcel-index .fixed-table-container{
            padding: 0px;
        }
    </style>
</div>
