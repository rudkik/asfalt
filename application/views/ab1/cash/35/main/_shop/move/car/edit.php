<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/cash/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Перемещение (редактирование)'; ?>
                <form id="shopmovecar" action="<?php echo Func::getFullURL($siteData, '/shopmovecar/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/move/car/one/edit']); ?>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('[name="shop_client_id"]').change(function () {
            $('#client-amount').textNumber($(this).data('amount'), 2, ' тг');
        })
    });
</script>