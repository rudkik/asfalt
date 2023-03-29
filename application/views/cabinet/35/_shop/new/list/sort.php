<form action="<?php echo Func::getFullURL($siteData, '/shopnew/savesort');?>" method="post">
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
			<?php if (Func::isShopMenu('shopnew/image?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
				<th class="tr-header-photo">Фото</th>
			<?php } ?>
			<?php if (Func::isShopMenu('shopnew/article?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
				<th class="tr-header-price"><?php echo SitePageData::setPathReplace('type.form_data.shop_new.fields_title.article', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
			<?php } ?>
			<?php if (Func::isShopMenu('shopnew/rubric?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
				<th class="tr-header-rubric"><?php echo SitePageData::setPathReplace('type.form_data.shop_new.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
			<?php } ?>
			<th><?php echo SitePageData::setPathReplace('type.form_data.shop_new.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?></th>
			<th class="tr-header-buttom"></th>
		</tr>
		<tbody id="sort-record">
		<?php
		foreach ($data['view::_shop/new/one/sort']->childs as $value) {
			echo $value->str;
		}
		?>
		</tbody>
	</table>
	<div class="modal-footer">
		<div hidden>
			<?php echo Func::getURLParamsToInput($_GET, 'request');?>

			<input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
			<input name="is_group" value="<?php echo intval(Request_RequestParams::getParamInt('is_group'));?>">
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
