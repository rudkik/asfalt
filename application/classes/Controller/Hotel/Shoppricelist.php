<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopPricelist extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Pricelist';
        $this->controllerName = 'shoppricelist';
        $this->tableID = Model_Hotel_Shop_Pricelist::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Pricelist::TABLE_NAME;
        $this->objectName = 'pricelist';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shoppricelist/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/pricelist/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Hotel_Shop_Pricelist', $this->_sitePageData->shopID, "_shop/pricelist/list/index",
            "_shop/pricelist/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/pricelist/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shoppricelist/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/pricelist/one/new',
                'view::_shop/pricelist/item/list/index',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $shopRoomIDs = Request_Request::find( 'DB_Hotel_Shop_Room',
            $this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB,$params, 0, TRUE
        );

        $ids = new MyArray();
        foreach ($shopRoomIDs->childs as $child){
            $room = $ids->addChild($child->id);
            $room->values['shop_room_id'] = $child->id;
            $room->setElementValue('shop_room_id', $child->values['name']);
            $room->isFindDB = TRUE;
            $room->isParseData = TRUE;
        }

        $this->_sitePageData->replaceDatas['view::_shop/pricelist/item/list/index'] =
            Helpers_View::getViewObjects(
                $ids, new Model_Hotel_Shop_Pricelist(),
                '_shop/pricelist/item/list/index', '_shop/pricelist/item/one/index',
                $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
            );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/pricelist/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Pricelist(),
            '_shop/pricelist/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shoppricelist/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/pricelist/one/edit',
                'view::_shop/pricelist/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Hotel_Shop_Pricelist();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Pricelist not is found!');
        }

        $shopRoomIDs = Request_Request::findAll('DB_Hotel_Shop_Room', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,0, TRUE);
        $shopRoomIDs->runIndex();

        $params = Request_RequestParams::setParams(
            array(
                'shop_pricelist_id' => $id,
                'sort_by' => array('id' => 'asc'),
            )
        );
        $ids = Request_Request::find('DB_Hotel_Shop_Pricelist_Item',
            $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_room_id' => array('name'))
        );

        foreach ($ids->childs as $child) {
            $shopRoomID = $child->values['shop_room_id'];
            if (key_exists($shopRoomID, $shopRoomIDs->childs)) {
                unset($shopRoomIDs->childs[$shopRoomID]);
            }
        }

        foreach ($shopRoomIDs->childs as $child){
            $room = $ids->addChild($child->id);
            $room->values['shop_room_id'] = $child->id;
            $room->setElementValue('shop_room_id', $child->values['name']);
            $room->isFindDB = TRUE;
            $room->isParseData = TRUE;
        }

        $this->_sitePageData->replaceDatas['view::_shop/pricelist/item/list/index'] =
            Helpers_View::getViewObjects(
                $ids, new Model_Hotel_Shop_Pricelist(),
                '_shop/pricelist/item/list/index', '_shop/pricelist/item/one/index',
                $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
            );

        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Pricelist', $this->_sitePageData->shopID, "_shop/pricelist/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('bank_id'));


        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shoppricelist/save';

        $result = Api_Hotel_Shop_Pricelist::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult(
            $result,
            array()
        );
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/hotel/shoppricelist/del';

        Api_Hotel_Shop_Pricelist::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => TRUE)));
    }
}
