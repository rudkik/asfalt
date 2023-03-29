<header class="header-breadcrumb">
    <div class="container">
        <h1><?php echo $data->values['name']; ?></h1>
        <div class="breadcrumbs">
            <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> /
            <a href="<?php echo $siteData->urlBasic;?>/comments">Отзывы</a> /
            <a class="active" href="<?php echo $siteData->urlBasic;?>/comment?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a>
        </div>
    </div>
</header>
<header class="header-text">
    <div class="container">
        <div class="line-green"></div>
        <h2><?php echo $data->values['name']; ?></h2>
        <div class="box-text">
            <?php echo $data->values['text']; ?>
        </div>
    </div>
</header>