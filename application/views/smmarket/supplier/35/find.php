<div class="body-find">
    <div class="container">
        <div class="row">
            <div class="col-md-9 margin-bottom-10px">
                <form role="search" action="/supplier/shopgood/index" method="post">
                    <div class="input-group">
                        <input name="name" placeholder="Введите название товара" class="form-control" type="text">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-fw fa-search"></i> Поиск</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <div class="cart">
                    <?php if($siteData->shop->getIsActive()){ ?>
                    <a href="/supplier/cart"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/cart-goods.png" class="img img-responsive"></a>
                    <div class="cart-title">
                        <a href="/supplier/cart"><i class="fa fa-fw fa-shopping-cart"></i></a>
                        <a class="text-red" href="/supplier/cart">Товаров : <span class="cart-count">0</span> (<span class="cart-price">0 тг</span>)</a>
                    </div>
                    <?php }else{ ?>
                    <label class="text-red">Ваш аккаунт не активирован</label>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>