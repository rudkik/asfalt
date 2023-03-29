<table class="table table-hover table-db">
	<tr>
		<th class="tr-header-public">
            <span>
                <input name="is_public" type="checkbox" class="minimal" checked disabled>
            </span>
		</th>
		<th class="tr-header-id">
			<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablefilter/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">ID</a>
			<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablefilter/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
				<i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
			</a>
		</th>
        <?php if (Func::isShopMenu('shoptablefilter/image?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
            <th class="tr-header-photo">Фото</th>
        <?php } ?>
		<?php if ((Func::isShopMenu('shoptablefilter/rubric?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
			<th class="tr-header-rubric"><?php echo SitePageData::setPathReplace('type.form_data.shop_table_filter.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
		<?php } ?>
		<th>
			<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablefilter/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black"><?php echo SitePageData::setPathReplace('type.form_data.shop_table_filter.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a>
			<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablefilter/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
				<i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
			</a>
		</th>
		<th  class="tr-header-sort">
			<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablefilter/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'order'); ?>" class="link-black">Сортировка</a>
			<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablefilter/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'order'); ?>" class="link-blue">
				<i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.order', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
			</a>
		</th>
		<th class="tr-header-buttom"></th>
	</tr>
	<?php
	foreach ($data['view::_shop/_table/filter/one/index']->childs as $value) {
		echo $value->str;
	}
	?>

</table>
<div class="col-md-12 padding-t-5">
    <?php
    $view = View::factory('cabinet/35/paginator');
    $view->siteData = $siteData;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
