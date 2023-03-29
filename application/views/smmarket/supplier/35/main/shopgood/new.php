<?php if($siteData->branchID > 0){ ?>
    <div class="body-bills">
        <div class="container">
            <?php
            $view = View::factory('smmarket/supplier/35/shopbranch/view');
            $view->siteData = $siteData;
            $tmp = new MyArray();
            $tmp->id = $siteData->branchID;
            $tmp->values = $siteData->branch->getValues(TRUE, TRUE);
            $view->data = $tmp;
            $view->select = 'goods';
            echo Helpers_View::viewToStr($view);
            ?>
        </div>
    </div>
<?php } ?>
<div class="body-bills">
    <div class="container">
        <h3>Добавить товар</h3>
        <div class="row">
            <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgood/save" method="post" style="padding-right: 5px;">
                <?php echo trim($data['view::shopgood/new']); ?>
            </form>
        </div>
    </div>
</div>