<section class="content-header">
    <h1>Виды оплаты</h1>
</section>

<section class="content top20" id="nastoika-magazina" >
    <?php echo trim($data['view::shoppaidtypes/index']); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group" id="edit_panel">
                <label>Информация (будет отображаться во вкладке «Оплата»)</label>
                <textarea name="info_paid" class="form-control" placeholder="Ваш текст..." rows="7"><?php echo $data['info_paid']; ?></textarea>
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
    CKEDITOR.replace('info_paid');
</script>