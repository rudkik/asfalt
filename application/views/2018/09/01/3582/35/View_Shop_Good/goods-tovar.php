<?php
Helpers_SEO::setSEOHeader(Model_Shop_Good::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<div class="row justify-content-between">
    <div class="col-auto">
        <div class="product__title">
            <div class="section_title">
                Каталог техники
            </div>
            <div class="product__subtitle btn left invert">
                <a href="<?php echo $siteData->urlBasic;?>/catalog">
                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/more_info.png" alt="К списку техники">
                    К списку техники
                </a>
            </div>
        </div>
    </div>
    <div class="col d-flex d-lg-block flex-column align-items-sm-end align-items-start">
        <?php if(!Func::_empty(Arr::path($data->values['options'], 'price_list.file', ''))){ ?>
				<span class="btn btn--border product__links product__links--left">
					<a href="<?php echo Func::addSiteNameInFilePath(Arr::path($data->values['options'], 'price_list.file', '')); ?>" target="_blank">
						Скачать прайс-лист
						<figure class="product__links__download">
							<img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/icons/download.svg" alt="">
						</figure>
					</a>
				</span>
        <?php } ?>
        <?php if(!Func::_empty(Arr::path($data->values['options'], 'price_list.file', ''))){ ?>
        <span class="btn btn--border product__links product__links--right">
					<a href="<?php echo Func::addSiteNameInFilePath(Arr::path($data->values['options'], 'list.file', '')); ?>" target="_blank">
						Опросник
					</a>
				</span>
        <?php } ?>
    </div>
</div>
<div class="row no-gutters">
    <div class="col-12 catalog__product__wrap_block">
        <div class="catalog__product__wrap">
            <div class="row no-gutters">
                <div class="col-6 align-self-center">
                    <header class="catalog__product__title">
                        <div class="row">
                            <div class="col-12 col-lg-auto catalog__product__title__lease catalog__product__zi">
                                <div class="catalog__product__title__lease__wrap">
                                    <?php if(Arr::path($data->values['options'], 'is_lease', '') == 1){ ?>
                                        <div class="lease_true catalog__product__title__lease"><a href="<?php echo $siteData->urlBasic;?>/lease?id=<?php echo $data->values['id']; ?>">Доступен в аренду</a></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 col-lg-auto catalog__product__zi justify-content-end">
                                <div class="catalog__product__title__model">
                                    <h2><?php echo $data->values['name']; ?> <span><?php echo Arr::path($data->values['options'], 'model', ''); ?></span></h2>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="catalog__product__tth__wrap">
                        <div class="row no-gutters justify-content-center justify-content-lg-start">
                            <div class="col-12 col-lg-6 catalog__product__preview_img align-self-center">
                                <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 490, 0); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" onload="this.style.display = 'inline-block';this.nextElementSibling.classList.remove('loading');">
                                <div class="row justify-content-center loading__wrap loading">
                                    <div class="loading">
                                        <div class="loading__dotes">
                                            <div class="loading__dote"></div>
                                            <div class="loading__dote"></div>
                                            <div class="loading__dote"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 catalog__product__zi d-lg-flex">
                                <header class="product__table__title product__table__title__main bigm align-self-lg-end">
                                    Технические<br>характеристики
                                </header>
                            </div>
                        </div>
                    </div>
                    <div id="tableWrap">
                        <?php echo $data->values['text']; ?>
                    </div>

                    <script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/table.js" defer></script>
                    <script>
                        var tableStart = function () {
                            if (typeof window.App === 'undefined') {
                                setTimeout(tableStart, 100);
                            } else {
                                if (typeof App.Table !== 'undefined') {
                                    var app = new App.Table('tableWrap');
                                } else {
                                    setTimeout(tableStart, 100);
                                }
                            }
                        }
                        tableStart();
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>