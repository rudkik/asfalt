<div class="partner-shop">
    <div class="block-select">
        <?php
        $partnerStatus = intval(Arr::path($siteData->shop->getOptions(), 'partners_status.'.$data->id, '0'));
        switch($partnerStatus){
            case 1:
                echo '<div class="status bg-orange">Ждем подтверждение</div>';
                break;
            case 2:
                echo '<div class="status bg-red">Не является моим поставщиком</div>';
                break;
            default:
                echo '<div class="status bg-green">Мой поставщик</div>';
        };
        ?>
        <a href="/customer/shopbranch/edit?id=<?php echo $data->id; ?>">
            <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 253, 150); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
        </a>
        <div class="title"><a href="/customer/shopbranch/edit?id=<?php echo $data->id; ?>"><?php echo $data->values['name']; ?></a></div>
    </div>
</div>
