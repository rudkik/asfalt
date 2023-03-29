<section class="content-header">
    <h1>Заведение <label style="color: gray; font-size: 18px; font-weight: 400;">(меню)</label> </h1>
</section>

<section class="content top20" id="edit_panel" style="margin-top: 0px; padding-top: 5px;">
    <div class="row">
        <form style="max-width: 1007px;" class="col-md-12" action="<?php echo $siteData->urlBasic . '/manager/shop/save' ?>" method="post">
            <?php echo trim($data['view::shop/menu']); ?>
        </form>
    </div>
</section>