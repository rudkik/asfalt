<?php
/**
 * Created by PhpStorm.
 * User: abylkhasov
 * Date: 23.02.16
 * Time: 22:31
 */?>
<table id="example2_wrapper" class="table table-bordered table-hover table-striped dataTable no-footer">
    <thead>
    <tr>
        <th style="text-align: left; width: 250px; position: relative; padding: 8px;" <?php
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
        echo ' href="' . $siteData->urlBasic . '/cabinet/shopcounter/index' .
            Func::getAddURLParams($siteData->urlParams, array('sort_by' => array('name' => $sort), 'is_table' => '1')) .
            '"';
        ?>>Название
        </th>
        <th>Описание</th>
        <th style="width: 100px; text-align: left; position: relative; padding: 8px;"></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="text-align: left; position: relative; padding: 8px;">...</td>
        <td>...</td>
        <td>
            <a buttom_list="new" href="<?= $siteData->urlBasic.'/cabinet/shopcounter/new';?>"
               class="btn btn-default btn-sm checkbox-toggle">добавить</a>
        </td>
    </tr>
    <?php
    foreach ($data['view::shopcounter/list']->childs as $value) {
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
