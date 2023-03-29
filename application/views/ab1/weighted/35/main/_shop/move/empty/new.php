<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/weighted/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Пустая машина (добавление)'; ?>
                <form id="shopcar" action="<?php echo Func::getFullURL($siteData, '/shopmoveempty/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/move/empty/one/new']); ?>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#shop_car_tare_id').change(function () {
            var el = $('#shop_car_tare_id option[data-id="' + $(this).val() + '"]');
            var driver = el.data('driver');
            $('input[name="shop_driver_name"]').val(driver);
            $('[name="shop_transport_company_id"]').val(el.data('shop_transport_company_id')).trigger('change');

            var brutto = Number($('#brutto').val());
            var tarra = Number(el.data('weight'));
            $('#netto').valNumber(brutto - tarra, 3);
        })
    });
</script>
