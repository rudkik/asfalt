<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/owner/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="body-table">
                <div class="tab-pane active">
                    <?php $siteData->titleTop = 'Завоз материалов'; ?>
                    <?php
                    $view = View::factory('ab1/owner/35/main/_shop/car/to/material/filter/statistics-daughter-material');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    echo Helpers_View::viewToStr($view);
                    ?>
                </div>
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <h3 class="pull-left">Расчетное время: <span class="text-blue">06:00</span></h3>
                    <h3 class="pull-right">Текущее время: <span class="text-blue"><?php echo date('d.m.Y H:i'); ?></span></h3>
                    <?php echo trim($data['view::_shop/car/to/material/list/statistics-daughter-material']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
