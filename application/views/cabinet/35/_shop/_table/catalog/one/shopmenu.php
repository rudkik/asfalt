<?php
switch($data->values['table_id']){
    case Model_Shop_Car::TABLE_ID:
        $file = 'cabinet/35/_shop/_table/catalog/one/shop-menu/shop-car';
        break;
    case Model_Shop_Good::TABLE_ID:
        $file = 'cabinet/35/_shop/_table/catalog/one/shop-menu/shop-good';
        break;
    case Model_Shop_New::TABLE_ID:
        $file = 'cabinet/35/_shop/_table/catalog/one/shop-menu/shop-new';
        break;
    case Model_Shop_Operation::TABLE_ID:
        $file = 'cabinet/35/_shop/_table/catalog/one/shop-menu/shop-operation';
        break;
    case Model_Shop_Table_Brand::TABLE_ID:
        $file = 'cabinet/35/_shop/_table/catalog/one/shop-menu/shopbrand';
        break;
    default:
        $file = '';
}
if(!empty($file)) {
    $view = View::factory($file);
    $view->siteData = $siteData;
    $view->data = $data;
    $view->isShowMenuAll = TRUE;
    echo Helpers_View::viewToStr($view);
}
?>