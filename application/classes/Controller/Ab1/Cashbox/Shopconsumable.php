<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cashbox_ShopConsumable extends Controller_Ab1_Cashbox_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Consumable';
        $this->controllerName = 'shopconsumable';
        $this->tableID = Model_Ab1_Shop_Consumable::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Consumable::TABLE_NAME;
        $this->objectName = 'consumable';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/cashbox/shopconsumable/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/consumable/list/index',
            )
        );

        $shopTableRubricID = $this->_sitePageData->operation->getShopTableRubricID();
        if($shopTableRubricID < 1){
            $shopTableRubricID = Model_Ab1_Shop_Operation::RUBRIC_CASHBOX;
        }

        // получаем список
        View_View::find('DB_Ab1_Shop_Consumable',
            $this->_sitePageData->shopID, "_shop/consumable/list/index", "_shop/consumable/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25, 'shop_table_rubric_id' => $shopTableRubricID),
            array('shop_client_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/consumable/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/cashbox/shopconsumable/list';

        // получаем список
        $this->response->body(View_View::find('DB_Ab1_Shop_Consumable', $this->_sitePageData->shopID,
            "_shop/consumable/list/list", "_shop/consumable/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cashbox/shopconsumable/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/consumable/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/consumable/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Consumable(),
            '_shop/consumable/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/consumable/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cashbox/shopconsumable/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/consumable/one/edit',
            )
        );

        // id записи
        $shopConsumableID = Request_RequestParams::getParamInt('id');
        if ($shopConsumableID === NULL) {
            throw new HTTP_Exception_404('Consumable not is found!');
        } else {
            $model = new Model_Ab1_Shop_Consumable();
            if (!$this->dublicateObjectLanguage($model, $shopConsumableID)) {
                throw new HTTP_Exception_404('Consumable not is found!');
            }
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Consumable', $this->_sitePageData->shopID, "_shop/consumable/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopConsumableID), array('shop_client_id'));

        $this->_putInMain('/main/_shop/consumable/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cashbox/shopconsumable/save';

        $result = Api_Ab1_Shop_Consumable::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
