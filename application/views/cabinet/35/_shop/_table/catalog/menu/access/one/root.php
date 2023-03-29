<?php
$file = 'cabinet/35/_shop/_table/catalog/menu/access/one/root/';

switch($data->values['table_id']){
    case Model_Shop_Car::TABLE_ID:
        $file = $file . 'shop-car';
        break;
    case Model_Shop_Message::TABLE_ID:
        $file = $file . 'shop-message';
        break;
    case Model_Shop_Good::TABLE_ID:
        $file = $file . 'shopgood';
        break;
    case Model_Shop_New::TABLE_ID:
        $file = $file . 'shopnew';
        break;
    case Model_Shop_Gallery::TABLE_ID:
        $file = $file . 'shopgallery';
        break;
    case Model_Shop_File::TABLE_ID:
        $file = $file . 'shopfile';
        break;
    case Model_Shop_Calendar::TABLE_ID:
        $file = $file . 'shopcalendar';
        break;
    case Model_Shop_Operation::TABLE_ID:
        $file = $file . 'shopoperation';
        break;
    case Model_Shop_Coupon::TABLE_ID:
        $file = $file . 'shopcoupon';
        break;
    case Model_Shop_PersonDiscount::TABLE_ID:
        $file = $file . 'shop-person-discount';
        break;
    case Model_Shop_Comment::TABLE_ID:
        $file = $file . 'shopcomment';
        break;
    case Model_Shop_Client::TABLE_ID:
        $file = $file . 'shopclient';
        break;
    case Model_Shop::TABLE_ID:
        $file = $file . 'shopbranch';
        break;
    case Model_Shop_Question::TABLE_ID:
        $file = $file . 'shopquestion';
        break;
    case Model_Shop_Bill::TABLE_ID:
        $file = $file . 'shopbill';
        break;
    case Model_Shop_Paid::TABLE_ID:
        $file = $file . 'shoppaid';
        break;
    case Model_Shop_Return::TABLE_ID:
        $file = $file . 'shopreturn';
        break;
    case Model_Shop_Operation_Stock::TABLE_ID:
        $file = $file . 'shopoperationstock';
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
