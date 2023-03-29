<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/atc/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php echo trim($data['view::record-db/one/edit']); ?>
            </div>
        </div>
    </div>
</div>
<style>
    .select2-container {
        margin-top: -4px;
    }
</style>