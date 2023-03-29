<div class="body-bills">
    <div class="container">
        <h3>Добавить категорию</h3>
        <div class="row">
            <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgoodcatalog/save" method="post" style="padding-right: 5px;">
                <?php echo trim($data['view::shopgoodcatalog/new']); ?>
            </form>
        </div>
    </div>
</div>