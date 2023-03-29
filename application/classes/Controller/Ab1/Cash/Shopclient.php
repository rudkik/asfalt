<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopClient extends Controller_Ab1_Cash_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client';
        $this->controllerName = 'shopclient';
        $this->tableID = Model_Ab1_Shop_Client::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client::TABLE_NAME;
        $this->objectName = 'client';

        parent::__construct($request, $response);
    }

    public function action_load_1c() {
        $filepath = DOCROOT . '1C'.DIRECTORY_SEPARATOR;
        print_r(glob($filepath . '*.xml'));
        foreach (glob($filepath . '*.xml') as $file) {
            try {
                $info = pathinfo($file);
                $new = $info['dirname'].DIRECTORY_SEPARATOR.$info['filename'].'.tmp';
                rename($file, $new);
                Api_Ab1_Shop_Client::loadXMLOne($new, $this->_sitePageData, $this->_driverDB);
                //   rename($new, $file);
                //   unlink($file);
                echo $file."\r\n".'<br>';
            }catch (Exception $e){}
        }
        echo 'ddd';die;
    }

    public function action_json() {
        $this->_sitePageData->url = '/cash/shopclientattorney/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/cash/shopclient/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/index',
            )
        );
        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        // получаем список
        View_View::find('DB_Ab1_Shop_Client', $this->_sitePageData->shopMainID, "_shop/client/list/index", "_shop/client/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25, 'id_not' => 175747));

        $this->_putInMain('/main/_shop/client/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cash/shopclient/new';
        $this->_actionShopClientNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cash/shopclient/edit';
        $this->_actionShopClientEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cash/shopclient/save';

        $result = Api_Ab1_Shop_Client::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/cash/shopclient/del';
        $result = Api_Ab1_Shop_Client::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_update()
    {
        $object = Request_RequestParams::getParamStr('object');
        $id = Request_RequestParams::getParamInt('id');

        $limit = Request_RequestParams::getParamInt('limit');
        if($limit < 1){
            $limit = 10;
        }

        $model = 'Model_' . $object;
        $object = 'DB_' . $object;
        $tmp = new Integration_Ab1_1C_Service();

        $model = new $model();
        if($id > 0) {
            if (!$this->dublicateObjectLanguage($model, $id, 0, FALSE)) {
                throw new HTTP_Exception_404('Object not is found!');
            }

            $tmp->update1C($object, $model, $this->_sitePageData, $this->_driverDB);
        }else{
            $ids = Request_Request::find(
                $object, 0, $this->_sitePageData, $this->_driverDB, ['sort_by' => ['id' => 'desc'], 'to_at_empty' => false], $limit, true
            );

            foreach ($ids->childs as $child){
                $child->setModel($model);
                $tmp->update1C($object, $model, $this->_sitePageData, $this->_driverDB);
            }
        }
    }
}