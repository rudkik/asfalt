<section class="content-header">
    <h1>
        Адрес компании
        <small style="margin-right: 10px;">редактирование</small>
        <?php echo trim($siteData->globalDatas['view::languages/translate']); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shop/edit"><i class="fa fa-dashboard"></i> Главная</a></li>
        <?php if($siteData->branchID){ ?>
            <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shop/edit?is_edit=1&shop_branch_id=<?php echo $siteData->branchID; ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
        <?php } ?>
        <li class="active">Адрес компании</li>
    </ol>
</section>
<section class="content padding-5px">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-top-5px">
                <div class="box-body pad table-responsive">
                    <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddress/save" method="post" style="padding-right: 5px;">
                        <?php echo trim($data['view::shopaddress/edit']); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
