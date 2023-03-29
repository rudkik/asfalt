<form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablerubric/savesort" method="post">
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
				ID
			</th>
			<?php if (Func::isShopMenu('shoptablerubric/image?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
				<th class="tr-header-photo">Фото</th>
			<?php } ?>
			<?php if (Func::isShopMenu('shoptablerubric/root?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
				<th class="tr-header-rubric"><?php echo SitePageData::setPathReplace('type.form_data.shop_table_rubric.fields_title.root', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
			<?php } ?>
			<th><?php echo SitePageData::setPathReplace('type.form_data.shop_table_rubric.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
			<th class="tr-header-buttom"></th>
		</tr>
		<tbody id="sort-record">
		<?php
		foreach ($data['view::_shop/_table/rubric/one/sort']->childs as $value) {
			echo $value->str;
		}
		?>
		</tbody>
	</table>
	<div class="modal-footer">
		<div hidden>
			<input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
			<input name="table_id" value="<?php echo Request_RequestParams::getParamInt('table_id');?>">
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
