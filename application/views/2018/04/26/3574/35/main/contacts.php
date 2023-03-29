<header class="header-body">
    <div class="col-md-12">
        <div class="box-menu">
            <a href="<?php echo $siteData->urlBasic;?>"><img class="logo" src="<?php echo $siteData->shop->getImagePath();?>"></a>
            <div class="menus">
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/about">О компании</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/sectors">Направления</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/articles">Статьи</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a>
                </div>
            </div>
            <div class="contact">
                <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-sverkhu']); ?>
            </div>
        </div>
        <div class="box-body">
            <div class="box-address">
                <div class="row">
                    <div class="col-md-3">
                        <h1>Связь с нами </h1>
                    </div>
                    <div class="col-md-9">
                        <div class="address"><?php echo trim($siteData->globalDatas['view::View_Shop_Address\basic\adres-snizu']); ?></div>
                    </div>
                </div>
            </div>
            <div class="box-contacts">
                <div class="row">
                    <div class="col-md-3">
                        <h2>Контакты</h2>
                    </div>
                    <div class="col-md-9">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\contacts-telefony']); ?>
                    </div>
                </div>
            </div>
            <div class="box-message">
                <div class="row">
                    <div class="col-md-3">
                        <h2>Написать сообщение</h2>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Направление </label>
                            <input class="form-control" id="exampleInputEmail1" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Наименовании компании </label>
                            <input class="form-control" id="exampleInputEmail1" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Телефон *</label>
                            <input class="form-control" id="exampleInputEmail1" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Электронная почта *</label>
                            <input class="form-control" id="exampleInputEmail1" type="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Текст сообщения</label>
                            <textarea class="textarea"></textarea>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-warning">Отправить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>