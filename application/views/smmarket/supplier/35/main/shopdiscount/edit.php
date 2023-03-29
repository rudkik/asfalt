<div class="body-bills">
    <div class="container">
        <h3>Редактировать скидку</h3>
        <div class="row">
            <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopdiscount/save" method="post" style="padding-right: 5px;">
                <?php echo trim($data['view::shopdiscount/edit']); ?>
            </form>
        </div>
    </div>
</div>