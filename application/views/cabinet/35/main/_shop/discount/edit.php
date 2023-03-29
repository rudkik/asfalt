<section class="content-header">
    <h1>
        Скидка
        <small style="margin-right: 10px;">редактирование</small>
        <?php echo trim($siteData->globalDatas['view::language/list/translate']); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <?php if($siteData->branchID){ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
        <?php } ?>
        <li><a href="<?php echo Func::getFullURL($siteData, '/shopdiscount/index', array('type' => 'type', 'is_group' => 'is_group')); ?>"><i class="fa fa-dashboard"></i> Скидки</a></li>
        <li class="active">Скидка</li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopdiscount/save'); ?>" method="post" style="padding-right: 5px;">
                        <?php echo trim($data['view::_shop/discount/one/edit']); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$view = View::factory('cabinet/35/popup/promo');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>