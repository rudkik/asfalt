<section class="content-header">
    <h1>
        <?php echo SitePageData::setPathReplace('type.form_data.shop_table_child.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
        <small style="margin-right: 10px;">каталог</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <?php if($siteData->branchID){ ?>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group'), array('is_edit' => 1)); ?>"> <b><?php echo Func::trimTextNew($siteData->branch->getName(), 20, FALSE); ?></b></a></li>
        <?php } ?>
        <li><a href="<?php echo Func::getFullURL($siteData, '/shopgood/index', array('type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group')); ?>"><i class="fa fa-dashboard"></i> <?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a></li>
        <li><a href="<?php echo Func::getFullURL($siteData, '/shopgood/edit', array('id' => 'shop_root_table_object_id', 'type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group')); ?>"><i class="fa fa-dashboard"></i> <?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.name_one', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a></li>
        <li class="active"><?php echo SitePageData::setPathReplace('type.form_data.shop_table_child.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?></li>
    </ol>
</section>
<section class="content padding-5">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary padding-t-5">
				<div class="box-body pad table-responsive">
					<div class="row">
						<div class="col-md-12">
							<div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li><a href="<?php echo Func::getFullURL($siteData, '/shopgood/edit', array('id' => 'shop_root_table_object_id', 'type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group')); ?>#tab1">Общая информация <i class="fa fa-fw fa-info text-blue"></i></a></li>
                                    <?php if (Func::isShopMenu('shopgood/filter?type='.Request_RequestParams::getParamInt('shop_root_table_catalog_id'), $siteData)){ ?>
                                        <li><a href="<?php echo Func::getFullURL($siteData, '/shopgood/edit', array('id' => 'shop_root_table_object_id', 'type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group')); ?>#tab4" ><?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.filter', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a></li>
                                    <?php } ?>
                                    <?php if (Request_RequestParams::getParamInt('is_group') == 1){ ?>
                                        <li><a href="<?php echo Func::getFullURL($siteData, '/shopgood/edit', array('id' => 'shop_root_table_object_id', 'type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group')); ?>#tab2" >Связанные товары <i class="fa fa-fw fa-info text-blue"></i></a></li>
                                    <?php } ?>
                                    <?php if (Func::isShopMenu('shopgood/similar?type='.Request_RequestParams::getParamInt('shop_root_table_catalog_id'), $siteData)){ ?>
                                        <li class=""><a href="<?php echo Func::getFullURL($siteData, '/shopgood/edit', array('id' => 'shop_root_table_object_id', 'type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group')); ?>#tab6" >Подобные товары / услуги <i class="fa fa-fw fa-info text-blue"></i></a></li>
                                    <?php } ?>
                                    <?php if (Func::isShopMenu('shopgood/seo?type='.Request_RequestParams::getParamInt('shop_root_table_catalog_id'), $siteData)){ ?>
                                        <li class=""><a href="<?php echo Func::getFullURL($siteData, '/shopgood/edit', array('id' => 'shop_root_table_object_id', 'type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group')); ?>#tab7" >SEO-настройки <i class="fa fa-fw fa-info text-blue"></i></a></li>
                                    <?php } ?>
                                    <?php if (Func::isShopMenu('shopgood/remarketing?type='.Request_RequestParams::getParamInt('shop_root_table_catalog_id'), $siteData)){ ?>
                                        <li class=""><a href="<?php echo Func::getFullURL($siteData, '/shopgood/edit', array('id' => 'shop_root_table_object_id', 'type' => 'shop_root_table_catalog_id', 'is_group' => 'is_group')); ?>#tab5" >Код ремаркетинга <i class="fa fa-fw fa-info text-blue"></i></a></li>
                                    <?php } ?>
                                    <?php if (Func::isShopMenu('shopgood/child?type='.Request_RequestParams::getParamInt('shop_root_table_catalog_id'), $siteData)){ ?>
                                        <li class="active">
                                            <a href="<?php echo Func::getFullURL($siteData, '/shoptablechild/index', array('root_table_id' => 'root_table_id', 'shop_root_table_object_id' => 'shop_root_table_object_id', 'shop_root_table_catalog_id' => 'shop_root_table_catalog_id', 'type' => 'type', 'is_group' => 'is_group'), array('is_public_ignore' => 1)); ?>"><?php echo SitePageData::setPathReplace('type.form_data.shop_table_child.fields_title.name_list', SitePageData::CASE_FIRST_LETTER_UPPER); ?> <i class="fa fa-fw fa-info text-blue"></i></a>
                                        </li>
                                    <?php } ?>
								</ul>
								<div class="tab-content">
									<div class="active tab-pane" id="tab4">
										<section class="content padding-5">
											<div class="row">
												<div class="col-md-12">
                                                    <?php
                                                    $view = View::factory('cabinet/35/main/_shop/_table/child/filter');
                                                    $view->siteData = $siteData;
                                                    $view->data = $data;
                                                    echo Helpers_View::viewToStr($view);
                                                    ?>
												</div>
												<div class="col-md-12">
                                                    <?php
                                                    $view = View::factory('cabinet/35/_common/tab');
                                                    $view->siteData = $siteData;
                                                    $view->name = 'shop_table_child';
                                                    $view->params = array(
                                                        'table_id' => 'table_id',
                                                    );
                                                    echo Helpers_View::viewToStr($view);
                                                    ?>
													<div class="box box-primary padding-t-5">
														<div class="box-body table-responsive no-padding">
                                                            <?php echo trim($data['view::_shop/_table/child/list/index']); ?>
														</div>
													</div>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
if ($siteData->url == '/'.$siteData->actionURLName.'/shoptablechild/index_edit'){
    $view = View::factory('cabinet/35/_addition/replace-modal');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);

    $view = View::factory('cabinet/35/_addition/load-image-modal');
    $view->siteData = $siteData;
    $view->data = $data;
    $view->saveURL = '/cabinet/shoptablechild/addimages';
    echo Helpers_View::viewToStr($view);
}
?>