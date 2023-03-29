<div class="col-md-6 direction">
    <img src="<?php echo Arr::path($data->values['files'], '2.file', ''); ?>">
    <h3><a href="<?php echo $siteData->urlBasic; ?>/sector?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a></h3>
    <ul>
        <?php echo $data->additionDatas['view::View_Shops/rubriki-sectors-acticles-napravleniya']; ?>
    </ul>
</div>