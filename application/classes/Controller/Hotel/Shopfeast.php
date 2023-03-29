<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopFeast extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Feast';
        $this->controllerName = 'shopfeast';
        $this->tableID = Model_Hotel_Shop_Feast::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Feast::TABLE_NAME;
        $this->objectName = 'feast';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shopfeast/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/feast/list/index',
            )
        );

        View_View::find('DB_Hotel_Shop_Feast', $this->_sitePageData->shopID, "_shop/feast/list/index",
            "_shop/feast/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/feast/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shopfeast/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/feast/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/feast/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Feast(),
            '_shop/feast/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shopfeast/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/feast/one/edit',
            )
        );

        // id записи
        $shopFeastID = Request_RequestParams::getParamInt('id');
        if ($shopFeastID === NULL) {
            throw new HTTP_Exception_404('Feast not is found!');
        }else {
            $model = new Model_Hotel_Shop_Feast();
            if (! $this->dublicateObjectLanguage($model, $shopFeastID)) {
                throw new HTTP_Exception_404('Feast not is found!');
            }
        }

        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Feast', $this->_sitePageData->shopID, "_shop/feast/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopFeastID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shopfeast/save';

        $result = Api_Hotel_Shop_Feast::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/hotel/shopfeast/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/hotel/shopfeast/index'
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

    public function action_del()
    {
        $this->_sitePageData->url = '/hotel/shopfeast/del';

        Api_Hotel_Shop_Feast::delete($this->_sitePageData, $this->_driverDB);

        $this->response->body(Json::json_encode(array('error' => TRUE)));
    }
}
