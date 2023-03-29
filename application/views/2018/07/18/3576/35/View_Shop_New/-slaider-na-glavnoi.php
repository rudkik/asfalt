<div class="item">
    <div class="slider" style="background: url('<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 1920, 800); ?>') no-repeat scroll center bottom transparent;">
        <a class="title-company" href="<?php echo $siteData->urlBasicLanguage;?>" ><span>КАРА ДАЛА</span><!--<img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo-t.png"> --></a>
        <?php  if($siteData->url == '/contacts'){ ?>
            <!--  <h1>Контакты</h1> -->
        <?php }elseif($siteData->url == '/reserv'){ ?>
           <!--  <h1>Бронирование</h1> -->
        <?php }elseif($siteData->url == '/free/rooms'){ ?>
          <!--   <h1>Бронирование номеров</h1> -->
        <?php }elseif (($siteData->url == '/') || ($siteData->url == '')){ ?>
            <h1>Горячие источники Чунджи</h1>
            <!--<p>Термальная вода из скважины 650 метров глубиной способствует процессу саморегуляции всего организма, что повышает его сопротивляемость различного рода заболеваниям.</p>-->
        <?php }else{ ?>
           <!-- <h1><?php
                $siteData->addKeyInGlobalDatas('view::title_page');
                echo $siteData->globalDatas['view::title_page'];
                ?></h1> -->
        <?php } ?>
    </div>
</div>