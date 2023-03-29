<div class="col-md-4" itemscope itemtype="http://schema.org/Product">
    <div class="goods">
        <div class="row box-img">
            <div class="col-md-4">
                <a href="<?php echo $siteData->urlBasic;?>/catalogs<?php echo $data->values['name_url']; ?>">
                    <?php if (empty($data->values['image_path'])){?>
                        <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 126, 96); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
                    <?php }else{?>
                        <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath(Arr::path(current($data->values['files']), 'file', ''), 126, 96); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
                    <?php } ?>

                </a>
            </div>
            <div class="col-md-8">
                <p class="name"><a href="<?php echo $siteData->urlBasic;?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></p>
                <p class="number">Кат. номер: <?php echo $data->values['article']; ?></p>
                <p class="price"><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?></p>
            </div>
        </div>
        <p class="text"><?php echo Func::trimTextNew($data->values['text'], 168); ?></p>
        <div class="hashtags">
            <!-- <a href="">#коробка</a> <a href="">#раздаточная</a> <a href="">#мерседес</a> <a href="">#бенц</a> -->
        </div>
        <a href="#" data-toggle="modal" data-target="#write-order-<?php echo $data->values['id']; ?>" class="btn btn-block btn-flat btn-background">Купить в 1 клик <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/button-arrow.png"></a>
    </div>
    <div id="write-order-<?php echo $data->values['id']; ?>" class="dialog-goods modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="box-close">
                    <button class="close" type="button" data-dismiss="modal"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/close.png" class="img-responsive"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-fields">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row box-images">
                                    <div class="col-md-12">
                                        <img id="img-big-<?php echo $data->values['id']; ?>" class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 570, 428); ?>">
                                    </div>
									<?php
									if(is_array($data->values['files'])) {
										foreach ($data->values['files'] as $file) {
											if (($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE) || (floatval($file['type']) == 0)) {
												?>
												<div class="col-md-3">
													<img data-id="img-big-<?php echo $data->values['id']; ?>" data-action="img-select" href="<?php echo Helpers_Image::getPhotoPath($file['file'], 570, 428); ?>" class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 139, 104); ?>" alt="<?php echo htmlspecialchars($file['title'], ENT_QUOTES);?>">
                                                    <img src="<?php echo $data->values['image_path']; ?>" itemprop="image" style="display: none">
												</div>
												<?php
											}
										}
									}
									?>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <p itemprop="name" class="name"><?php echo $data->values['name']; ?></p>
                                <p class="number">Каталожный номер: <?php echo $data->values['article']; ?></p>
                                <p class="id">ID объявления: <?php echo $data->values['id']; ?></p>
                                <div class="box-price">
                                    <div class="price"><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?></div>
                                    <div class="in-stock" style="color: #cd0000"><?php if(($data->values['is_delete'] == 0) && ($data->values['is_public'] == 1)){echo 'В наличии';}else{echo 'Нет в наличии';} ?></div>
                                </div>
                                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" style="display: none">
                                    <span itemprop="price"><?php echo $data->values['price']; ?></span>
                                    <span itemprop="priceCurrency"><?php echo $siteData->currency->getCode(); ?></span>
                                </div>
                                <p class="text-title">ОПИСАНИЕ:</p>
                                <div itemprop="description" class="text"><?php echo $data->values['text']; ?></div>
                                <form class="form-cart-add" action="<?php echo $siteData->urlBasic;?>/cart/save_bill" method="post">
                                    <div class="box-fields">
                                        <div class="input-group">
                                            <input class="form-control" name="options[name]" value="" placeholder="Ваше имя" required>
                                        </div>
                                        <div class="input-group">
                                            <input class="form-control" name="options[phone]" value="" placeholder="Номер телефона" required>
                                        </div>
                                    </div>
                                    <div class="media-left">
                                        <div style="display: none;">
                                            <input name="goods[<?php echo $data->values['id']; ?>][count]" value="1">
                                            <input name="type" value="12850">
                                            <input name="url" value="/cart-finish">
                                        </div>
                                        <button class="btn btn-block btn-flat btn-background">ЗАБРОНИРОВАТЬ</button>
                                    </div>
                                    <div class="media-body">
                                        <p class="delivery">Самовывоз: Сегодня (до 19:00)<br>
                                            Доставка по МСК: Завтра в течении дня</p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>