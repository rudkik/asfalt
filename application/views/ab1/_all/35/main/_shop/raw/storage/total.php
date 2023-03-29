<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/' . $siteData->actionURLName . '/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <h3>Остатки сырьевого парка</h3>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/raw/storage/group/list/total-show']); ?>
                    <?php echo trim($data['view::_shop/raw/storage/list/total-table']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
