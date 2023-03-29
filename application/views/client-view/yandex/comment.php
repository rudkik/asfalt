<!-- вариант #1 -->
<div hidden="hidden">
    <div class="hreview">
        <h2 class="summary"><a href="<?php echo $siteData->urlBasic.$siteData->url; ?>?id=<?php echo $data->values['id']; ?>" class="permalink"><?php echo Func::trimTextNew($data->values['text'], 150); ?></a></h2>
        <div>Отзыв написал <span class="reviewer vcard"><a class="url fn" href="<?php echo $data->values['url']; ?>"><?php echo $data->values['user_name']; ?></a></span>,
            <span class="dtreviewed"><abbr class="value" title="<?php echo Helpers_DateTime::getDateTimeISO8601($data->values['created_at']); ?>"><?php echo Helpers_DateTime::getDateTimeFormatRusMonthStr($data->values['created_at']); ?></abbr>.</span>
        </div>
        <div class="rating">
            <abbr class="worst" title="0"></abbr>
            <p>Оценка: <span class="value"><?php echo Arr::path($data->values, 'options.rating', 9); ?></span> из <span class="best">10</span>.</p>
        </div>
        <div class="pro"><?php echo Arr::path($data->values, 'options.worth', ''); ?></div>
        <div class="contra"><?php echo Arr::path($data->values, 'options.contra', ''); ?></div>
        <div class="description">
            <abbr class="type" title="business"><?php echo $data->values['text']; ?></abbr>
        </div>
        <div class="item vcard">
            <h3>Информация о <abbr class="category" title="restaurant">заведении</abbr></h3>
            <p>Название: <span class="fn org"><?php echo $siteData->shop->getName(); ?></span></p>
            <p>Сайт заведения: <a class="url" href="<?php echo $siteData->urlBasic; ?>/"><?php echo $siteData->urlBasic; ?>/</a></p>
        </div>
    </div>
</div>

<!-- вариант #2 -->
<div hidden itemscope="" itemtype="http://schema.org/UserComments">
    <div itemtype="http://schema.org/Comment" itemscope="">
        <div itemprop="text"><?php echo $data->values['text']; ?></div>
    </div>
</div>