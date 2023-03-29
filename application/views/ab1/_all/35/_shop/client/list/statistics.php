<?php $isBalance = Request_RequestParams::getParamBoolean('is_balance');?>
<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="text-right" rowspan="2" style="width: 40px; ">№</th>
        <th rowspan="2">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/statistics'). Func::getAddURLSortBy($siteData->urlParams, '$elements$.shop_client_id.name'); ?>" class="link-black">Клиенты</a>
        </th>
        <?php if($isBalance){ ?>
            <th rowspan="2" class="width-140 text-right">
                <a href="<?php echo Func::getFullURL($siteData, '/shopclient/statistics'). Func::getAddURLSortBy($siteData->urlParams, '$elements$.shop_client_id.balance'); ?>" class="link-black">Балансы</a>
             </th>
        <?php }?>
        <th colspan="6" class="text-right">Количество в условных единицах</th>
    </tr>
    <tr>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_day'); ?>" class="link-black">Сегодня</a>
         </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_yesterday'); ?>" class="link-black">Вчера</a>
        </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_week'); ?>" class="link-black">Неделя</a>
        </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_month'); ?>" class="link-black">Месяц</a>
        </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_month_previous'); ?>" class="link-black">Прошлый месяц</a>
        </th>
        <th class="width-100 text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopclient/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity_year'); ?>" class="link-black">Год</a>
        </th>
    </tr>
    <?php
    $i = 1;
    foreach ($data['view::_shop/client/one/statistics']->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    $data = $data['view::_shop/client/one/statistics'];
    ?>
    <tr class="total">
        <td colspan="2" class="text-right">Итого</td>
        <?php if($isBalance){ ?>
            <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['balance'], TRUE, 3, FALSE); ?></td>
        <?php }?>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_day'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_yesterday'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_week'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_month_previous'], TRUE, 3, FALSE); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantity_year'], TRUE, 3, FALSE); ?></td>
    </tr>
</table>

