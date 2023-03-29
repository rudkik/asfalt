<table id="example2" class="table table-bordered table-hover table-striped dataTable no-footer">
    <thead>
    <tr>
        <th>
            <label>
                <input type="checkbox" class="flat-red" checked>
            </label>
        </th>
        <th style="width:62px">Логотип</th>
        <th<?php
        $sort = strtolower(Arr::path($siteData->urlParams, 'sort_by.name', ''));
        if (($sort != 'asc') && ($sort != 'desc')) {
            echo ' class="sorting"';
            $sort = 'asc';
        } else {
            if ($sort == 'asc') {
                $sort = 'desc';
            } else {
                $sort = 'asc';
            }

            echo ' class="sorting_' . $sort . '"';
        }
        echo ' href="' . $siteData->urlBasic . '/manager/shop/index' . Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('name' => $sort), 'is_table' => '1')) . '"';
        ?>>Название
        </th>
        <th<?php
        $sort = strtolower(Arr::path($siteData->urlParams, 'sort_by.domain', ''));
        if (($sort != 'asc') && ($sort != 'desc')) {
            echo ' class="sorting"';
            $sort = 'asc';
        } else {
            if ($sort == 'asc') {
                $sort = 'desc';
            } else {
                $sort = 'asc';
            }

            echo ' class="sorting_' . $sort . '"';
        }
        echo ' href="' . $siteData->urlBasic . '/manager/shop/index' . Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('domain' => $sort), 'is_table' => '1')) . '"';
        ?>>Домен</th>
        <th<?php
        $sort = strtolower(Arr::path($siteData->urlParams, 'sort_by.sub_domain', ''));
        if (($sort != 'asc') && ($sort != 'desc')) {
            echo ' class="sorting"';
            $sort = 'asc';
        } else {
            if ($sort == 'asc') {
                $sort = 'desc';
            } else {
                $sort = 'asc';
            }

            echo ' class="sorting_' . $sort . '"';
        }
        echo ' href="' . $siteData->urlBasic . '/manager/shop/index' . Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('sub_domain' => $sort), 'is_table' => '1')) . '"';
        ?>>Субдомен</th>

        <th style="width:110px" <?php
        $sort = strtolower(Arr::path($siteData->urlParams, 'sort_by.to_pay_at', ''));
        if (($sort != 'asc') && ($sort != 'desc')) {
            echo ' class="sorting"';
            $sort = 'asc';
        } else {
            if ($sort == 'asc') {
                $sort = 'desc';
            } else {
                $sort = 'asc';
            }

            echo ' class="sorting_' . $sort . '"';
        }
        echo ' href="' . $siteData->urlBasic . '/manager/shop/index' . Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('to_pay_at' => $sort), 'is_table' => '1')) . '"';
        ?>>Оплачен до
        </th>
        <th style="width: 175px; text-align: left; position: relative; padding: 8px;"></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>
            <a buttom_list="new" href="<?php echo $siteData->urlBasic . '/manager/site/index'; ?>"
               class="btn btn-default btn-sm checkbox-toggle">добавить</a>
        </td>
    </tr>
    <?php
    foreach ($data['view::shop/list']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php
$view = View::factory('sladushka/manager/35/paginator');
$view->siteData = $siteData;

$urlParams = $siteData->urlParams;
$urlParams['page'] = '-pages-';

$shopBranchID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
if($shopBranchID > 0) {
    $urlParams['shop_branch_id'] = $shopBranchID;
}

$url = str_replace('-pages-', '$page$', URL::query($urlParams, FALSE));

$view->urlData = 'actionTableFind(\''.$siteData->urlBasic.$siteData->url.$url.'\', \'\', \'table_panel\')';
$view->urlAction = 'onclick';

echo Helpers_View::viewToStr($view);
?>
