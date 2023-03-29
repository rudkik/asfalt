<header class="header-bread-crumbs">
    <div class="container">
        <div class="box-bread-crumbs" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
            <a typeof="v:Breadcrumb" rel="v:url" property="v:title"  href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> /
            <span typeof="v:Breadcrumb" property="v:title">Данные</span>
        </div>
    </div>
</header>
<header class="header-goods-list">
    <div class="container">
        <h1 itemprop="headline">Данные</h1>
        <div class="row">
            <div class="col-md-3">
                <ul class="my-account-menu">
                    <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/my/bills">История заказов</a></li>
                    <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/my/info">Данные</a></li>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sistemnye-stati']); ?>
                </ul>
            </div>
            <div class="col-md-9">
                <form action="<?php echo $siteData->urlBasic; ?>/user/registration" method="post" style="max-width: 450px;">
                    <div class="form-group">
                        <label for="name">ФИО</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="ФИО" value="<?php echo htmlspecialchars($siteData->user->getName(), ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input type="phone" name="options[phone]" class="form-control" id="phone" placeholder="Телефон" value="<?php echo htmlspecialchars(Arr::path($siteData->user->getOptionsArray(), 'phone'), ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" value="<?php echo htmlspecialchars($siteData->user->getEMail(), ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Пароль">
                    </div>
                    <input name="url" value="<?php echo $siteData->urlBasic;?>/my/bills" style="display: none">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-red">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>