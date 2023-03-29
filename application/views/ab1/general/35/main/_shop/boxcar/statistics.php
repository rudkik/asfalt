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
                <?php $siteData->titleTop = 'Приём вагонов'; ?>
                <?php
                $view = View::factory('ab1/general/35/main/_shop/boxcar/filter/statistics');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 30px;">
                    <h3 class="pull-left">Отгружено (в пути)</h3>
                    <h3 class="pull-right">Текущее время: <span class="text-blue"><?php echo date('d.m.Y H:i'); ?></span></h3>
                    <?php echo trim($data['view::_shop/boxcar/list/in-transit']); ?>
                </div>
                <div class="box-body table-responsive" style="padding-top: 30px;">
                    <h3 class="pull-left">Получено</h3>
                    <?php echo trim($data['view::_shop/boxcar/list/statistics']); ?>
                </div>
                <div class="box-body table-responsive" style="padding-top: 30px;">
                    <h3 class="pull-left">На разгрузке (на территории завода)</h3>
                    <?php echo trim($data['view::_shop/boxcar/list/unload']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
