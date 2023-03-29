<div class="header header-breakpoint" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
    <div class="container">
        <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/general/index">Главная</a></span> /
        <span typeof="v:Breadcrumb" class="active"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/account/index">Личный кабинет</a></span>
    </div>
</div>
<div class="header header-rubrics">
    <div class="container">
        <div class="row">
                <?php echo trim($data['view::_shop/account/list/account']); ?>
        </div>
    </div>
</div>
<style>
    .account-card{
        margin: 15px 0;
        text-align: center;
        text-transform: uppercase;
        transition: all .3s;
        color: #fff;
        background-color: rgb(0, 128, 128);
        border-radius: 3px;
        height: 87%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        justify-content: space-around;
    }
    .account-card-link{
        text-decoration: none;
        display: block;
        padding: 25px 15px;
        color: white;
    }
    .account-card:hover{
        background-color: #188ccd;
    }
    .account-card-link-ico{
        font-size: 64px;
    }
</style>
