<?php
$childs = $data['view::View_Hotel_Shop_Room\hotel'];
$childs->runIndex();

$view = View::factory('2018/07/18/3576/35/View_Hotel_Shop_Room/hotel');
$view->siteData = $siteData;
?>
<div class="col-sm-12"><h4>1 этаж</h4></div>
<div class="col-sm-6">
    <div class="box-room">
        <div class="room no-active">
            <p class="number">Столовая/магазин</p>
        </div>
    </div>
    <?php
    $view->data = $childs->childs[2005];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[2006];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3764];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3779];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3781];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3783];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3785];
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="col-sm-6">
    <div class="box-room">
        <div class="room no-active">
            <p class="number">Столовая/администрация</p>
        </div>
    </div>
    <div class="box-room">
        <div class="room no-active">
            <p class="number">Служебная<br> комната</p>
        </div>
    </div>
    <?php
    $view->data = $childs->childs[2015];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3778];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3780];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3782];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3784];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3786];
    echo Helpers_View::viewToStr($view);
    ?>
</div>

<div class="col-sm-12"><h4>2 этаж</h4></div>
<div class="col-sm-6">
    <div class="box-room">
        <div class="room no-active">
            <p class="number">Бильярд</p>
        </div>
    </div>
    <?php
    $view->data = $childs->childs[3787];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3789];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3791];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3793];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3795];
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="col-sm-6">
    <?php
    $view->data = $childs->childs[3788];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3790];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3792];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3794];
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view->data = $childs->childs[3796];
    echo Helpers_View::viewToStr($view);
    ?>
</div>