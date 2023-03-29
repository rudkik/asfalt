<section class="content">
    <?php echo trim($data['view::shopdeliverytypes/index']); ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group" id="edit_panel">
                <label>Информация (будет отображаться во вкладке «Доставка»)</label>
                <textarea name="info_delivery" class="form-control" rows="7"><?php echo $data['info_delivery']; ?></textarea>
                <?php if($siteData->branchID > 0){ ?>
                    <input name="shop_branch_id" type="text" hidden="hidden" value="<?php echo $siteData->branchID; ?>">
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="row top20">
        <div class="col-md-3">
            <input type="submit" value="Сохранить" class="btn btn-primary btn-block" onclick="actionSaveObject('<?php echo $siteData->urlBasic . '/cabinet/shop/save' ?><?php echo URL::query(array('url' => $siteData->urlBasic.$siteData->url.'?is_main=1'), FALSE);?>', <?php echo $siteData->shopID; ?>,'edit_panel', 'table_panel')">
        </div>
    </div>
</section>

<script>
    CKEDITOR.replace('info_delivery');
</script>