<header class="header-bread-crumbs">
    <div class="container">
        <div class="box-bread-crumbs" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
            <a typeof="v:Breadcrumb" rel="v:url" property="v:title"  href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> /
            <span typeof="v:Breadcrumb" property="v:title" >Регистрация</span>
        </div>
    </div>
</header>
<header class="header-goods-list">
    <div class="container">
        <h1 itemprop="headline">Регистрация</h1>
        <form action="<?php echo $siteData->urlBasic; ?>/user/registration" method="post" class="modal-content" style="max-width: 450px;margin: 0 auto;">
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">ФИО</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="ФИО">
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="phone" name="options[phone]" class="form-control" id="phone" placeholder="Телефон">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="E-mail">
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Пароль">
                </div>
                <input name="url" value="<?php echo $siteData->urlBasic;?>/my/bills" style="display: none">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-red">Регистрация</button>
            </div>
        </form>
    </div>
</header>