<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialdensity/index'). Func::getAddURLSortBy($siteData->urlParams, 'date'); ?>" class="link-black">Дата</a>
        </th>
        <th>
            Поставщик
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialdensity/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_material_id.name'); ?>" class="link-black">Материал</a> /

            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialdensity/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_raw_id.name'); ?>" class="link-black">Сырье</a>
        </th>
        <th class="width-90 text-right"">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialdensity/index'). Func::getAddURLSortBy($siteData->urlParams, 'density'); ?>" class="link-black">Плотность</a>
        </th>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialdensity/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_from'); ?>" class="link-black">Срок от</a>
        </th>
        <th class="width-85">
            <a href="<?php echo Func::getFullURL($siteData, '/shopmaterialdensity/index'). Func::getAddURLSortBy($siteData->urlParams, 'date_to'); ?>" class="link-black">Срок до</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/material/density/one/index']->childs as $value) {
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
    $('[data-action="calc-stock"]').click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href');
        var el = $(this).parents('tr').find('[data-id="stock"]');

        jQuery.ajax({
            url: url,
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                el.htmlNumber(obj.quantity, 3);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });

</script>