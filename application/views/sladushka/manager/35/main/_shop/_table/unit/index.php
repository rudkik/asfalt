<section class="content-header">
	<h1>
		<?php echo SitePageData::setPathReplace('type.form_data.shop_table_unit.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
		<small style="margin-right: 10px;">каталог</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
		<?php if($siteData->branchID){ ?>
			<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20, FALSE); ?></b></a></li>
		<?php } ?>
		<li class="active"><?php echo SitePageData::setPathReplace('type.form_data.shop_table_unit.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?></li>
	</ol>
</section>
<section class="content padding-5">
	<div class="row">
		<div class="col-md-12">
			<?php
			$view = View::factory('sladushka/manager/35/main/_shop/_table/unit/filter');
			$view->siteData = $siteData;
			$view->data = $data;
			echo Helpers_View::viewToStr($view);
			?>
		</div>
		<div class="col-md-12">
			<div class="nav-tabs-custom" style="margin-bottom: 0px;">
				<ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
					<li class="<?php if($siteData->url == '/'.$siteData->actionURLName.'/shoptableunit/sort'){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shoptableunit/sort', array('type' => 'type', 'table_id' => 'table_id'), array('is_public_ignore' => 1));?>" data-toggle="tab" data-id="is_public_ignore">Сортировка</a></li>
					<li class="<?php if($siteData->url == '/'.$siteData->actionURLName.'/shoptableunit/index_edit'){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shoptableunit/index_edit', array('type' => 'type', 'table_id' => 'table_id'), array('is_public_ignore' => 1));?>" data-toggle="tab" data-id="is_public_ignore">Массовое изменение</a></li>
					<li class="<?php if(Arr::path($siteData->urlParams, 'is_delete_public_ignore', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shoptableunit/index', array('type' => 'type', 'table_id' => 'table_id'), array('is_delete_public_ignore' => 1));?>" data-toggle="tab" data-id="is_delete_public_ignore">Удаленные</a></li>
					<li class="<?php if(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shoptableunit/index', array('type' => 'type', 'table_id' => 'table_id'), array('is_not_public' => 1));?>" data-toggle="tab"  data-id="is_not_public">Неактивные</a></li>
					<li class="<?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shoptableunit/index', array('type' => 'type', 'table_id' => 'table_id'), array('is_public' => 1));?>" data-toggle="tab" data-id="is_public">Активные</a></li>
					<li class="<?php if(($siteData->url != '/'.$siteData->actionURLName.'/shoptableunit/index_edit') && ($siteData->url != '/'.$siteData->actionURLName.'/shoptableunit/sort') && (Arr::path($siteData->urlParams, 'is_delete_public_ignore', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shoptableunit/index', array('type' => 'type', 'table_id' => 'table_id'), array('is_public_ignore' => 1));?>" data-toggle="tab" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
					<li class="pull-left header">
                        <span>
                            <a href="<?php echo Func::getFullURL($siteData, '/shoptableunit/new', array('type' => 'type', 'table_id' => 'table_id'));?>" class="btn btn-warning">
								<i class="fa fa-fw fa-plus"></i>
								<?php echo SitePageData::setPathReplace('type.form_data.shop_table_unit.fields_title.button_add', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
							</a>
                        </span>
					</li>
				</ul>
			</div>
			<div class="box box-primary padding-t-5">
				<div class="box-body table-responsive no-padding">
					<?php echo trim($data['view::_shop/_table/unit/list/index']); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
if ($siteData->url == '/'.$siteData->actionURLName.'/shoptableunit/index_edit'){
    $view = View::factory('sladushka/manager/35/_addition/replace-modal');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);

    $view = View::factory('sladushka/manager/35/_addition/load-image-modal');
    $view->siteData = $siteData;
    $view->data = $data;
    $view->saveURL = '/manager/shoptableunit/addimages';
    echo Helpers_View::viewToStr($view);
}
?>