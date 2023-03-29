<section class="content-header">
	<h1>
		<?php echo SitePageData::setPathReplace('type.form_data.shop_message_chat.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
		<small style="margin-right: 10px;">каталог</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
		<?php if($siteData->branchID){ ?>
			<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
		<?php } ?>
		<li class="active"><?php echo SitePageData::setPathReplace('type.form_data.shop_message_chat.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?></li>
	</ol>
</section>
<section class="content padding-5">
	<div class="row">
		<div class="col-md-12">
			<?php
			$view = View::factory('cabinet/35/main/_shop/message/chat/filter');
			$view->siteData = $siteData;
			$view->data = $data;
			echo Helpers_View::viewToStr($view);
			?>
		</div>
		<div class="col-md-12">
            <?php
            $view = View::factory('cabinet/35/_common/tab');
            $view->siteData = $siteData;
            $view->name = 'shop_message_chat';
            $view->tableID = Model_Shop::TABLE_ID;
            $view->isIndexEdit = FALSE;
            $view->isSort = FALSE;
            $view->params = array(
                'is_group' => 'is_group',
            );
            echo Helpers_View::viewToStr($view);
            ?>
			<div class="box box-primary padding-t-5">
				<div class="box-body table-responsive no-padding">
					<?php echo trim($data['view::_shop/message/chat/list/index']); ?>
				</div>
			</div>
		</div>
	</div>
</section>
