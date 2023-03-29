<section class="content-header">
    <h1>
        Настройки админ-панели
        <small style="margin-right: 10px;">редактирование</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <?php if($siteData->branchID){ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
        <?php } ?>
        <li class="active">Настройки админ-панели</li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form enctype="multipart/form-data" action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shop/save" method="post" style="padding-right: 5px;">
                        <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/one/edit']); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>