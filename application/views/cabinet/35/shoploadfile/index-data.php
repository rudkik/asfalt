<form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/savelist" method="post">
    <div class="modal-footer">
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/runfind?id=<?php echo $data->id; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="btn btn-success pull-left">Найти соответствия</a>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
    <?php
    switch($data->values['table_id']) {
        case Model_Shop_Good::TABLE_ID:
            $s = 'shopgood';
            break;
        default:
            $s = '';
    }
    if(! empty($s)) {
        $view = View::factory('cabinet/35/shoploadfile/index-data/'.$s);
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
    }
    ?>
    <div class="modal-footer">
        <div hidden>
            <?php echo Func::getURLParamsToInput($_GET);?>

            <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
            <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
            <?php if($siteData->branchID > 0){ ?>
                <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
            <?php } ?>
            <?php if($siteData->superUserID > 0){ ?>
                <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
            <?php } ?>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>