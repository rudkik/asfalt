<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-120"></th>
        <th class="width-70">
            Фото
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_transfer'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.article'); ?>" class="link-black">Артикул</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_transfer'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_transfer'). Func::getAddURLSortBy($siteData->urlParams, 'shop_courier_id.name'); ?>" class="link-black">Курьер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_transfer'). Func::getAddURLSortBy($siteData->urlParams, 'shop_supplier_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th class="text-right width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_transfer'). Func::getAddURLSortBy($siteData->urlParams, 'price_cost'); ?>" class="link-black">Цена закупа</a>
        </th>
        <th class="text-right width-65">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_transfer'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="width-125">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_transfer'). Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_id.old_id'); ?>" class="link-black">№ заказа</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_transfer'). Func::getAddURLSortBy($siteData->urlParams, 'shop_company_id.name'); ?>" class="link-black">Компания</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_transfer'). Func::getAddURLSortBy($siteData->urlParams, 'shop_source_id.name'); ?>" class="link-black">Источник</a>
        </th>
        <th class="width-125">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock_transfer'). Func::getAddURLSortBy($siteData->urlParams, 'buy_at'); ?>" class="link-black">Дата закупа</a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/bill/item/one/stock-transfer']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php
$view = View::factory('smg/_all/35/paginator');
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
<style>
    .integrations {
        height: 53.133px;
        display: block;
        text-overflow: clip;
        overflow: hidden;
        max-width: 250px;
    }
</style>
<script>
    $(document).ready(function () {
        $('[data-action="accept-transfer"]').click(function (e) {
            e.preventDefault();

            var td = $(this).closest('td');

            jQuery.ajax({
                url: $(this).attr('href'),
                data: ({}),
                type: "GET",
                success: function (data) {
                    td.html('<b class="text-blue">Принят</b>');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });
    });
</script>
