<table id="example2_wrapper" class="table table-bordered table-hover table-striped dataTable no-footer">
    <thead>
    <tr>
        <th style="width: 130px; text-align: left; position: relative; padding: 8px;" <?php
        $sort = strtolower(Arr::path($siteData->urlParams, 'sort_by.article', ''));
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
        echo ' href="' . $siteData->urlBasic . '/cabinet/shopreport/day' .
            Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('bill_number' => $sort), 'is_table' => '1')) .
            '"';
        ?>>№
        </th>
        <th style=" width:150px;  text-align: left; position: relative; padding: 8px;" <?php
        $sort = strtolower(Arr::path($siteData->urlParams, 'sort_by.article', ''));
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
        echo ' href="' . $siteData->urlBasic . '/cabinet/shopreport/day' .
            Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('receiver_name' => $sort), 'is_table' => '1')) .
            '"';
        ?>>Дата
        </th>
        <th style="text-align: left; position: relative; padding: 8px;" <?php
        $sort = strtolower(Arr::path($siteData->urlParams, 'sort_by.article', ''));
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
        echo ' href="' . $siteData->urlBasic . '/cabinet/shopreport/day' .
            Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('receiver_phone' => $sort), 'is_table' => '1')) .
            '"';
        ?>>Кол-во заказов
        </th>
        <th style="width:150px; text-align: left; position: relative; padding: 8px;"<?php
        $sort = strtolower(Arr::path($siteData->urlParams, 'sort_by.article', ''));
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
        echo ' href="' . $siteData->urlBasic . '/cabinet/shopreport/day' .
            Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('amount' => $sort), 'is_table' => '1')) .
            '"';
        ?>>Стоимость
        </th>

    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::shopreport/day']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php
$view = View::factory('cabinet/35/paginator');
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
