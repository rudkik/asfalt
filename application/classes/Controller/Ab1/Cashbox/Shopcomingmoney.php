<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cashbox_ShopComingMoney extends Controller_Ab1_Cashbox_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Coming_Money';
        $this->controllerName = 'shopcomingmoney';
        $this->tableID = Model_Ab1_Shop_Coming_Money::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Coming_Money::TABLE_NAME;
        $this->objectName = 'comingmoney';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/cashbox/shopcoming/money/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/coming/money/list/index',
            )
        );


        // получаем список
        View_View::find('DB_Ab1_Shop_Coming_Money',
            $this->_sitePageData->shopID, "_shop/coming/money/list/index", "_shop/coming/money/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array('shop_cashbox_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/coming/money/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cashbox/shopcoming/money/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/coming/money/one/new',
            )
        );

        $this->_requestShopCashboxes();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/coming/money/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Coming_Money(),
            '_shop/coming/money/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/coming/money/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cashbox/shopcoming/money/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/coming/money/one/edit',
            )
        );

        // id записи
        $shopComingMoneyID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Coming_Money();
        if (!$this->dublicateObjectLanguage($model, $shopComingMoneyID, -1, false)) {
            throw new HTTP_Exception_404('ComingMoney not is found!');
        }

        $this->_requestShopCashboxes($model->getShopCashboxID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Coming_Money', $this->_sitePageData->shopID, "_shop/coming/money/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopComingMoneyID), array('shop_client_id'));

        $this->_putInMain('/main/_shop/coming/money/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cashbox/shopcoming/money/save';

        $result = Api_Ab1_Shop_Coming_Money::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
