<?php $openPHP = '<?php';
$closePHP = '?>';
?>
<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php echo $openPHP; ?>

        $view = View::factory('ab1/atc/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        <?php echo $closePHP; ?>

        <div class="tab-content">
            <div class="tab-pane active">
                <?php echo $openPHP; ?> $siteData->titleTop = '<?php echo $title; ?>'; <?php echo $closePHP; ?>

                <form action=" <?php echo $openPHP; ?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/save'); <?php echo $closePHP; ?>" method="post" style="padding-right: 5px;">
                    <?php echo $openPHP; ?> echo trim($data['view::<?php echo $pathView; ?>/one/new']); <?php echo $closePHP; ?>

                </form>
            </div>
        </div>
    </div>
</div>