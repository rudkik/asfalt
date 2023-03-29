<?php
$view = View::factory('cabinet/35/main/shopbills/report-cancel-filter');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>


<section class="content bg-white">
    <?php
    $view = View::factory('cabinet/35/main/shopbills/report-cancel-table');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</section>
