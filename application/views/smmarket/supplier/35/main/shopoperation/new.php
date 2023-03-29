<div class="body-bills">
    <div class="container">
        <h3>Добавить менеджера</h3>
        <div class="row">
            <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperation/save" method="post" style="padding-right: 5px; max-width: 500px;">
                <?php echo trim($data['view::shopoperation/new']); ?>
            </form>
        </div>
    </div>
</div>