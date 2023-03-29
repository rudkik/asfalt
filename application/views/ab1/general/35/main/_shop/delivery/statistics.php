<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/general/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Доставка'; ?>
                <?php
                $view = View::factory('ab1/general/35/main/_shop/delivery/filter/statistics');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 30px;">
                    <h3 class="pull-left">Услуги доставки продукции</h3>
                    <h3 class="pull-right">Текущее время: <span class="text-blue"><?php echo date('d.m.Y H:i'); ?></span></h3>
                    <?php echo trim($data['view::_shop/delivery/list/statistics/rubric']); ?>
                </div>
                <?php if(Request_RequestParams::getParamBoolean('shop_transport_company_id-is_own') === null){ ?>
                    <div class="box-body table-responsive" style="padding-top: 30px;">
                        <h3 class="pull-left">Перевозчик продукции</h3>
                        <?php echo trim($data['view::_shop/delivery/list/statistics/company']); ?>
                    </div>
                <?php }?>
                <div class="box-body table-responsive" style="padding-top: 30px;">
                    <h3 class="pull-left">Услуги доставки продукции по клиентам</h3>
                    <?php echo trim($data['view::_shop/delivery/list/statistics/client']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
