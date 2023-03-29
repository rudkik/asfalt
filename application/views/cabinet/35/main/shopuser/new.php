<section class="content-header">
    <h1>
        <?php echo $data['view::user_type']; ?>
        <small style="margin-right: 10px;">добавление</small>
        <?php echo trim($siteData->globalDatas['view::language/list/translate']); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <?php if($siteData->branchID){ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
        <?php } ?>
        <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopuser/index?type=<?php echo intval(Request_RequestParams::getParamInt('type')); ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-dashboard"></i> <?php echo $data['view::user_type']; ?></a></li>
        <li class="active"><?php echo $data['view::user_type']; ?></li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form enctype="multipart/form-data" action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopuser/save" method="post" style="padding-right: 5px;">
                        <?php echo trim($data['view::shopuser/new']); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
