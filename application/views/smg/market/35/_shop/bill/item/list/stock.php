<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-125">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_id.old_id'); ?>" class="link-black">№ заказа</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_company_id.name'); ?>" class="link-black">Компания</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_source_id.name'); ?>" class="link-black">Источник</a>
        </th>
        <th class="width-125">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_id.approve_source_at'); ?>" class="link-black">Дата создания</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'buy_at'); ?>" class="link-black">Дата закупа</a>
        </th>
        <th class="width-70">
            Фото
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.article'); ?>" class="link-black">Артикул</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_product_id.name'); ?>" class="link-black">Название</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_courier_id.name'); ?>" class="link-black">Курьер</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'new_shop_courier_id.name'); ?>" class="link-black">Новый курьер</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'shop_supplier_id.name'); ?>" class="link-black">Поставщик</a>
        </th>
        <th class="text-right width-110">
            <a style="font-size: 11px" href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-black">Цена продажи</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'price_cost'); ?>" class="link-black">Цена закупа</a>
        </th>
        <th class="text-right width-80" style="font-size: 11px;">
            Коммисии
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'commission_supplier'); ?>" class="link-black">перевода</a>,
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'commission_source'); ?>" class="link-black">источника</a>
        </th>
        <th class="text-right width-65">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="text-right width-80" style="font-size: 11px;">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'delivery_amount'); ?>" class="link-black">Стоимость доставки</a>
        </th>
        <th class="text-right width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Стоимость</a>
        </th>
        <th class="text-right width-100">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'amount_cost'); ?>" class="link-black">Себест.</a>
        </th>
        <th class="text-right width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillitem/stock'). Func::getAddURLSortBy($siteData->urlParams, 'profit'); ?>" class="link-black">Доход</a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php echo trim($siteData->globalDatas['view::_shop/bill/item/one/stock-total']); ?>
    <?php
    foreach ($data['view::_shop/bill/item/one/stock']->childs as $value) {
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
        $('[data-status]').click(function (e) {
            e.preventDefault();

            var tr = $(this).closest('tr');

            var modal = $('#modal-status');
            modal.modal('show');

            modal.find('form').attr('action', $(this).attr('href'));

            modal.find('[name="shop_supplier_id"]').val(tr.data('supplier'));
            modal.find('[name="quantity"]').val(tr.data('quantity'));
            modal.find('[name="price_cost"]').val(tr.data('price_cost'));
            modal.find('[name="shop_bill_item_status_id"]').val($(this).data('status'));

            if($(this).data('status') == <?php echo Model_AutoPart_Shop_Bill_Item_Status::STATUS_TO_BOOK; ?>){
                modal.find('.modal-title').text('Забронированно у поставщика');
            }
            if($(this).data('status') == <?php echo Model_AutoPart_Shop_Bill_Item_Status::STATUS_OUT_OF_STOCK; ?>){
                modal.find('.modal-title').text('Нет в наличие у поставщика');
            }
            modal.find('h4.text-blue').text(tr.find('[data-id="name"]').text());
        });
    });
</script>
<div id="modal-status" class="modal fade">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Статус</h4></div>
            <div class="modal-body">
                <h4 class="text-blue" style="margin: 0 0 20px;"></h4>
                <div class="form-group">
                    <label for="shop_supplier_id">Поставщик</label>
                    <select data-type="select2" id="shop_supplier_id" name="shop_supplier_id" class="form-control select2" required style="width: 100%;">
                        <option value="-1" data-id="-1">Выберите значение</option>
                        <?php echo trim($siteData->replaceDatas['view::_shop/supplier/list/list']);?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Кол-во</label>
                    <input name="quantity" type="text" class="form-control" placeholder="Кол-во" required>
                </div>
            </div>
            <div class="modal-footer">
                <input name="url" value="<?php echo htmlspecialchars(Func::getFullURL($siteData, '/shopbillitem/need_buy') .URL::query(), ENT_QUOTES); ?>" style="display: none">
                <input name="shop_bill_item_status_id" value="" style="display: none">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button type="submit" class="btn btn-primary">Установить</button>
            </div>
        </form>
    </div>
</div>
