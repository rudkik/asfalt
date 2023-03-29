<section class="content-header">
    <h1>
        <?php echo SitePageData::setPathReplace('type.form_data.shop_operation.fields_title.name_one', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
        <small style="margin-right: 10px;">добавление</small>
        <?php echo trim($siteData->globalDatas['view::language/list/translate']); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <?php if($siteData->branchID){ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
        <?php } ?>
        <li><a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index', array('type' => 'type', 'is_group' => 'is_group')); ?>"><i class="fa fa-dashboard"></i> <?php echo SitePageData::setPathReplace('type.form_data.shop_operation.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a></li>
        <li class="active"><?php echo SitePageData::setPathReplace('type.form_data.shop_operation.fields_title.name_one', SitePageData::CASE_FIRST_LETTER_UPPER); ?></li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopoperation/save'); ?>" method="post" style="padding-right: 5px;">
                        <?php echo trim($data['view::_shop/operation/one/new']); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$view = View::factory('sladushka/manager/35/popup/table-similar');
$view->siteData = $siteData;
$view->data = $data;
$view->objectName = 'shop_operation';
echo Helpers_View::viewToStr($view);
?>

<?php
$view = View::factory('sladushka/manager/35/popup/table-group');
$view->siteData = $siteData;
$view->data = $data;
$view->objectName = 'shop_operation';
echo Helpers_View::viewToStr($view);
?>
