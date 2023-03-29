<section class="content-header">
    <h1>
        <?php echo SitePageData::setPathReplace('type.form_data.shop_operation_stock.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
        <small style="margin-right: 10px;">каталог</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <?php if($siteData->branchID){ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
        <?php } ?>
        <li class="active"><?php echo SitePageData::setPathReplace('type.form_data.shop_operation_stock.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?></li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <?php
            $view = View::factory('cabinet/35/main/_shop/operation/stock/filter');
            $view->siteData = $siteData;
            $view->data = $data;
            echo Helpers_View::viewToStr($view);
            ?>
        </div>
        <div class="col-md-12">
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopoperationstock/index', array('type' => 'type'), array('is_delete' => 1));?>" data-toggle="tab" aria-expanded="false" data-id="is_delete">Удаленные</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') != 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopoperationstock/index', array('type' => 'type'), array('is_public_ignore' => 1));?>" data-toggle="tab" aria-expanded="true" data-id="">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                </ul>
            </div>
            <div class="box box-primary padding-t-5">
                <div class="box-body table-responsive no-padding">
                    <?php echo trim($data['view::_shop/operation/stock/list/index']); ?>
                </div>
            </div>
        </div>
    </div>
</section>