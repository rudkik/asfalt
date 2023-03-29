<div class="body-find">
    <div class="container">
        <div class="row">
            <div class="col-md-9 margin-bottom-10px">
                <form role="search" action="/customer/shopgood/index" method="get">
                    <div class="input-group">
                        <input name="name" placeholder="Введите название товара" class="form-control" type="text">
                        <span class="input-group-btn">
                            <input name="type" value="3722" hidden>
                            <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-fw fa-search"></i> Поиск</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <div class="cart">
                    <?php if($siteData->shop->getIsActive() &&  $siteData->shop->getIsPublic()){ ?>
                        <a href="/customer/shopcart/index"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/cart-goods.png" class="img img-responsive"></a>
                        <div class="cart-title">
                            <a href="/customer/shopcart/index"><i class="fa fa-fw fa-shopping-cart"></i></a>
                            <a class="text-red" href="/customer/shopcart/index">Товаров : <span class="cart-count"><?php echo $siteData->globalDatas['view::cart_count']; ?> шт.</span> (<span class="cart-price"><?php echo $siteData->globalDatas['view::cart_amount_str']; ?></span>)</a>
                        </div>
                    <?php }else{ ?>
                        <label class="text-red">Ваш аккаунт не активирован</label>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>