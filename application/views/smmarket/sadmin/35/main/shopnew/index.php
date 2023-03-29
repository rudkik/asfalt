<section class="content-header">
	<h1>
		<?php echo $data['view::new_type']; ?>
		<small style="margin-right: 10px;">каталог</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shop/edit"><i class="fa fa-dashboard"></i> Главная</a></li>
		<?php if($siteData->branchID){ ?>
			<li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shop/edit?is_edit=1&shop_branch_id=<?php echo $siteData->branchID; ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
		<?php } ?>
		<li class="active"><?php echo $data['view::new_type']; ?></li>
	</ol>
</section>
<section class="content padding-5px">
	<div class="row">
		<div class="col-md-12">
			<?php
			$view = View::factory('cabinet/35/main/shopnew/filter');
			$view->siteData = $siteData;
			$view->data = $data;
			echo Helpers_View::viewToStr($view);
			?>
		</div>
		<div class="col-md-12">
			<div class="nav-tabs-custom" style="margin-bottom: 0px;">
				<ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="#tab1" data-toggle="tab" aria-expanded="false" data-id="is_delete">Удаленные</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){echo 'active';}?>"><a href="#tab2" data-toggle="tab" aria-expanded="true" data-id="is_not_public">Неактивные</a></li>
                    <li class="<?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){echo 'active';}?>"><a href="#tab3" data-toggle="tab" aria-expanded="true" data-id="is_public">Активные</a></li>
                    <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="#tab3" data-toggle="tab" aria-expanded="true" data-id="">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
					<li class="pull-left header">
                        <span>
                            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/new?type=<?php echo intval(Request_RequestParams::getParamInt('type')); ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-warning">
								<i class="fa fa-fw fa-plus"></i>
								Добавить статью
							</a>
							<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/newhorde?type=<?php echo intval(Request_RequestParams::getParamInt('type')); ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-info">
								<i class="fa fa-fw  fa-calendar-plus-o"></i>
								Добавить скопом
							</a>
                        </span>
					</li>
				</ul>
			</div>
			<div class="box box-primary padding-top-5px">
				<div class="box-body table-responsive no-padding">
					<?php echo trim($data['view::shopnews/index']); ?>
				</div>
			</div>
		</div>
	</div>
</section>