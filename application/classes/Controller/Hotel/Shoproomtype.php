<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopRoomType extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Room_Type';
        $this->controllerName = 'shoproomtype';
        $this->tableID = Model_Hotel_Shop_Room_Type::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Room_Type::TABLE_NAME;
        $this->objectName = 'roomtype';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shoproomtype/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/room/type/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Hotel_Shop_Room_Type', $this->_sitePageData->shopID, "_shop/room/type/list/index",
            "_shop/room/type/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/room/type/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shoproomtype/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/room/type/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/room/type/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Room_Type(),
            '_shop/room/type/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shoproomtype/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/room/type/one/edit',
            )
        );

        // id записи
        $shopRoomTypeID = Request_RequestParams::getParamInt('id');
        if ($shopRoomTypeID === NULL) {
            throw new HTTP_Exception_404('Room type not is found!');
        }else {
            $model = new Model_Hotel_Shop_Room_Type();
            if (! $this->dublicateObjectLanguage($model, $shopRoomTypeID)) {
                throw new HTTP_Exception_404('Room type not is found!');
            }
        }

        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Room_Type', $this->_sitePageData->shopID, "_shop/room/type/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopRoomTypeID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shoproomtype/save';

        $result = Api_Hotel_Shop_Room_Type::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/hotel/shoproomtype/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/hotel/shoproomtype/index'
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
}
