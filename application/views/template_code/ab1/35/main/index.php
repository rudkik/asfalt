<?php
$openPHP = '<?php';
$closePHP = '?>';
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php  echo $openPHP; ?> $view = View::factory('<?php echo $projectName . DIRECTORY_SEPARATOR . $interfaceName; ?>/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);<?php echo $closePHP; ?>

        <div class="tab-content">
            <div class="tab-pane active">
                <?php  echo $openPHP; ?> $siteData->titleTop = '<?php echo $title; ?>';<?php echo $closePHP; ?>

                <?php  echo $openPHP; ?> $view = View::factory('<?php echo $projectName . DIRECTORY_SEPARATOR . $interfaceName; ?>/35/main/<?php echo $pathView; ?>/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);<?php echo $closePHP; ?>

            </div>
                <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="<?php  echo $openPHP; ?> if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}<?php echo $closePHP; ?>"><a href="<?php echo $openPHP; ?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1));<?php echo $closePHP; ?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                        <li class="<?php  echo $openPHP; ?> if(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){echo 'active';}<?php echo $closePHP; ?>"><a href="<?php echo $openPHP; ?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/index', array(), array('is_not_public' => 1));<?php echo $closePHP; ?>" data-id="is_not_public">Неактивные</a></li>
                        <li class="<?php  echo $openPHP; ?> if(Arr::path($siteData->urlParams, 'is_public', '') == 1){echo 'active';}<?php echo $closePHP; ?>"><a href="<?php echo $openPHP; ?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/index', array(), array('is_public' => 1));<?php echo $closePHP; ?>" data-id="is_public">Активные</a></li>
                        <li class="<?php  echo $openPHP; ?> if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';} <?php echo $closePHP; ?>"><a href=" <?php echo $openPHP; ?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/index', array(), array('is_public_ignore' => 1)); <?php echo $closePHP; ?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                        <li class="pull-left header">
                            <a href="<?php  echo $openPHP; ?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/new', array()); <?php echo $closePHP; ?>" class="btn bg-purple btn-flat">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить
                            </a>
                        </li>
                    </ul>
                </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php  echo $openPHP; ?> echo trim($data['view::<?php echo $pathView; ?>/list/index']); <?php echo $closePHP; ?>
                </div>
            </div>
        </div>
	</div>
</div>
