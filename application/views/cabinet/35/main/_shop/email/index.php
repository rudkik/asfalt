<section class="content-header">
	<h1>
        E-mail сообщения
		<small style="margin-right: 10px;">каталог</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
		<?php if($siteData->branchID){ ?>
			<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
		<?php } ?>
		<li class="active">E-mail сообщения</li>
	</ol>
</section>
<section class="content padding-5">
	<div class="row">
		<div class="col-md-12">
			<?php
			$view = View::factory('cabinet/35/main/_shop/email/filter');
			$view->siteData = $siteData;
			$view->data = $data;
			echo Helpers_View::viewToStr($view);
			?>
		</div>
		<div class="col-md-12">
            <?php
            $view = View::factory('cabinet/35/_common/tab');
            $view->siteData = $siteData;
            $view->name = 'shop_email';
            $view->isPublic = FALSE;
            $view->isNotPublic = FALSE;
            $view->isIndexEdit = FALSE;
            $view->isSort = FALSE;
            $view->tableID = Model_Shop_EMail::TABLE_ID;
            echo Helpers_View::viewToStr($view);
            ?>
			<div class="box box-primary padding-t-5">
				<div class="box-body table-responsive no-padding">
					<?php echo trim($data['view::_shop/email/list/index']); ?>
				</div>
			</div>
		</div>
	</div>
</section>
