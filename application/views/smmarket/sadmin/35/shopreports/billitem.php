<table id="example2_wrapper" class="table table-bordered table-hover table-striped dataTable no-footer">
    <thead>
    <tr>
        <th>
            <label>
                <input type="checkbox" class="flat-red" checked>
            </label>
        </th>
        <th>Фото</th>
        <th<?php
        $sort = strtolower(Arr::path($siteData->urlParams, 'sort_by.article', ''));
        if (($sort != 'asc') && ($sort != 'desc')){
            echo ' class="sorting"';
            $sort = 'asc';
        }else {
            if ($sort == 'asc') {
                $sort = 'desc';
            } else {
                $sort = 'asc';
            }

            echo ' class="sorting_'.$sort.'"';
        }
        echo ' href="'.$siteData->urlBasic.'/cabinet/shopnew/index'.
            Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('article' => $sort), 'is_table' => '1')).
            '"';
        ?>>Артикуль</th>
        <th<?php
        $sort = strtolower(Arr::path($siteData->urlParams, 'sort_by.name', ''));
        if (($sort != 'asc') && ($sort != 'desc')){
            echo ' class="sorting"';
            $sort = 'asc';
        }else {
            if ($sort == 'asc') {
                $sort = 'desc';
            } else {
                $sort = 'asc';
            }

            echo ' class="sorting_'.$sort.'"';
        }
        echo ' href="'.$siteData->urlBasic.'/cabinet/shopnew/index'.
            Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('name' => $sort), 'is_table' => '1')).
            '"';
        ?>>Название</th>
        <th<?php
        $sort = strtolower(Arr::path($siteData->urlParams, 'sort_by.price', ''));
        if (($sort != 'asc') && ($sort != 'desc')){
            echo ' class="sorting"';
            $sort = 'asc';
        }else {
            if ($sort == 'asc') {
                $sort = 'desc';
            } else {
                $sort = 'asc';
            }

            echo ' class="sorting_'.$sort.'"';
        }
        echo ' href="'.$siteData->urlBasic.'/cabinet/shopnew/index'.
            Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('price' => $sort), 'is_table' => '1')).
            '"';
        ?>>Цена</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <tr>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>

        <td>
            <a href="" class="btn btn-default btn-sm checkbox-toggle">добавить</a>
        </td>

    </tr>
    <?php
    foreach ($data['view::shopnew/list']->childs as $value){
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

