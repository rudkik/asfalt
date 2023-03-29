<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <ul class="nav nav-tabs">
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopconsumable/index">Счета</a></li>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopcar/history">История реализации</a></li>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopmovecar/history">История перемещения</a></li>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopcartomaterial/index">Машины с материалом</a></li>
            <li class=""><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopreport/index">Отчеты</a></li>

            <li role="presentation" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
                <ul class="dropdown-menu">
                    <li class=""><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopclient/index?is_public_ignore=1">Клиенты</a></li>
                    <li class=""><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopmoveclient/index?is_public_ignore=1">Подразделения</a></li>
                    <?php if($siteData->operation->getIsAdmin()){ ?>
                        <li class=""><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopproduct/index?is_public_ignore=1">Продукты</a></li>
                        <li class=""><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopproductrubric/index?is_public_ignore=1">Рубрики продукции</a></li>
                        <li class=""><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName;?>/shopoperation/index?is_public_ignore=1">Операторы</a></li>
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