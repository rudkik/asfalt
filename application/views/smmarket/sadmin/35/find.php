<div class="body-find">
    <div class="container">
        <div class="row">
            <div class="col-md-9 margin-bottom-10px">
                <form role="search" action="/sadmin/shopgood/index" method="post">
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
                    <a href="/sadmin/cart"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/cart-goods.png" class="img img-responsive"></a>
                    <div class="cart-title">
                        <a href="/sadmin/cart"><i class="fa fa-fw fa-shopping-cart"></i></a>
                        <a class="text-red" href="/sadmin/cart">Товаров : <span class="cart-count">0</span> (<span class="cart-price">0 тг</span>)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>