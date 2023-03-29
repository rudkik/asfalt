<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="width-80">
            <a href="<?php echo Func::getFullURL($siteData, '/shopplanitem/reason'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopplanitem/reason'). Func::getAddURLSortBy($siteData->urlParams, 'shop_client_id.name'); ?>" class="link-black">Клиент</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopplanitem/reason'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Продукт</a>
        </th>
        <th class="width-78 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopplanitem/reason'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">План</a>
        </th>
        <th class="width-78 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopplanitem/reason'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_actual'); ?>" class="link-black">Факт</a>
        </th>
        <th style="max-width: 280px; width: 280px">Причина</th>
    </tr>
    <?php
    foreach ($data['view::_shop/plan/item/one/reason']->childs as $value) {
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
<script>
    $('select[data-action="set-plan-reason-type"]').change(function (e) {
        var planReasonTypeID = $(this).val();
        var url = $(this).data('href');

        jQuery.ajax({
            url: url,
            data: ({
                'plan_reason_type_id': (planReasonTypeID),
                'json': true
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });


</script>

