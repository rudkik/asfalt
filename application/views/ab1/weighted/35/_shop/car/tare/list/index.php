<?php $tareTypeID = Request_RequestParams::getParamInt('tare_type_id'); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-90">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartare/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartare/index'). Func::getAddURLSortBy($siteData->urlParams, 'driver'); ?>" class="link-black">Водитель</a>
        </th>
        <?php if($tareTypeID == Model_Ab1_TareType::TARE_TYPE_CLIENT){ ?>
            <th>
                <a href="<?php echo Func::getFullURL($siteData, '/shopcartare/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
            </th>
        <?php }else{ ?>
            <th>
                <a href="<?php echo Func::getFullURL($siteData, '/shopcartare/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_company_id.name'); ?>" class="link-black">Транспортная компания</a>
            </th>
            <th>
                <a href="<?php echo Func::getFullURL($siteData, '/shopcartare/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_transport_id.name'); ?>" class="link-black">Транспорт АТЦ</a>
            </th>
        <?php } ?>
        <th class="width-65 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartare/index'). Func::getAddURLSortBy($siteData->urlParams, 'weight'); ?>" class="link-black">Вес</a>
        </th>
        <th class="width-155">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcartare/index'). Func::getAddURLSortBy($siteData->urlParams, 'updated_at'); ?>" class="link-black">Дата взвешивания</a>
        </th>
        <th style="width: 110px"></th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/tare/one/index']->childs as $value) {
        echo $value->str;
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

<div id="modal-tare" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Изменить тару</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo Func::getFullURL($siteData, '/shopmaterialmoisture/save'); ?>" class="modal-fields">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Тара
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input data-type="money" data-fractional-length="3" name="weight" type="text" class="form-control" placeholder="Тара" readonly>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <input name="id" value="" style="display: none">
                        <input name="is_test" value="" style="display: none">
                        <button type="button" class="btn btn-primary" onclick="saveTare();">Зафиксировать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function sendTarra(id) {
        var el = $('#weight-'+id);

        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                try {
                    var isTest = objTarra.is_test;
                } catch (err) {
                    isTest = 0;
                }

                var form = $('#modal-tare form');
                form.find('[name="id"]').val(id);
                form.find('[name="weight"]').valNumber(obj.weight);
                form.find('[name="is_test"]').val(isTest);

                $('#modal-tare').modal('show');
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });
    }

    function saveTare() {
        var form = $('#modal-tare form');
        var url = form.attr('action');

        var formData = form.serialize();
        formData = formData + '&json=1';

        var id = form.find('[name="id"]').val();

        jQuery.ajax({
            url: '/weighted/shopcartare/save',
            data: formData,
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                $('#weight-'+id).html(obj.values.weight);
                $('#modal-tare').modal('hide');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    var findCar=function(){
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                var number = obj.number;
                tr = $('td[data-number="'+number+'"]');
                if(tr.length > 0){
                    tr = tr.parent();
                    if (tr.attr('scroll') != 1) {
                        tr.removeAttr('style');
                        tr.removeAttr('scroll');

                        if (obj.coefficient > 89.9) {
                            tr.css('background-color', '#cbf7ab');
                        }else{
                            tr.css('background-color', '#fae873');
                        }
                        $('html, body').animate({ scrollTop: tr.offset().top }, 500);
                        tr.attr('scroll', 1);
                    }
                }else{
                    tr.removeAttr('style');
                    tr.removeAttr('scroll');
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
        setTimeout(arguments.callee, 3000);
    }

    setTimeout(findCar, 3000);
</script>
