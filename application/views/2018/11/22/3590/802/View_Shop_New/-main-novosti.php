<div class="item">
	<div class="carousel-caption">
	  <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/news<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
	  <div class="news_date"><?php echo Helpers_DateTime::getDateTimeDayMonth($siteData, $data->values['created_at'], TRUE); ?></div>
	  <div class="news_text"><?php echo Func::trimTextNew($data->values['text'], 350); ?></div>
	</div>
</div>