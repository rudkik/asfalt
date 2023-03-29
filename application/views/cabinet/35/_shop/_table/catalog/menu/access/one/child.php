<?php
$file = 'cabinet/35/_shop/_table/catalog/menu/access/one/child/';

if(!empty($file)) {
    switch ($data->values['table_id']) {
        case Model_Shop_Model::TABLE_ID:
            $file = $file . 'shop-model';
            break;
        case Model_Shop_Mark::TABLE_ID:
            $file = $file . 'shop-mark';
            break;
        case Model_Shop_Table_Brand::TABLE_ID:
            $file = $file . 'shopbrand';
            break;
        case Model_Shop_Table_Hashtag::TABLE_ID:
            $file = $file . 'shophashtag';
            break;
        case Model_Shop_Table_Filter::TABLE_ID:
            $file = $file . 'shopfilter';
            break;
        case Model_Shop_Table_Select::TABLE_ID:
            $file = $file . 'shopselect';
            break;
        case Model_Shop_Table_Unit::TABLE_ID:
            $file = $file . 'shopunit';
            break;
        case Model_Shop_Table_Stock::TABLE_ID:
            $file = $file . 'shoptablestock';
            break;
        case Model_Shop_Table_Revision::TABLE_ID:
            $file = $file . 'shoptablerevision';
            break;
        case Model_Shop_Table_Param::TABLE_ID:
            $file = $file . 'shop-table-param';
            break;
        default:
            $file = '';
    }
    if (!empty($file)) {
        $view = View::factory($file);
        $view->siteData = $siteData;
        $view->data = $data;
        $view->isShowMenuAll = TRUE;
        echo Helpers_View::viewToStr($view);
    }
}
?>