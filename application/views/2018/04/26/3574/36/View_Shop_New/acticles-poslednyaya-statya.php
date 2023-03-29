<div class="big-news">
    <div class="name"><a href="<?php echo $siteData->urlBasicLanguage; ?>/article?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a></div>
    <div class="info"><?php echo Func::trimTextNew($data->values['text'], 307); ?></div>
    <a class="full" href="<?php echo $siteData->urlBasicLanguage; ?>/article?id=<?php echo $data->values['id']; ?>">Читать полностью</a>
</div>