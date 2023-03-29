<li class="dropdown tasks-menu bg-purple">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-paper-plane" style="margin-right: 5px"></i>
        <span class="hidden-xs">
            <?php echo $siteData->shop->getName(); ?>
        </span>
    </a>
    <?php if($siteData->operation->getIsAdmin() || $siteData->operation->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_MAKE){?>
        <ul class="dropdown-menu" style="max-height: 300px;overflow-y: auto; width: 220px">
            <?php echo trim($siteData->globalDatas['view::_shop/branch/list/top-menu']); ?>
        </ul>
    <?php } ?>
</li>

<?php if(!empty($siteData->titleTop)){ ?>
<li class="dropdown tasks-menu" style="width: ">
    <a class="top-title dropdown-toggle"><?php echo $siteData->titleTop; ?></a>
</li>
<?php } ?>
