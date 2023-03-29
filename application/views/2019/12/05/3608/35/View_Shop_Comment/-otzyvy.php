<div class="item">
    <div class="box-comment">
        <div class="box-name-date">
            <div class="name"><?php echo $data->values['name']; ?></div>
            <div class="date"><?php echo Helpers_DateTime::getDateTimeDayMonthRus($data->values['created_at'], TRUE); ?></div>
        </div>
        <div class="rating">
            <div class="rating-mini">
                <span class="active"></span>
                <span class="active"></span>
                <span class="active"></span>
                <span></span>
                <span></span>
            </div>
            <div class="title">3 звезды</div>
        </div>
        <div class="text"><?php echo $data->values['text']; ?></div>

        <img class="img-bottom" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/quotes.png">
    </div>
</div>