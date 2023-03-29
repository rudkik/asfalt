<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Pto_ShopPaymentSchedule extends Controller_Ab1_Pto_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Payment_Schedule';
        $this->controllerName = 'shoppaymentschedule';
        $this->tableID = Model_Ab1_Shop_Payment_Schedule::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Payment_Schedule::TABLE_NAME;
        $this->objectName = 'paymentschedule';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/pto/shoppaymentschedule/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/schedule/list/index',
            )
        );
        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        // получаем список
        View_View::find('DB_Ab1_Shop_Payment_Schedule',
            $this->_sitePageData->shopID,
            "_shop/payment/schedule/list/index", "_shop/payment/schedule/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25), array('shop_client_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/payment/schedule/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/pto/shoppaymentschedule/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/schedule/one/new',
            )
        );
        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/payment/schedule/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Payment_Schedule(),
            '_shop/payment/schedule/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/payment/schedule/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/pto/shoppaymentschedule/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/schedule/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Payment_Schedule();
        if (!$this->dublicateObjectLanguage($model, $id, -1, false)) {
            throw new HTTP_Exception_404('Payment not is found!');
        }


        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Payment_Schedule',
            $this->_sitePageData->shopID, "_shop/payment/schedule/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_client_id')
        );

        $this->_putInMain('/main/_shop/payment/schedule/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/pto/shoppaymentschedule/save';

        $result = Api_Ab1_Shop_Payment_Schedule::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
