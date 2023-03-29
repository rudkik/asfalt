<div class="body-bills">
    <div class="container">
        <h3>Добавить скидку</h3>
        <div class="row">
            <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopdiscount/save" method="post" style="padding-right: 5px;">
                <?php echo trim($data['view::shopdiscount/new']); ?>
            </form>
        </div>
    </div>
</div>