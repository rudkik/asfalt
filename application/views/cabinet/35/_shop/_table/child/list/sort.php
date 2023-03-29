<form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablechild/savesort" method="post">
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</div>
	<table class="table table-hover table-db">
		<thead>
		<tr>
			<th class="tr-header-public">
            <span>
                <input name="is_public" type="checkbox" class="minimal" checked disabled>
            </span>
			</th>
			<th class="tr-header-id">
				ID
			</th>
			<?php if (Func::isShopMenu('shoptablechild/image?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
				<th class="tr-header-photo">Фото</th>
			<?php } ?>
			<th><?php echo SitePageData::setPathReplace('type.form_data.shop_table_child.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
			<?php echo $siteData->globalDatas['view::_shop/_table/catalog/one/th-options']; ?>
			<th class="tr-header-buttom"></th>
		</tr>
		</thead>
		<tbody id="sort-record">
		<?php
		foreach ($data['view::_shop/_table/child/one/sort']->childs as $value) {
			echo $value->str;
		}
		?>
		</tbody>
	</table>
	<div class="modal-footer">
		<div hidden>
            <?php echo Func::getURLParamsToInput($_GET, 'request');?>

            <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
            <input name="root_table_id" value="<?php echo Request_RequestParams::getParamInt('root_table_id');?>">
            <input name="shop_root_table_catalog_id" value="<?php echo Request_RequestParams::getParamInt('shop_root_table_catalog_id');?>">
            <input name="shop_root_table_object_id" value="<?php echo Request_RequestParams::getParamInt('shop_root_table_object_id');?>">
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
