<?php
if($data->id > 0){
    Helpers_SEO::setSEOHeader(Model_Shop_Table_Rubric::TABLE_NAME, $data, $siteData);
    $siteData->siteImage = $data->values['image_path'];

    if ($data->values['root_id'] == 0){
        $_GET['rubric_root_id'] = Arr::path($_GET, '_current_rubric_', 999);
    }else{
        $_GET['rubric_root_id'] = Arr::path($_GET, '_current_rubric_', $data->values['root_id']);
    }
}

$s = Request_RequestParams::getParamStr('name_lexicon');
if(empty($s)){
    $s = 'Продукция';
}else{
    $s = 'Поиск "'.$s.'"';
}
?>
<header class="header-bread-crumbs">
    <div class="container">
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> /
            <?php if($data->id > 0){?>
                <a href="<?php echo $siteData->urlBasic;?>/catalogs">Продукция</a> /
                <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-catalogs-khlebnye-kroshki']); ?>
                <span><?php echo $data->values['name']; ?></span>
            <?php }else{?>
                <span><?php echo $s; ?></span>
            <?php }?>
        </div>
    </div>
</header>
<header class="header-list-goods padding-t-20">
    <div class="container">
        <?php if($data->id > 0){?>
            <h1><?php echo $data->values['name']; ?></h1>
        <?php }else{?>
            <h1><?php echo $s; ?></h1>
        <?php }?>
        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-catalogs-produktciya']); ?>
    </div>
</header>
