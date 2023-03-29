<table class="table table-hover table-db table-tr-line" style="min-height: 300px">
    <tr>
        <th class="tr-header-date">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/shipment'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">№ авто</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th class="tr-header-amount">
            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/index'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Вес</a>
        </th>
        <th style="width: 173px;"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/car/one/shipment']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12">
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
    function sendApply(id, type){
        $('button[name="turn"]').attr('style', 'display: none');
        $('button[name="apply"]').attr('style', '');

        $('#' + id + ' button[name="turn"]').attr('style', '');
        $('#' + id + ' button[name="apply"]').attr('style', 'display: none');
    }
    function sendTurn(id, shopTurnID, type){
        var url = '/asu/shopcar/save';
        if (type == <?php echo Model_Ab1_Shop_Move_Car::TABLE_ID; ?>){
            url = '/asu/shopmovecar/save';
        }else if (type == <?php echo Model_Ab1_Shop_Defect_Car::TABLE_ID; ?>){
            url = '/asu/shopdefectcar/save';
        }

        jQuery.ajax({
            url: url,
            data: ({
                'id': (id),
                'shop_turn_id': (shopTurnID),
                'json': true
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if (!obj.error) {
                    //$('#' + id).remove();
                    window.location.reload();
                }else{
                    alert(obj.msg);
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    $('[data-action="auto-transfer"]').click(function() {
        var href = $(this).attr('href');
        var parent = $(this).parent().parent().parent().parent().parent();
        jQuery.ajax({
            url: href,
            data: ({
                json: (1),
            }),
            type: "GET",
            success: function (data) {
                parent.remove();
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return false;
    });
</script>


