<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="text-right width-40">№</th>
        <th class="width-115">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_arrival'); ?>" class="link-black">Дата подачи</a>
        </th>
        <th class="width-110">Статус</th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_id.name'); ?>" class="link-black">Сырье</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_boxcar_client_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">№ вагона</a>
        </th>
        <th class="text-right width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Тоннаж</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_arrival'); ?>" class="link-black">Дата прибытия</a>
        </th>
        <th class="width-180">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'drain_zhdc_from_shop_operation_id.name'); ?>" class="link-black">Диспетчер ЖДЦ и ДС</a>
        </th>
        <th class="width-120">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_departure'); ?>" class="link-black">Дата убытия</a>
        </th>
        <th class="width-180">
            <a href="<?php echo Func::getFullURL($siteData, '/shopboxcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'drain_zhdc_to_shop_operation_id.name'); ?>" class="link-black">Диспетчер ЖДЦ и ДС</a>
        </th>
        <th class="width-105"></th>
    </tr>
    <?php
    $i = ($siteData->page - 1) * $siteData->limitPage + 1;
    foreach ($data['view::_shop/boxcar/one/index']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    ?>
</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('ab1/_all/35/paginator');
    $view->siteData = $siteData;

    $urlParams = array_merge($siteData->urlParams, $_GET, $_POST);
    $urlParams['page'] = '-pages-';

    $shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
    if($shopBranchID > 0) {
        $urlParams['shop_branch_id'] = $shopBranchID;
    }

    $url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

    $view->urlData = $siteData->urlBasic.$siteData->url.$url;
    $view->urlAction = 'href';

    echo Helpers_View::viewToStr($view);
    ?>
</div>

<script>
    $(document).ready(function () {
        $('[data-bs-toggle="modal"]').click(function (e) {
            e.preventDefault();

            var modal = $($(this).attr('href'));
            modal.modal('show');

            var id = $(this).closest('tr').data('id');
            modal.find('[name="id"]').val(id).attr('value', id);
        });
    });

    function saveArrival() {
        var form = $('#modal-arrival form');
        var url = form.attr('action');

        var formData = form.serialize();
        formData = formData + '&json=1';

        jQuery.ajax({
            url: url,
            data: formData,
            type: "GET",
            success: function (data) {
                var tr = $('tr[data-id="' + form.find('[name="id"]').val() + '"]');
                tr.find('[data-id="date_arrival"]').text(form.find('[name="date_arrival"]').val());
                tr.find('[data-id="drain_zhdc_from_shop_operation_id"]').text('<?php echo $siteData->operation->getName();?>');

                $('#modal-arrival').modal('hide');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    function saveDeparture() {
        var form = $('#modal-departure form');
        var url = form.attr('action');

        var formData = form.serialize();
        formData = formData + '&json=1';

        jQuery.ajax({
            url: url,
            data: formData,
            type: "GET",
            success: function (data) {
                var tr = $('tr[data-id="' + form.find('[name="id"]').val() + '"]');
                tr.find('[data-id="date_departure"]').text(form.find('[name="date_departure"]').val());
                tr.find('[data-id="drain_zhdc_to_shop_operation_id"]').text('<?php echo $siteData->operation->getName();?>');

                $('#modal-departure').modal('hide');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }
</script>

<div id="modal-arrival" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="title-metering" class="modal-title">Дата прибытия</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo Func::getFullURL($siteData, '/shopboxcar/save'); ?>" class="modal-fields">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Дата прибытия
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="date_arrival" type="datetime" date-type="datetime"  class="form-control" value="<?php Helpers_DateTime::getDateTimeFormatRus(Helpers_DateTime::getCurrentDateTimePHP()); ?>">
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <input name="id" value="" style="display: none">
                        <input name="drain_zhdc_from_shop_operation_id" value="<?php echo $siteData->operationID; ?>" style="display: none">
                        <button type="button" class="btn btn-primary" onclick="saveArrival();">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal-departure" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="title-metering" class="modal-title">Дата убытия</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo Func::getFullURL($siteData, '/shopboxcar/save'); ?>" class="modal-fields">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Дата убытия
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="date_departure" type="datetime" date-type="datetime"  class="form-control" value="<?php Helpers_DateTime::getDateTimeFormatRus(Helpers_DateTime::getCurrentDateTimePHP()); ?>">
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <input name="id" value="" style="display: none">
                        <input name="drain_zhdc_to_shop_operation_id" value="<?php echo $siteData->operationID; ?>" style="display: none">
                        <button type="button" class="btn btn-primary" onclick="saveDeparture();">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>