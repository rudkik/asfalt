<section class="content-header">
	<h1>
		<?php echo SitePageData::setPathReplace('type.form_data.shop_operation.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
		<small style="margin-right: 10px;">каталог</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
		<?php if($siteData->branchID){ ?>
			<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
		<?php } ?>
		<li class="active"><?php echo SitePageData::setPathReplace('type.form_data.shop_operation.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?></li>
	</ol>
</section>
<section class="content padding-5">
	<div class="row">
		<div class="col-md-12">
			<?php
			$view = View::factory('sladushka/manager/35/main/_shop/operation/filter');
			$view->siteData = $siteData;
			$view->data = $data;
			echo Helpers_View::viewToStr($view);
			?>
		</div>
		<div class="col-md-12">
			<div class="nav-tabs-custom" style="margin-bottom: 0px;">
				<ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if($siteData->url == '/'.$siteData->actionURLName.'/shopoperation/sort'){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopoperation/sort', array('type' => 'type', 'is_group' => 'is_group'), array('is_public_ignore' => 1));?>" data-toggle="tab" aria-expanded="false" data-id="all">Сортировка</a></li>
                    <li class="<?php if($siteData->url == '/'.$siteData->actionURLName.'/shopoperation/index_edit'){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index_edit', array('type' => 'type', 'is_group' => 'is_group'), array('is_public_ignore' => 1));?>" data-toggle="tab" aria-expanded="false" data-id="is_public_ignore">Массовое изменение</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index', array('type' => 'type', 'is_group' => 'is_group'), array('is_delete_public_ignore' => 1));?>" data-toggle="tab" aria-expanded="false" data-id="is_delete_public_ignore">Удаленные</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index', array('type' => 'type', 'is_group' => 'is_group'), array('is_not_public' => 1));?>" data-toggle="tab" aria-expanded="true" data-id="is_not_public">Неактивные</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index', array('type' => 'type', 'is_group' => 'is_group'), array('is_public' => 1));?>" data-toggle="tab" aria-expanded="true" data-id="is_public">Активные</a></li>
                    <li class="<?php if(($siteData->url != '/'.$siteData->actionURLName.'/shopoperation/index_edit') && ($siteData->url != '/'.$siteData->actionURLName.'/shopoperation/sort') && (Arr::path($siteData->urlParams, 'is_delete_public_ignore', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopoperation/index', array('type' => 'type', 'is_group' => 'is_group'), array('is_public_ignore' => 1));?>" data-toggle="tab" aria-expanded="true" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left header">
                        <span>
                            <a href="<?php echo Func::getFullURL($siteData, '/shopoperation/new', array('type' => 'type', 'is_group' => 'is_group'));?>" class="btn btn-warning">
								<i class="fa fa-fw fa-plus"></i>
								Добавить
							</a>
                        </span>
						<span>
                            <a href="<?php echo Func::getFullURL($siteData, '/shoploadfile/index', array('type' => 'type'), array('table_id' => Model_Shop_Good::TABLE_ID));?>" class="btn btn-warning">
								<i class="fa fa-fw fa-plus"></i>
								Загрузка файла данных
							</a>
                        </span>
					</li>
				</ul>
			</div>
			<div class="box box-primary padding-t-5">
				<div class="box-body table-responsive no-padding">
					<?php echo trim($data['view::_shop/operation/list/index']); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
if ($siteData->url == '/'.$siteData->actionURLName.'/shopoperation/index_edit'){
	$view = View::factory('sladushka/manager/35/_addition/replace-modal');
	$view->siteData = $siteData;
	$view->data = $data;
	echo Helpers_View::viewToStr($view);

	$view = View::factory('sladushka/manager/35/_addition/load-image-modal');
	$view->siteData = $siteData;
	$view->data = $data;
	$view->saveURL = '/manager/shopoperation/addimages';
	echo Helpers_View::viewToStr($view);
}
?>
