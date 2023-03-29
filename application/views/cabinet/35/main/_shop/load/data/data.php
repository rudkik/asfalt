<section class="content-header">
	<h1>
		Загрузка данных
		<small style="margin-right: 10px;">каталог</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
		<?php if($siteData->branchID){ ?>
			<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
		<?php } ?>
		<li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploaddata/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-dashboard"></i> Загрузка данных каталог</a></li>
		<li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploaddata/edit?id=<?php echo Request_RequestParams::getParamInt('id'); ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-dashboard"></i> Загрузка данных</a></li>
        <li class="active">Данные для сохранения</li>
	</ol>
</section>
<section class="content padding-5">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom" style="margin-bottom: 0px;">
				<ul class="nav nav-tabs pull-right ui-sortable-handle">
					<li class="<?php if(Request_RequestParams::getParamBoolean('is_old') === TRUE){echo 'active';}?>"><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploaddata/data?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&is_old=1<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>" >Старые</a></li>
					<li class="<?php if(Request_RequestParams::getParamBoolean('is_new') === TRUE){echo 'active';}?>"><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploaddata/data?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&is_new=1<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>" >Новые</a></li>
					<li class="<?php if((Request_RequestParams::getParamBoolean('is_new') !== TRUE) && (Request_RequestParams::getParamBoolean('is_old') !== TRUE)){echo 'active';}?>"><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploaddata/data?id=<?php echo Request_RequestParams::getParamInt('id'); ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>" >Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
				</ul>
			</div>
			<div class="box box-primary padding-t-5">
				<div class="box-body table-responsive no-padding">
					<?php echo trim($data['view::_shop/load/data/one/data']); ?>
				</div>
			</div>
		</div>
	</div>
</section>