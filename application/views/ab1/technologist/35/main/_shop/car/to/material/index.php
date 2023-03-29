<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/technologist/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-3">
                        <h3>Материалы</h3>
                    </div>
                    <div class="col-md-3 pull-right">
                        <input data-type="auto-number" id="find_number" type="text" class="form-control text-number" placeholder="Номер авто">
                    </div>
                </div>
                <?php
                $view = View::factory('ab1/technologist/35/main/_shop/car/to/material/filter/index');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="tab-content">
                <div class="body-table">
                    <div class="box-body table-responsive" style="padding-top: 0px;">
                        <?php echo trim($data['view::_shop/car/to/material/list/index']); ?>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
