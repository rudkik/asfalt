<form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgoodcatalog/savesort" method="get">
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
		<th class="tr-header-photo">Фото</th>
        <?php if ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopgoodcatalog/index-root?type='.Request_RequestParams::getParamInt('type'), array(), $siteData))){ ?>
            <th class="tr-header-rubric">Родитель</th>
        <?php } ?>
		<th>
			Название
		</th>
		<th class="tr-header-buttom-sort"></th>
	</tr>
	<tbody id="sort-record">
	<?php
	foreach ($data['view::shopgoodcatalog/sort']->childs as $value) {
		echo $value->str;
	}
	?>
	</tbody>
</table>
<div class="modal-footer">
    <div hidden>
        <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
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
