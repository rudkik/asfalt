<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="width-30"></th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduction/stock'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Продукт</a>
        </th>
        <th>Рубрика</th>
        <th>Ед. измерения</th>
        <th class="width-95 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduction/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_production_stock_id.quantity_balance'); ?>" class="link-black">На складе</a>
        </th>
        <th class="width-110 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopproduction/stock'). Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-black">Цена</a>
        </th>
        <th class="tr-header-buttom"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/production/one/stock']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-top-5px">
    <?php
    $view = View::factory('magazine/bar/35/paginator');
    $view->siteData = $siteData;

    $urlParams = $siteData->urlParams;
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

                var stock = Intl.NumberFormat('ru-RU', {maximumFractionDigits: 3}).format(obj.coming - obj.expense).replace(',', '.');
                el.html(stock);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });

</script>
