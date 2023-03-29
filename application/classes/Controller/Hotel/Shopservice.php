<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopService extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Service';
        $this->controllerName = 'shopservice';
        $this->tableID = Model_Hotel_Shop_Service::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Service::TABLE_NAME;
        $this->objectName = 'service';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shopservice/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/service/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Hotel_Shop_Service', $this->_sitePageData->shopID, "_shop/service/list/index",
            "_shop/service/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/service/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shopservice/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/service/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/service/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Service(),
            '_shop/service/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shopservice/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/service/one/edit',
            )
        );

        // id записи
        $shopServiceID = Request_RequestParams::getParamInt('id');
        if ($shopServiceID === NULL) {
            throw new HTTP_Exception_404('Service not is found!');
        }else {
            $model = new Model_Hotel_Shop_Service();
            if (! $this->dublicateObjectLanguage($model, $shopServiceID)) {
                throw new HTTP_Exception_404('Service not is found!');
            }
        }
        $model->dbGetElements($this->_sitePageData->shopID, array('bank_id'));

        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Service', $this->_sitePageData->shopID, "_shop/service/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopServiceID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shopservice/save';

        $result = Api_Hotel_Shop_Service::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/hotel/shopservice/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/hotel/shopservice/index'
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
