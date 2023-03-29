<?php  $siteData->replaceDatas['view::title_page'] = 'FAQ'; ?>
<header class="header-comment">
    <div class="container">
        <div class="div-center">
            <h2>FAQ</h2>
            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        </div>
        <?php echo trim($siteData->globalDatas['view::View_Shop_Questions\faq-voprosy']); ?>
	</div>
</header>