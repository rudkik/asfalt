<div class="tab-pane active">
    <?php $siteData->titleTop = 'Прайс листы'; ?>
    <?php
    $view = View::factory('smg/market/35/main/_shop/supplier/price-list/filter');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopsupplierpricelist/index', array(), array('is_public_ignore' => 1));?>" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
        <li class="pull-left header">
            <span>
                <a href="<?php echo Func::getFullURL($siteData, '/shopsupplierpricelist/new', array());?>" class="btn btn-violet">
                    <i class="fa fa-fw fa-plus"></i>
                    Добавить прайс лист
                </a>
            </span>
        </li>
    </ul>
</div>
<div class="body-table dataTables_wrapper ">
    <div class="box-body table-responsive" style="padding-top: 0px;">
        <?php echo trim($data['view::_shop/supplier/price-list/list/index']); ?>
    </div>
</div>
