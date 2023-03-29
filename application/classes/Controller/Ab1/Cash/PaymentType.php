<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_PaymentType extends Controller_Ab1_Cash_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_PaymentType';
        $this->controllerName = 'paymenttype';
        $this->tableID = Model_Ab1_PaymentType::TABLE_ID;
        $this->tableName = Model_Ab1_PaymentType::TABLE_NAME;
        $this->objectName = 'paymenttype';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/cash/paymenttype/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::payment-type/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_PaymentType', $this->_sitePageData->shopMainID, "payment-type/list/index", "payment-type/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('root_id' => array('name')));

        $this->_putInMain('/main/payment-type/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cash/paymenttype/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::payment-type/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::payment-type/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_PaymentType(),
            'payment-type/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/payment-type/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cash/paymenttype/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::payment-type/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_PaymentType();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Payment type not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Ab1_PaymentType', $this->_sitePageData->shopMainID, "payment-type/one/edit",
            $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/payment-type/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cash/paymenttype/save';

        $result = Api_Ab1_PaymentType::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

}
