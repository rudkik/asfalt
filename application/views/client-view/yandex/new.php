<!-- вариант #1 -->
<div hidden temscope="" itemtype="http://schema.org/Article">
    <h1 itemprop="name"><?php echo $data->values['name']; ?></h1>
    <span itemprop="dateCreated" datetime="<?php echo Helpers_DateTime::getDateTimeISO8601($data->values['created_at']); ?>"></span>
    <span itemprop="dateModified" datetime="<?php echo Helpers_DateTime::getDateTimeISO8601($data->values['updated_at']); ?>"></span>
    <?php if(! empty($data->values['image_path'])){ ?>
        <img src="<?php echo $data->values['image_path']; ?>" itemprop="associatedMedia" alt="<?php echo htmlspecialchars($data->values['name']); ?>" title="<?php echo htmlspecialchars($data->values['name']); ?>">
    <?php } ?>
    <?php foreach($data->values['files'] as $file){
        if($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE){
            ?>
            <img src="<?php echo $file['file']; ?>" alt="<?php echo htmlspecialchars($data->values['name']);?>" title="<?php echo htmlspecialchars($data->values['name']);?>">
        <?php } } ?>
    <div itemprop="description"></div>
    <div itemprop="articleBody"><?php echo $data->values['text']; ?></div>
</div>

<!-- вариант #2 -->
<div hidden="hidden">
    <div itemscope="" itemtype="http://schema.org/NewsArticle">
        <div>
            <span itemprop="description"><?php echo Func::trimTextNew($data->values['text'], 250); ?></span>
            <span itemprop="articleSection"><?php echo Arr::path($data->values, '$elements$.shop_new_rubric.name', 'Статьи'); ?></span>

            <meta itemprop="datePublished" content="<?php echo Helpers_DateTime::getDateTimeISO8601($data->values['created_at']); ?>">
            <meta itemprop="dateCreated" content="<?php echo Helpers_DateTime::getDateTimeISO8601($data->values['created_at']); ?>">
            <meta itemprop="dateModified" content="<?php echo Helpers_DateTime::getDateTimeISO8601($data->values['updated_at']); ?>">

            <meta itemscope="" itemprop="mainEntityOfPage" itemtype="https://schema.org/WebPage" itemid="<?php echo $siteData->urlBasic.$siteData->url; ?>?id=<?php echo $data->values['id']; ?>">

            <div itemprop="publisher" itemscope="" itemtype="https://schema.org/Organization">
                <div itemprop="logo" itemscope="" itemtype="https://schema.org/ImageObject">
                    <a itemprop="url" href="<?php echo $siteData->shop->getImagePath(); ?>"></a>
                    <a itemprop="contentUrl" href="<?php echo $siteData->shop->getImagePath(); ?>"></a>
                </div>
                <meta itemprop="name" content="<?php echo $siteData->shop->getName(); ?>">
            </div>
            <div itemprop="image" itemscope="" itemtype="https://schema.org/ImageObject">
                <img itemprop="contentUrl" src="<?php echo $data->values['image_path']; ?>">
                <a itemprop="url" href="<?php echo $data->values['image_path']; ?>"></a>
            </div>
        </div>
        <div>
            <h3 itemprop="author" itemscope="" itemtype="https://schema.org/Person">
                Автор: <span itemprop="name"><?php echo $siteData->shop->getName(); ?></span>
            </h3>
            <h1 itemprop="headline"><?php echo $data->values['name']; ?></h1>

            <div itemprop="articleBody"><?php echo $data->values['text']; ?></div>
        </div>
    </div>
</div>

<!-- vk -->
<meta property="og:type" content="article">
<meta property="og:title" content="<?php echo htmlspecialchars($data->values['name']); ?>" >
<meta property="og:description" content="<?php echo htmlspecialchars(Func::trimTextFirstSentence($data->values['text'], 255)); ?>" >
<?php if(! empty($data->values['image_path'])){ ?>
    <meta property="og:image" content="<?php echo str_replace('http:://', '//', $siteData->urlBasic.$siteData->url.URL::query($siteData->urlParams, FALSE)); ?>" >
<?php } ?>

<!-- twitter -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@<?php if(!empty($siteData->shop->getDomain())){echo str_replace('.', '_', $siteData->shop->getDomain());}else{echo str_replace('.', '_', $siteData->shop->getSubDomain());} ?>">
<meta name="twitter:title" content="<?php echo htmlspecialchars($data->values['name']); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars(Func::trimTextFirstSentence($data->values['text'], 255)); ?>">
<?php if(! empty($data->values['image_path'])){ ?>
    <meta name="twitter:image" content="<?php echo str_replace('http:://', '//', $data->values['image_path']); ?>">
<?php } ?>

<meta property="ya:ovs:embed_html" content="<?php echo trim($siteData->urlCanonical); ?>" />
<meta property="ya:ovs:upload_date" content="<?php echo Helpers_DateTime::getDateTimeISO8601($data->values['updated_at']); ?>" />
<meta property="ya:ovs:content_id" content="<?php echo str_replace('http://', '', $siteData->urlBasic.$siteData->url.URL::query($siteData->urlParams, FALSE)); ?>" />
<meta property="ya:ovs:is_official" content="yes" />

<script type="application/ld+json">
<?php
    $json = array(
        "@context" => "http://schema.org",
        "@type" => "NewsArticle",
        "mainEntityOfPage" => array(
            "@type" => "WebPage",
            "@id" => $siteData->urlCanonical,
        ),
        "headline" => $data->values['name'],
        "datePublished" => Helpers_DateTime::getDateTimeISO8601($data->values['created_at']),
        "dateModified" => Helpers_DateTime::getDateTimeISO8601($data->values['updated_at']),
        "author" => array(
            "@type" => "Organization",
            "name" => $siteData->shop->getName(),
        ),
        "publisher" => array(
            "@type" => "Organization",
            "name" => $siteData->shop->getName(),
        ),
        "description" => Func::trimTextNew($data->values['text'], 65000)
    );
    if(! empty($data->values['image_path'])) {
        $json["image"] = array(
            "@type" => "ImageObject",
            "url" => $data->values['image_path'],
        );
    }

    if(! empty($siteData->shop->getImagePath())) {
        $json["logo"] = array(
            "@type" => "ImageObject",
            "url" => $siteData->shop->getImagePath(),
        );
    }
    echo json_encode($json);
    ?>
</script>