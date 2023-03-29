<form action="<?php echo Func::getFullURL($siteData, '/shopaddress/savesort');?>" method="post">
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
			<?php if (Func::isShopMenu('shopaddress/rubric', $siteData)){ ?>
				<th class="tr-header-rubric">Рубрика</th>
			<?php } ?>
			<th>Название</th>
			<th>Адрес</th>
			<th class="tr-header-buttom"></th>
		</tr>
		<tbody id="sort-record">
		<?php
		foreach ($data['view::_shop/address/one/sort']->childs as $value) {
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
