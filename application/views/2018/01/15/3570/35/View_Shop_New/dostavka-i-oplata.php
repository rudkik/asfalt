<div class="box-white">
    <div class="container">
        <div class="scroll">
            <div class="header-delivery">
                <h2><?php echo $data->values['name']; ?></h2>
				<?php echo trim($siteData->globalDatas['view::View_Shop_News\dostavka-i-oplata-spisok']); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info"><?php echo $data->values['text']; ?></div>
                    </div>
                    <div class="col-md-6">
                        <h2>У ВАС ВОЗНИКЛИ ВОПРОСЫ?</h2>
                        <h3>Спросите у нас и мы ответим на ваш вопрос!</h3>
                        <div>
                            <button class="btn btn-flat btn-background">ПРОКОНСУЛЬТИРОВАТЬСЯ</button>
                        </div>
                    </div>
                </div>
                <p class="copyrighted">© 2018 Razbor-city.ru - “Разборка автомобилей в Москве”</p>
            </div>
            <img class="img-bottom" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/car-6.png">
        </div>
    </div>
</div>