<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_Shop extends Controller_Cabinet_File {
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop';
        $this->controllerName = 'shop';
        $this->tableID = Model_Shop::TABLE_ID;
        $this->tableName = Model_Shop::TABLE_NAME;
        $this->objectName = '';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shop/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shop/edit',
            )
        );

        if (Func::isShopMenu('shop/edit', $this->_sitePageData)) {
            // получаем языки перевода
            $this->getLanguagesByShop('', FALSE);
            // список городов
            $this->_requestCity(NULL, $this->_sitePageData->shop->getCityIDsArray());
            // список стран
            $this->_requestLand($this->_sitePageData->shop->getLandIDsArray());
            // список валют
            $this->_requestCurrencies($this->_sitePageData->shop->getCurrencyIDsArray());

            // получаем список заказов
            $shops = View_View::findOne('DB_Shop', $this->_sitePageData->shopID, "shop/edit", $this->_sitePageData, $this->_driverDB,
                array('id' => $this->_sitePageData->shopID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            $this->_sitePageData->replaceDatas['view::shop/edit'] = $shops;

        } else {
            // получаем языки перевода
            $this->getLanguagesByShop('', FALSE);

            $this->_sitePageData->replaceDatas['view::shop/edit'] = '';
            $this->_sitePageData->replaceDatas['view::city/list/list'] = '';
        }

        $this->_putInMain('/main/shop/edit');
    }

    public function action_save() {
        $this->_sitePageData->url = '/cabinet/shop/save';

        $result = Api_Shop::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '?shop_branch_id='.$this->_sitePageData->branchID;
            }

            $this->redirect('/cabinet/shop/edit'.$branchID);
        }
    }

    /**
     * Проверка на уникальность заданного поля
     */
    public function action_isunique()
    {
        $this->_sitePageData->url = '/cabinet/shop/isunique';

        $field = strtolower(Request_RequestParams::getParamStr('field'));
        switch ($field) {
            case 'domain':
                break;
            case 'sub_domain':
                break;
            default:
                throw new HTTP_Exception_500('Field name error');
        }

        $value = Request_RequestParams::getParamStr('value');
        if(($value === NULL) || (empty($value))){
            throw new HTTP_Exception_500('Value empty');
        }

        $id = intval(Request_RequestParams::getParamInt('id'));
        $data = Request_Request::findNotShop('DB_Shop',$this->_sitePageData, $this->_driverDB, array($field => $value), 1);

        $result = array('error' => (!((count($data->childs) == 0) || ($data->childs[0]->id == $id))));
        $this->response->body(Json::json_encode($result));
    }
}
