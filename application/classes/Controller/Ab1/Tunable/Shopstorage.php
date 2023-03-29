<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_ShopStorage extends Controller_Ab1_Tunable_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Storage';
        $this->controllerName = 'shopstorage';
        $this->tableID = Model_Ab1_Shop_Storage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Storage::TABLE_NAME;
        $this->objectName = 'storage';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tunable/shopstorage/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Storage', $this->_sitePageData->shopMainID, "_shop/storage/list/index", "_shop/storage/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/storage/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tunable/shopstorage/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/storage/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Storage(),
            '_shop/storage/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/storage/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tunable/shopstorage/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/one/edit',
            )
        );

        // id записи
        $shopStorageID = Request_RequestParams::getParamInt('id');
        if ($shopStorageID === NULL) {
            throw new HTTP_Exception_404('Storage not is found!');
        }else {
            $model = new Model_Ab1_Shop_Storage();
            if (! $this->dublicateObjectLanguage($model, $shopStorageID, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Storage not is found!');
            }
        }
        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Storage', $this->_sitePageData->shopMainID, "_shop/storage/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopStorageID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/storage/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tunable/shopstorage/save';

        $result = Api_Ab1_Shop_Storage::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tunable/shopstorage/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tunable/shopstorage/index'
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
        $this->_sitePageData->url = '/tunable/shopstorage/del';
        $result = Api_Ab1_Shop_Storage::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
