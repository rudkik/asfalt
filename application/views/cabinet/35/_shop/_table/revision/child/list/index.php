<table class="table table-hover table-db">
	<tr>
		<th class="tr-header-id">ID</th>
        <th class="tr-header-photo">Фото</th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptablerevision/edit'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptablerevision/edit'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th>Старое место</th>
        <th>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptablerevision/edit'). Func::getAddURLSortBy($siteData->urlParams, 'shop_table_stock_id'); ?>" class="link-black">Новое место</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shoptablerevision/edit'). Func::getAddURLSortBy($siteData->urlParams, 'shop_table_stock_id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.shop_table_stock_id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th>Просканирован?</th>
		<th class="tr-header-buttom"></th>
	</tr>
	<?php
	foreach ($data['view::_shop/_table/revision/child/one/index']->childs as $value) {
		echo $value->str;
	}
	?>
</table>
<div class="row">
    <div class="col-md-12 padding-t-5">
        <?php
        $view = View::factory('cabinet/35/paginator');
        $view->siteData = $siteData;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
