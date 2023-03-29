<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shoptransportroute/save');?>">
            </span>
        </th>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportroute/index'). Func::getAddURLSortBy($siteData->urlParams, 'number'); ?>" class="link-black">Код 1С</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportroute/index'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Маршрут</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportroute/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_branch_from_id'); ?>" class="link-black">Откуда</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportroute/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_branch_to_id'); ?>" class="link-black">Куда</a>
        </th>
        <th class="text-right width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportroute/index'). Func::getAddURLSortBy($siteData->urlParams, 'distance'); ?>" class="link-black">Расстояние</a>
        </th>
        <th class="text-right width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shoptransportroute/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Расценка</a>
        </th>
        <th class="width-155"></th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/transport/route/one/index']->childs as $value) {
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
<div id="dialog-calc-route" class="modal">
    <div class="modal-dialog" style="max-width: 380px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Пересчитать расценку маршрута</h4>
            </div>
            <form id="form-add-car" action="<?php echo Func::getFullURL($siteData, '/shoptransportroute/calc'); ?>" method="get" >
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-4 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                С какой даты начать
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input id="date_from" name="date_from" type="datetime" date-type="date" class="form-control" required value="<?php echo date('d.m.Y'); ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="id" value="0" style="display: none">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary pull-right" onclick="submitCalcRoute()">Пересчитать</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    @media (min-width: 600px) {
        .modal .record-input > .record-title {
            width: 170px !important;
            float: left;
        }

        .modal .col-md-8 {
            width: calc(100% - 170px) !important;
            float: left;
        }
    }
</style>
<script>
    $('[data-action="calc-transport-route"]').click(function(e){
        e.preventDefault();

        var modal = $('#dialog-calc-route');
        modal.find('[name="id"]').val($(this).data('id')).attr('value', $(this).data('id'));

        modal.modal('show');
    });

    function submitCalcRoute(){
        var isError = false;

        var element = $('[name="date_from"]');
        if (element.val() == ''){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            var modal = $('#dialog-calc-route');

            var form = modal.find('form');
            var formData = form.serialize();

            var id = modal.find('[name="id"]').val();
            var dateFrom = modal.find('[name="date_from"]').val();
            jQuery.ajax({
                url: form.attr('action'),
                data: formData,
                type: "POST",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));
                    $('a[data-id="'+id+'"]').parent().html('<a target="_blank" data-action="calc-transport-route" href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillcar/index'); ?>?shop_transport_route_id='+id+'&date_from_equally='+dateFrom+'" class="link-red">Обработано: '+obj.count+'</a>');

                    $('#dialog-calc-route').modal('hide');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }
    }
</script>