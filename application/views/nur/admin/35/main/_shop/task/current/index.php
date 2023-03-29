<div class="page-header">
    <div class="page-header-title">
        <h4>Выполненные задачи</h4>
    </div>
</div>
<form class="row" action="/nur-admin/shoptaskcurrent/index" method="get">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="shop_bookkeeper_id" class="block">Бухгалтер</label>
            <select name="shop_bookkeeper_id" id="shop_bookkeeper_id" class="js-example-basic-single" data-type="select2" style="width: 100%">
                <option value="-1" data-id="-1">Выберите значение</option>
                <?php
                $tmp = 'data-id="'.Request_RequestParams::getParamInt('shop_bookkeeper_id').'"';
                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/list']));
                ?>
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="shop_branch_id" class="block">Клиент</label>
            <select name="shop_branch_id" id="shop_branch_id" class="js-example-basic-single" data-type="select2" style="width: 100%">
                <option value="-1" data-id="-1">Выберите значение</option>
                <?php
                $tmp = 'data-id="'.Request_RequestParams::getParamInt('shop_branch_id').'"';
                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                ?>
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <input name="period" value="<?php echo Request_RequestParams::getParamStr('period'); ?>" style="display: none">
        <button type="submit" class="btn btn-primary pull-right" style="margin-top: 26px;">Поиск</button>
    </div>
</form>
<div class="page-body">
    <?php echo trim($data['view::_shop/task/current/list/index']); ?>
</div>