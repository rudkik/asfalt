<section class="content-header">
    <h1>
        <?php echo $data['view::message_type']; ?>
        <small style="margin-right: 10px;">каталог</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <?php if($siteData->branchID){ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
        <?php } ?>
        <li class="active"><?php echo $data['view::message_type']; ?></li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <?php
            $view = View::factory('cabinet/35/main/shopmessage/filter');
            $view->siteData = $siteData;
            $view->data = $data;
            echo Helpers_View::viewToStr($view);
            ?>
        </div>
        <div class="col-md-12">
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="#tab1" data-toggle="tab" aria-expanded="false" data-id="is_delete">Удаленные</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){echo 'active';}?>"><a href="#tab2" data-toggle="tab" aria-expanded="true" data-id="is_not_public">Прочитанные</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){echo 'active';}?>"><a href="#tab3" data-toggle="tab" aria-expanded="true" data-id="is_public">Непрочитанные</a></li>
                    <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="#tab3" data-toggle="tab" aria-expanded="true" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left header">
                        <span>
                            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmessage/new?type=<?php echo intval(Request_RequestParams::getParamInt('type')); ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-warning">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить диалог
                            </a>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="box box-primary padding-t-5">
                <div class="box-body table-responsive no-padding">
                    <?php echo trim($data['view::shopmessages/index']); ?>
                </div>
            </div>
        </div>
    </div>
</section>