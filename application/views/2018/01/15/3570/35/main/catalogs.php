<div class="header-title">
    <h1>Каталог автозапчастей. Всего позиций в наличии <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\kolichestvo-zapchastei']); ?></h1>
</div>
<div class="header-find">
    <form method="get" action="<?php echo $siteData->urlBasic;?>/catalogs" class="input-group">
        <span class="input-group-addon btn-find-car"><img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/find-car.png"></span>
        <div class="input-group-addon box-line"><div class="line"></div></div>
        <input name="name" class="form-control" type="text" placeholder="Поиск запчасти по названию…" value="<?php echo Request_RequestParams::getParamStr('name'); ?>">
        <div class="input-group-addon box-line"><div class="line gray"></div></div>
        <div class="input-group-addon box-rubric">
            <div>
                <a href="">
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/rubric.png">
                    <div class="rubric-name">Все рубрики</div>
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/points.png">
                </a>
            </div>
        </div>
        <span class="input-group-addon btn-find"><button type="submit"><img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/find.png"></button></span>
    </form>
</div>
<div  class="header-cars">
    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\zapchasti']); ?>
</div>
</div>
</div>
<?php echo trim($siteData->globalDatas['view::View_Shop_News\dostavka-i-oplata']); ?>

