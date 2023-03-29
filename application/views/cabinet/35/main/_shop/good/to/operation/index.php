<section class="content-header">
	<h1>
		Цены для операторов
		<small style="margin-right: 10px;">каталог</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
		<?php if($siteData->branchID){ ?>
			<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
		<?php } ?>
		<li class="active">Цены для операторов</li>
	</ol>
</section>
<section class="content padding-5">
	<div class="row">
		<div class="col-md-12">
			<?php
			$view = View::factory('cabinet/35/main/_shop/good/to/operation/filter');
			$view->siteData = $siteData;
			$view->data = $data;
			echo Helpers_View::viewToStr($view);
			?>
		</div>
		<div class="col-md-12">
			<div class="nav-tabs-custom" style="margin-bottom: 0px;">
				<ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/index', array('type' => 'type', 'is_group' => 'is_group'), array('is_delete' => 1));?>" data-toggle="tab" aria-expanded="false" data-id="is_delete">Удаленные</a></li>
                    <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/index', array('type' => 'type', 'is_group' => 'is_group'), array('is_public_ignore' => 1));?>" data-toggle="tab" aria-expanded="true" data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left header">
                        <span>
                            <a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/new_operation', array('type' => 'type', 'is_group' => 'is_group'));?>" class="btn btn-warning">
								<i class="fa fa-fw fa-plus"></i>
								Добавить цены оператору
							</a>
                        </span>
						<span>
                            <a href="<?php echo Func::getFullURL($siteData, '/shopgoodtooperation/new_good', array('type' => 'type', 'is_group' => 'is_group'));?>" class="btn btn-warning">
								<i class="fa fa-fw fa-plus"></i>
								Добавить цены товару
							</a>
                        </span>
					</li>
				</ul>
			</div>
			<div class="box box-primary padding-t-5">
				<div class="box-body table-responsive no-padding">
					<?php echo trim($data['view::_shop/good/to/operation/list/index']); ?>
				</div>
			</div>
		</div>
	</div>
</section>
