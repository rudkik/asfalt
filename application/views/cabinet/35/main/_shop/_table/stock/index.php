<section class="content-header">
	<h1>
		<?php echo SitePageData::setPathReplace('type.form_data.shop_table_stock.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
		<small style="margin-right: 10px;">каталог</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
		<?php if($siteData->branchID){ ?>
			<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20, FALSE); ?></b></a></li>
		<?php } ?>
		<li class="active"><?php echo SitePageData::setPathReplace('type.form_data.shop_table_stock.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?></li>
	</ol>
</section>
<section class="content padding-5">
	<div class="row">
		<div class="col-md-12">
			<?php
			$view = View::factory('cabinet/35/main/_shop/_table/stock/filter');
			$view->siteData = $siteData;
			$view->data = $data;
			echo Helpers_View::viewToStr($view);
			?>
		</div>
		<div class="col-md-12">
            <?php
            $view = View::factory('cabinet/35/_common/tab');
            $view->siteData = $siteData;
            $view->name = 'shop_table_stock';
            $view->params = array(
                'table_id' => 'table_id',
            );
            echo Helpers_View::viewToStr($view);
            ?>
			<div class="box box-primary padding-t-5">
				<div class="box-body table-responsive no-padding">
					<?php echo trim($data['view::_shop/_table/stock/list/index']); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
if ($siteData->url == '/'.$siteData->actionURLName.'/shoptablestock/index_edit'){
    $view = View::factory('cabinet/35/_addition/replace-modal');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);

    $view = View::factory('cabinet/35/_addition/load-image-modal');
    $view->siteData = $siteData;
    $view->data = $data;
    $view->saveURL = '/cabinet/shoptablestock/addimages';
    echo Helpers_View::viewToStr($view);
}
?>