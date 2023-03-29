<section class="content-header">
	<h1>
		Проданные
		<small style="margin-right: 10px;">отчет</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
		<?php if($siteData->branchID){ ?>
			<li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20); ?></b></a></li>
		<?php } ?>
		<li class="active"><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?></li>
	</ol>
</section>
<section class="content padding-5">
	<div class="row">
		<div class="col-md-12">
			<?php
			$view = View::factory('cabinet/35/_report/main/shop/good/bill/filter');
			$view->siteData = $siteData;
			$view->data = $data;
			echo Helpers_View::viewToStr($view);
			?>
		</div>
		<div class="col-md-12">
			<div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="pull-left header">
                        <span>
                            <a href="<?php echo Func::getFullURL($siteData, '/shopreport/good/bill_xls', array(), array(), array(), TRUE);?>" class="btn btn-success margin-b-5">
								<i class="fa fa-fw fa-plus"></i>
								Скачать xls
							</a>
                        </span>
                    </li>
                </ul>
			</div>
			<div class="box box-primary padding-t-5">
				<div class="box-body table-responsive no-padding">
					<?php echo trim($data['view::_report/shop/bill/item/list/good/bill']); ?>
				</div>
			</div>
		</div>
	</div>
</section>
