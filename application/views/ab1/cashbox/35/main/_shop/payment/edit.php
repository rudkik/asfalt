<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/cashbox/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Счет (редактирование)'; ?>
                <form id="shoppayment" action="<?php echo Func::getFullURL($siteData, '/shoppayment/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/payment/one/edit']); ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$view = View::factory('ab1/_all/35/_shop/client/one/modal');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/cashbox/shopclient/save';
echo Helpers_View::viewToStr($view);
?>
<script>
    $(document).ready(function () {
        $('select[name="shop_client_id"]').change(function () {
            $('#client-amount').text($(this).data('amount')+' тг');
        });
    });
</script>