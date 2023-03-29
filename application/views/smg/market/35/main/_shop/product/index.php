<div class="tab-pane active">
    <?php $siteData->titleTop = 'Товары'; ?>
    <?php
    $view = View::factory('smg/market/35/main/_shop/product/filter/index');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index', array(), array('is_public' => null, 'is_not_public' => null, 'is_delete' => 1, 'is_public_ignore' => 1), [], true);?>" data-id="is_delete_public_ignore">Удаленные</a></li>
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index', array(), array('is_public' => null, 'is_delete' => null, 'is_public_ignore' => null, 'is_not_public' => 1), [], true);?>" data-id="is_not_public">Неактивные</a></li>
        <li class="<?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index', array(), array('is_delete' => null, 'is_public_ignore' => null, 'is_not_public' => null, 'is_public' => 1), [], true);?>" data-id="is_public">Активные</a></li>
        <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/index', array(), array('is_delete' => null, 'is_delete' => null, 'is_not_public' => null, 'is_public_ignore' => 1), [], true);?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
        <li class="pull-left header">
            <span style="margin-right: 10px">
                <a href="<?php echo Func::getFullURL($siteData, '/shopproduct/new', array());?>" class="btn btn-violet">
                    <i class="fa fa-fw fa-plus"></i>
                    Добавить товар
                </a>
            </span>
        </li>
        <li class="pull-left header">
            <div class="btn-group" style="margin-right: 10px">
                <button type="button" class="btn btn-success">Сохранить в Excel</button>
                <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopproduct/save_kaspi', [],[], [], true);?>">Сохранить для Kaspi</a></li>
                </ul>
            </div>
        </li>
        <li class="pull-left header">
            <div class="btn-group">
                <button type="button" class="btn btn-success">Считать с сайта</button>
                <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="<?php echo $siteData->urlBasic . '/smg/kaspi/check_product' . URL::query(['shop_source_id' => 1]);?>">Kaspi</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>
<div class="body-table dataTables_wrapper ">
    <div class="box-body table-responsive" style="padding-top: 0px;">
        <?php echo trim($data['view::_shop/product/list/index']); ?>
    </div>
</div>
