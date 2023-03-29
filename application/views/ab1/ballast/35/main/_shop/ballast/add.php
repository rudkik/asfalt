<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/ballast/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Добавление балласта'; ?>
                <div style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/ballast/one/add']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
