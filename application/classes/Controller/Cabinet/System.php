<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_System extends Controller_Cabinet_BasicCabinet
{
    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'system';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_synhronize_smmarket(){
        set_time_limit(360000);

        $this->response->body('Филиалы: ');

        $_POST = array (
            'email' => 'smmarket@oto.kz',
            'password' => 'smmarket',
            'url' => 'http://smmarket.kz/cabinet/shopbranch/list?type=3724&file_type=xml',
            'request_params' => array(
                'shop_branch_type_id' => 15740,
            ),
            'request_params' => array(
                'shop_branch_type_id' => 15740,
                'is_public' => 0,
            ),
        );
        include_once 'Shopbranch.php';
        $controller = new Controller_Cabinet_ShopBranch($this->request, $this->response);
        $controller->isAccess();
        $controller->action_load_xml_in_url();

        $this->response->body('Товары: ');
        $_POST = array (
            'email' => 'smmarket@oto.kz',
            'password' => 'smmarket',
            'url' => 'http://smmarket.kz/cabinet/shopgood/list?type=3722&file_type=xml&shop_branch_id=__shop_branch_id__',
            'request_params' => array(
                'shop_table_catalog_id' => 15730,
            ),
            'request_params' => array(
                'shop_table_catalog_id' => 15730,
                'is_public' => 0,
            ),
            'parser' => array(
                'price' => 'options.price_b',
            ),
        );
        include_once 'Shopgood.php';
        $controller = new Controller_Cabinet_ShopGood($this->request, $this->response);
        $controller->isAccess();
        $controller->action_load_xml_in_url();
    }



    public function action_backup(){
        $params = Request_RequestParams::setParams(array('is_public_ignore' => TRUE, 'is_delete_ignore' => TRUE));
        $ids = Request_Request::findNotShop('DB_Bank', $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Bank::TABLE_NAME);

        $ids = Request_BillStatus::getBillStatusIDs($this->_sitePageData, $this->_driverDB, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_BillStatus::TABLE_NAME);
        $ids = Request_CalendarEventType::getCalendarEventTypeIDs($this->_sitePageData, $this->_driverDB, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_CalendarEventType::TABLE_NAME);
        $ids = Request_City::findCityIDs($this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_City::TABLE_NAME);
        $ids = Request_ContactType::getContactTypeIDs($this->_sitePageData, $this->_driverDB, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_ContactType::TABLE_NAME);
        $ids = Request_Currency::getCurrencyIDs($this->_sitePageData, $this->_driverDB, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Currency::TABLE_NAME);
        $ids = Request_DeliveryType::getDeliveryTypeIDs($this->_sitePageData, $this->_driverDB, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_DeliveryType::TABLE_NAME);
        $ids = Request_EMailType::findEMailTypeIDs($this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_EMailType::TABLE_NAME);
        $ids = Request_Land::findLandIDs($this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Land::TABLE_NAME);
        $ids = Request_Request::findAllNotShop(DB_Language::NAME, $this->_sitePageData, $this->_driverDB, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Language::TABLE_NAME);
        $ids = Request_OrganizationType::findOrganizationTypeIDs($this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_OrganizationType::TABLE_NAME);
        $ids = Request_PaidType::getPaidTypeIDs($this->_sitePageData, $this->_driverDB, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_PaidType::TABLE_NAME);
       // $ids = Request_Region::findRegionIDs($this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
       // echo $this->_driverDB->saveSQLInsertList($ids, Model_Region::TABLE_NAME);
        $ids = Request_Request::findNotShop('DB_Shop',$this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Action', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Action::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Address',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Address::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_AddressContact', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_AddressContact::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Bill::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Bill_Item::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Bill_Status', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Bill_Status::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Calendar', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Calendar::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Client', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Client::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_ClientContact', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Client_Contact::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Comment', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Comment::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Coupon', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Coupon::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_DeliveryType', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_DeliveryType::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Discount', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Discount::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_EMail', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_EMail::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_File', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_File::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Gallery', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Gallery::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Good',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Good::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Good_To_Operation', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Good_To_Operation::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Image', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Image::TABLE_NAME);
       // $ids = Request_Request::find('DB_Shop_Load_Data', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
       // echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Load_Data::TABLE_NAME);
       // $ids = Request_Request::find('DB_Shop_LoadFile', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
       // echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_LoadFile::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Message', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Message::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Message_Chat', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Message_Chat::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_New', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_New::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Operation',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Operation::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Operation_Stock', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Operation_Stock::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Operation_Stock_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Operation_Stock_Item::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Paid', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Paid::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_PaidType', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_PaidType::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Question', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Question::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Return', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Return::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Return_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Return_Item::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Brand',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Brand::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Catalog',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Catalog::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Child', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Child::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Filter', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Filter::TABLE_NAME);
        //$ids = Request_Request::find('DB_Shop_Table_Group', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        //echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Group::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Hashtag', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Hashtag::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_ObjectToObject', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_ObjectToObject::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Revision', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Revision::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Revision_Child', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Revision_Child::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Rubric::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Select', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Select::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Similar', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Similar::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Stock',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Stock::TABLE_NAME);
        $ids = Request_Request::find('DB_Shop_Table_Unit', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_Shop_Table_Unit::TABLE_NAME);
        $ids = Request_Request::findAllNotShop('DB_SiteShablon', $this->_sitePageData, $this->_driverDB, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_SiteShablon::TABLE_NAME);
        $ids = Request_Request::findNotShop('DB_User', $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);
        echo $this->_driverDB->saveSQLInsertList($ids, Model_User::TABLE_NAME);
    }
}