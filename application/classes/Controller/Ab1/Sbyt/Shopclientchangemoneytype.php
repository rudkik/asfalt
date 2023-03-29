<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sbyt_ShopClientChangeMoneyType extends Controller_Ab1_Sbyt_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_ChangeMoneyType';
        $this->controllerName = 'shopclientchangemoneytype';
        $this->tableID = Model_Ab1_Shop_Client_ChangeMoneyType::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_ChangeMoneyType::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/sbyt/shopclientchangemoneytype/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/change-money-type/list/index',
            )
        );
        $this->_requestListDB('DB_Ab1_Shop_Client');

        // получаем список
        View_View::find(
            $this->dbObject, $this->_sitePageData->shopMainID,
            "_shop/client/change-money-type/list/index", "_shop/client/change-money-type/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25 ),
            array('shop_client_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/client/change-money-type/index');

    }

    public function action_new(){
        $this->_sitePageData->url = '/sbyt/shopclientchangemoneytype/new';

        $this->_setGlobalDatas(
            array(
                'view::_shop/client/change-money-type/one/new',
            )
        );

        $this->_requestListDB('DB_Ab1_Shop_Client');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/client/change-money-type/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Client_ChangeMoneyType(),
            '_shop/client/change-money-type/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/client/change-money-type/new');
    }

    public function action_edit(){
        $this->_sitePageData->url = '/sbyt/shopclientchangemoneytype/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Client_ChangeMoneyType();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Client', $model->getValueInt('shop_client_id'));

        View_View::findOne($this->dbObject,$this->_sitePageData->shopID, "_shop/client/change-money-type/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->_putInMain('/main/_shop/client/change-money-type/edit');
    }

}
