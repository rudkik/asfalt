<section class="content-header">
    <h1>
        <?php echo $data['view::new_type']; ?>
        <small style="margin-right: 10px;">массовое добавление</small>
        <?php echo trim($siteData->globalDatas['view::languages/translate']); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shop/edit"><i class="fa fa-dashboard"></i> Главная</a></li>
        <?php if($siteData->branchID){ ?>
            <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shop/edit?is_edit=1&shop_branch_id=<?php echo $siteData->branchID; ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
        <?php } ?>
        <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/index?type=<?php echo intval(Request_RequestParams::getParamInt('type')); ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-dashboard"></i> Каталог <?php echo $data['view::new_type']; ?></a></li>
        <li class="active"><?php echo $data['view::new_type']; ?></li>
    </ol>
</section>
<section class="content padding-5px">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-top-5px">
                <div class="box-body pad table-responsive">
                    <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/savehorde" method="post" style="padding-right: 5px;">
                        <?php echo trim($data['view::shopnew/new-horde']); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$view = View::factory('cabinet/35/popup/new-similar');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
