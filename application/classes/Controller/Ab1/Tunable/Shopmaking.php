<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_ShopMaking extends Controller_Ab1_Tunable_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Making';
        $this->controllerName = 'shopmaking';
        $this->tableID = Model_Ab1_Shop_Making::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Making::TABLE_NAME;
        $this->objectName = 'making';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tunable/shopmaking/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/making/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Making', $this->_sitePageData->shopMainID, "_shop/making/list/index", "_shop/making/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/making/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tunable/shopmaking/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/making/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/making/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Making(),
            '_shop/making/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/making/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tunable/shopmaking/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/making/one/edit',
            )
        );

        // id записи
        $shopMakingID = Request_RequestParams::getParamInt('id');
        if ($shopMakingID === NULL) {
            throw new HTTP_Exception_404('Making not is found!');
        }else {
            $model = new Model_Ab1_Shop_Making();
            if (! $this->dublicateObjectLanguage($model, $shopMakingID, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Making not is found!');
            }
        }
        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Making', $this->_sitePageData->shopMainID, "_shop/making/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopMakingID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/making/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tunable/shopmaking/save';

        $result = Api_Ab1_Shop_Making::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tunable/shopmaking/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tunable/shopmaking/index'
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
        $this->_sitePageData->url = '/tunable/shopmaking/del';
        $result = Api_Ab1_Shop_Making::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
