<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="width-110">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">№ заказа</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_source_id.name'); ?>" class="link-black">Источник</a>
        </th>
        <th class="width-125">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'approve_source_at'); ?>" class="link-black">Дата создания</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'delivery_plan_at'); ?>" class="link-black">Дата доставки</a>
        </th>
        <th class="width-140">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_status_source_id.name'); ?>" class="link-black">Статус</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'buyer'); ?>" class="link-black">Покупатель</a>,
            <a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'delivery_address'); ?>" class="link-black">адрес доставки</a>
        </th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-black">Продукты источника</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'products'); ?>" class="link-black">Продукты</a>
        </th>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_payment_type_id.name'); ?>" class="link-black">Способ оплаты</a>
            <br><a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_bill_delivery_type_id.name'); ?>" class="link-black">Способ доставки</a>
        </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'amount'); ?>" class="link-black">Сумма</a>
        </th>
        <th class="width-150">
            <a href="<?php echo Func::getFullURL($siteData, '/shopbill/index'). Func::getAddURLSortBy($siteData->urlParams, 'shop_courier_id.name'); ?>" class="link-black">Курьер</a>
        </th>
        <th class="width-105"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/bill/one/index']->childs as $value) {
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
<script>
    $(document).ready(function () {
        $('[data-action="set-courier"]').click(function (e) {
            e.preventDefault();

            var tr = $(this).closest('tr');

            var modal = $('#modal-courier');
            modal.modal('show');

            modal.find('form').attr('action', $(this).attr('href'));

            modal.find('h4.text-blue [data-id="number"]').text(tr.find('[data-id="name"]').text());
        });
    });
</script>
<div id="modal-courier" class="modal fade">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Назначить курьера</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-blue" style="margin: 0 0 20px;">Заказ №<span data-id="number"></span></h4>
                <div class="form-group">
                    <label for="shop_courier_id">Курьер</label>
                    <select data-type="select2" id="shop_courier_id" name="shop_courier_id" class="form-control select2" required style="width: 100%;">
                        <option value="-1" data-id="-1">Выберите значение</option>
                        <?php echo trim($siteData->replaceDatas['view::_shop/courier/list/list']);?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
                <button type="submit" class="btn btn-primary">Установить</button>
            </div>
        </form>
    </div>
</div>
