<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/ecologist/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Склад'; ?>
                <?php
                $view = View::factory('ab1/ecologist/35/main/_shop/storage/filter/statistics');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <h3 class="pull-left">Выпуск на склад</h3>
                    <h3 class="pull-right">Текущее время: <span class="text-blue"><?php echo date('d.m.Y H:i'); ?></span></h3>
                    <?php echo trim($data['view::_shop/storage/list/statistics/storage']); ?>
                </div>
                <div class="box-body table-responsive"  style="padding-top: 30px;">
                    <h3 class="pull-left">Выпуск на склад (по установкам)</h3>
                    <?php echo trim($data['view::_shop/storage/list/statistics/turn-place']); ?>
                </div>
                <div class="box-body table-responsive"  style="padding-top: 30px;">
                    <h3 class="pull-left">Реализация со склада</h3>
                    <?php echo trim($data['view::_shop/storage/list/statistics/realization']); ?>
                </div>
                <div class="box-body table-responsive" style="padding-top: 30px;">
                    <h3 class="pull-left">Остатки на складах (с учетом остатков на начало года) <span class="text-red">(ЖБИ в разработке)</span></h3>
                    <?php echo trim($data['view::_shop/storage/list/statistics/total']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
