<form action="<?php echo Func::getFullURL($siteData, '/shopaction/savesort');?>" method="post">
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</div>
	<table class="table table-hover table-db">
		<tr>
			<th class="tr-header-public">
            <span>
                <input name="is_public" type="checkbox" class="minimal" checked disabled>
            </span>
			</th>
			<th class="tr-header-id">
				<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">ID</a>
				<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
					<i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
				</a>
			</th>
			<?php if (Func::isShopMenu('shopaction/image', $siteData)){ ?>
				<th class="tr-header-photo">Фото</th>
			<?php } ?>
			<th class="tr-header-date">
				<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'from_at'); ?>" class="link-black">Начало акции</a>
				<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'from_at'); ?>" class="link-blue">
					<i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.from_at', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
				</a>
			</th>
			<th class="tr-header-date">
				<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'to_at'); ?>" class="link-black">Конец акции</a>
				<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'to_at'); ?>" class="link-blue">
					<i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.to_at', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
				</a>
			</th>
			<th>
				<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
				<a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
					<i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
				</a>
			</th>
			<th class="tr-header-buttom"></th>
		</tr>
		<tbody id="sort-record">
		<?php
		foreach ($data['view::_shop/action/one/sort']->childs as $value) {
			echo $value->str;
		}
		?>
		</tbody>
	</table>
	<div class="modal-footer">
		<div hidden>
			<?php echo Func::getURLParamsToInput($_GET, 'request');?>

			<input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
			<?php if($siteData->branchID > 0){ ?>
				<input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
			<?php } ?>
			<?php if($siteData->superUserID > 0){ ?>
				<input name="shop_id" value="<?php echo $siteData->shopID; ?>">
			<?php } ?>
		</div>
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</div>
</form>
