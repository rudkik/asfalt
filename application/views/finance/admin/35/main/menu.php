<ul class="nav nav-tabs">
    <li <?php if(strpos($siteData->url, '/shopreport/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shopreport/index">Отчеты</a></li>

    <li <?php if(strpos($siteData->url, '/shopsequence/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shopsequence/index" style="display: none">Нумерация (счетчики)</a></li>


    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Договоры <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/clientcontracttype/template') === false && strpos($siteData->url, '/clientcontracttype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/clientcontracttype/index">Категории договоров</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Работники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/shopcard/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shopcard/index">Карточки</a></li>
            <li <?php if(strpos($siteData->url, '/shopworker/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shopworker/index">Работники</a></li>
            <li <?php if(strpos($siteData->url, '/shopdepartment/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shopdepartment/index">Отделы</a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shopoperation/index">Операторы</a></li>
            <?php } ?>
        </ul>
    </li>

    <li <?php if(strpos($siteData->url, '/integration/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/integration/index">Синхронизация</a></li>

    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> Справочники <span class="caret"></span> </a>
        <ul class="dropdown-menu">
            <li <?php if(strpos($siteData->url, '/bank/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/bank/index?is_public_ignore=1">Список банков</a></li>
            <li <?php if(strpos($siteData->url, '/shopmaterialrubricmake/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shopmaterialrubricmake/index?is_public_ignore=1">Рубрики производства материала</a></li>
            <li <?php if(strpos($siteData->url, '/shoprawrubric/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shoprawrubric/index">Рубрики сырья</a></li>
            <li <?php if(strpos($siteData->url, '/clientcontractcontacttype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/clientcontractcontacttype/index">Типы котнрактов клиента</a></li>
            <li <?php if(strpos($siteData->url, '/clientcontractkind/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/clientcontractkind/index">Типы договора</a></li>
            <li <?php if(strpos($siteData->url, '/interface/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/interface/index?is_public_ignore=1">Интерфейсы</a></li>
            <li <?php if(strpos($siteData->url, '/shopbranch/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shopbranch/index?is_public_ignore=1">Филиалы</a></li>
            <li <?php if(strpos($siteData->url, '/shoprawstoragetype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shoprawstoragetype/index?is_public_ignore=1">Вид сырьевого парка</a></li>
            <li <?php if(strpos($siteData->url, '/shoprawstoragegroup/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/ab1-admin/shoprawstoragegroup/index?is_public_ignore=1">Группа сырьевого парка</a></li>
        </ul>
    </li>
</ul>