<form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploaddata/save_data" method="post">
    <div class="modal-footer">
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploaddata/run_find<?php echo URL::query(array('id' => $data->id)) ?>" class="btn btn-success pull-left">Найти соответствия</a>
        <button type="submit" class="btn btn-primary">Сохранить текущие</button>
        <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploaddata/save_data<?php echo URL::query(array('is_all' => TRUE)) ?>" class="btn btn-success pull-right">Cохранить все записи</a>
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
    </div>
    <?php
    switch($data->values['table_id']) {
        case Model_Shop_Good::TABLE_ID:
            $s = 'shop-good';
            break;
        default:
            $s = '';
    }
    if(! empty($s)) {
        $view = View::factory('cabinet/35/_shop/load/data/one/data/'.$s);
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
    }
    ?>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>