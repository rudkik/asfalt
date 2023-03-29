<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<header class="header-bread-crumbs">
    <div class="container">
        <h2><?php echo $data->values['name']; ?></h2>
        <ul itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs" class="bread-crumbs">
            <li>
                <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasicLanguage; ?>/">Алғашқы бет</a></span> /
            </li>
            <?php if(!empty($siteData->urlSEO)){?>
                <li>
                    <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasicLanguage; ?>/about">Орталық туралы</a></span> /
                </li>
            <?php } ?>
            <li>
                <span typeof="v:Breadcrumb"><?php echo $data->values['name']; ?></span>
            </li>
        </ul>
    </div>
</header>
<header class="header-body box-bg-dom">
    <div class="container">
        <div class="col-sm-3">
            <div class="row">
                <div class="box-menu">
                    <ul>
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-about-stati-o-tcentre']); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <h1 itemprop="headline"><?php echo $data->values['name']; ?></h1>
            <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png" >
            <div class="box_text">
                <?php echo $data->values['text']; ?>
            </div>
        </div>
    </div>
</header>
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
<div hidden="hidden">
    <div itemscope="" itemtype="http://schema.org/NewsArticle">
        <div>
            <span itemprop="description"><?php echo Func::trimTextNew($data->values['text'], 250); ?></span>
            <span itemprop="articleSection"><?php echo Arr::path($data->values, '$elements$.shop_table_rubric_id.name', 'Мақалалар'); ?></span>

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
        "telephone" => $siteData->replaceDatas['telephone'],
        "address " => $siteData->replaceDatas['address'],
    ),
    "publisher" => array(
        "@type" => "Organization",
        "name" => $siteData->shop->getName(),
        "telephone" => $siteData->replaceDatas['telephone'],
        "address " => $siteData->replaceDatas['address'],
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