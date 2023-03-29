<div class="col-12 catalog__product__wrap_block">
    <div class="catalog__product__wrap">
        <div class="row relative">
            <div class="col-6 align-self-lg-center">
                <header class="catalog__product__title">
                    <div class="row">
                        <div class="col-lg-3 col-6 fix420 fix420margin catalog__product__zi align-self-center">
                            <div class="catalog__product__title__lease__wrap">
								<?php if(Arr::path($data->values['options'], 'is_lease', '') == 1){ ?>
                                	<div class="lease_true catalog__product__title__lease"><a href="<?php echo $siteData->urlBasic;?>/lease?id=<?php echo $data->values['id']; ?>">Доступен в аренду</a></div>
								<?php } ?>
							</div>
                        </div>
                        <div class="col-lg-3 col-6 fix420 catalog__product__zi justify-content-lg-end">
                            <div class="catalog__product__title__model">
                                <h2><?php echo $data->values['name']; ?> <span><?php echo Arr::path($data->values['options'], 'model', ''); ?></span></h2>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="catalog__product__tth__wrap">
                    <div class="row">
                        <div class="col-6 fix420 catalog__product__zi">
                            <p class="catalog__product__tth">
								Производительность <span><?php echo Arr::path($data->values['options'], 'performance', ''); ?></span><br>
								Двигатель <span><?php echo Arr::path($data->values['options'], 'motor', ''); ?></span><br>
								Номинальная мощность <span><?php echo Arr::path($data->values['options'], 'rating', ''); ?></span>
                            </p>
                            <span class="btn catalog__product__tth__more_info">
                                <a href="<?php echo $siteData->urlBasic; ?>/catalog<?php echo $data->values['name_url']; ?>">
                                    Подробнее
                                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/more_info.png" alt="Подробнее">
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 catalog__product__preview_img align-self-lg-center">
                <a href="<?php echo $siteData->urlBasic; ?>/catalog<?php echo $data->values['name_url']; ?>">
                    <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 490, 0); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" style="display: inline-block;">
                    <div class="row justify-content-center loading__wrap">
                        <div class="loading">
                            <div class="loading__dotes">
                                <div class="loading__dote">
                                </div>
                                <div class="loading__dote">
                                </div>
                                <div class="loading__dote">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>