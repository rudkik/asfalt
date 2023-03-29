<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopFloor extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Floor';
        $this->controllerName = 'shopfloor';
        $this->tableID = Model_Hotel_Shop_Floor::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Floor::TABLE_NAME;
        $this->objectName = 'floor';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shopfloor/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/floor/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Hotel_Shop_Floor', $this->_sitePageData->shopID, "_shop/floor/list/index",
            "_shop/floor/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/floor/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/hotel/shopfloor/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/floor/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Hotel_Shop_Floor', $this->_sitePageData->shopID, "_shop/floor/list/list",
            "_shop/floor/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc'))));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/hotel/shopfloor/json';

        $this->_getJSONList(
            $this->_sitePageData->shopID,
            [],
            array(
                'shop_building_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shopfloor/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/floor/one/new',
            )
        );

        $this->_requestShopBuildings();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/floor/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Floor(),
            '_shop/floor/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shopfloor/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/floor/one/edit',
            )
        );

        // id записи
        $shopFloorID = Request_RequestParams::getParamInt('id');
        if ($shopFloorID === NULL) {
            throw new HTTP_Exception_404('Floor not is found!');
        }else {
            $model = new Model_Hotel_Shop_Floor();
            if (! $this->dublicateObjectLanguage($model, $shopFloorID)) {
                throw new HTTP_Exception_404('Floor not is found!');
            }
        }

        $this->_requestShopBuildings($model->getShopBuildingID());

        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Floor', $this->_sitePageData->shopID, "_shop/floor/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopFloorID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shopfloor/save';

        $result = Api_Hotel_Shop_Floor::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];
            $result['values']['shop_building_name'] = '';

            $tmp = $result['values']['shop_building_id'];
            if ($tmp > 0){
                $model = new Model_Hotel_Shop_Building();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['shop_building_name'] = $model->getName();
                }
            }

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/hotel/shopfloor/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/hotel/shopfloor/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestShopBuildings($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/building/list/list',
            )
        );
        $data = View_View::find('DB_Hotel_Shop_Building', $this->_sitePageData->shopID,
            "_shop/building/list/list", "_shop/building/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/building/list/list'] = $data;
        }
    }
}
