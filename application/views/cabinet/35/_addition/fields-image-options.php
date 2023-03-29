<div class="row record-input record-list margin-t-15">
    <div class="col-md-3 record-title">
        <span>
            Доп. параметры
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </span>
    </div>
    <div class="col-md-9">
        <?php
        $view = View::factory('cabinet/35/_addition/options/fields');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->optionsChild = $optionsChild;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row record-input record-list margin-t-15">
    <div class="col-md-3 record-title">
        <span>
            Виды картинок
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </span>
    </div>
    <div class="col-md-9">
        <?php
        $view = View::factory('cabinet/35/_addition/image-types');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->optionsChild = $optionsChild;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>