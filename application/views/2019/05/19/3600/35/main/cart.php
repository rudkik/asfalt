    <header class="header-breadcrumb">
        <div class="container">
            <h1>Корзина</h1>
            <div class="breadcrumbs">
                <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> |
                <a class="active" href="<?php echo $siteData->urlBasic;?>/cart">Корзина</a>
            </div>
        </div>
    </header>
</header>
<header class="header-cart">
    <div class="container">
        <div class="row">
            <?php echo trim($siteData->globalDatas['view::View_Shop_Carts\-cart-tovary']); ?>
            <div class="col-md-12 box-total">
                <div class="pull-right">
                    <p class="total">Итого - <span><?php echo $siteData->globalDatas['view::shopcart_amount_str']; ?></span></p>
                </div>
            </div>
        </div>
        <h1>Данные получателя</h1>
        <div class="delivery-info">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">ФИО</label>
                        <input type="text" class="form-control input-tree" id="exampleInputEmail1" placeholder="ФИО">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Телефон</label>
                        <input type="phone" class="form-control input-tree" id="exampleInputEmail1" placeholder="Телефон">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Адрес</label>
                        <textarea class="form-control input-tree" id="exampleInputEmail1" placeholder="Адрес" style="height: 146px;"></textarea>
                    </div>
                </div>
            </div>
            <div class="box-agreement">
                <label>
                    <input type="checkbox" class="minimal">
                    Да, я заявляю, что ознакомлен с правилами и принимаю условия
                </label>
            </div>
            <button class="btn btn-flat btn-grey">Оформить заказ <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/arrow.png"></button>
        </div>
    </div>
</header>