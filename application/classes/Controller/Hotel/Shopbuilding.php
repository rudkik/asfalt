<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopBuilding extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Building';
        $this->controllerName = 'shopbuilding';
        $this->tableID = Model_Hotel_Shop_Building::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Building::TABLE_NAME;
        $this->objectName = 'building';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shopbuilding/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/building/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Hotel_Shop_Building', $this->_sitePageData->shopID, "_shop/building/list/index",
            "_shop/building/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/building/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shopbuilding/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/building/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/building/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Building(),
            '_shop/building/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shopbuilding/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/building/one/edit',
            )
        );

        // id записи
        $shopBuildingID = Request_RequestParams::getParamInt('id');
        if ($shopBuildingID === NULL) {
            throw new HTTP_Exception_404('Building not is found!');
        }else {
            $model = new Model_Hotel_Shop_Building();
            if (! $this->dublicateObjectLanguage($model, $shopBuildingID)) {
                throw new HTTP_Exception_404('Building not is found!');
            }
        }
        $model->dbGetElements($this->_sitePageData->shopID, array('bank_id'));

        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Building', $this->_sitePageData->shopID, "_shop/building/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopBuildingID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shopbuilding/save';

        $result = Api_Hotel_Shop_Building::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/hotel/shopbuilding/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/hotel/shopbuilding/index'
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
