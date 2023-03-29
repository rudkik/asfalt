<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <ul class="nav nav-tabs">
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/pto/shopconsumable/index">Счета</a></li>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/pto/shopcar/history">История реализации</a></li>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/pto/shopmovecar/history">История перемещения</a></li>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/pto/shopcartomaterial/index">Машины с материалом</a></li>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/pto/shopreport/index">Отчеты</a></li>

            <li role="presentation" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
                <ul class="dropdown-menu">
                    <li class=""><a href="<?php echo $siteData->urlBasic; ?>/pto/shopclient/index?is_public_ignore=1">Клиенты</a></li>
                    <li class=""><a href="<?php echo $siteData->urlBasic; ?>/pto/shopmoveclient/index?is_public_ignore=1">Подразделения</a></li>
                    <?php if($siteData->operation->getIsAdmin()){ ?>
                        <li class=""><a href="<?php echo $siteData->urlBasic; ?>/pto/shopproduct/index?is_public_ignore=1">Продукты</a></li>
                        <li class=""><a href="<?php echo $siteData->urlBasic; ?>/pto/shopproductrubric/index?is_public_ignore=1">Рубрики продукции</a></li>
                        <li class=""><a href="<?php echo $siteData->urlBasic; ?>/pto/shopoperation/index?is_public_ignore=1">Операторы</a></li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Счет (редактирование)'; ?>
                <form id="shopconsumable" action="<?php echo Func::getFullURL($siteData, '/shopconsumable/save'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::_shop/consumable/one/edit']); ?>
                </form>
            </div>
        </div>
    </div>
</div>