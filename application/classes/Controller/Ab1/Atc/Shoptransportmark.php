<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportMark extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Mark';
        $this->controllerName = 'shoptransportmark';
        $this->tableID = Model_Ab1_Shop_Transport_Mark::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Mark::TABLE_NAME;
        $this->objectName = 'transportmark';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/atc/shoptransportmark/index';

        $this->_requestListDB('DB_Ab1_Transport_Type1c');
        $this->_requestListDB('DB_Ab1_Transport_View');
        $this->_requestListDB('DB_Ab1_Transport_Work');
        $this->_requestListDB('DB_Ab1_Transport_Wage');
        $this->_requestListDB('DB_Ab1_Transport_FormPayment');

        parent::_actionIndex(
            array(
                'transport_work_id' => array('name', 'number'),
                'transport_view_id' => array('name'),
                'transport_type_1c_id' => array('name'),
                'transport_wage_id' => array('name'),
                'transport_form_payment_id' => array('name'),
            ),
            array(
                'sort_by' => array(
                    'name' => 'asc',
                )
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/atc/shoptransportmark/new';

        $this->_requestListDB('DB_Ab1_Transport_Type1c');
        $this->_requestListDB('DB_Ab1_Transport_View');
        $this->_requestListDB('DB_Ab1_Transport_Work');
        $this->_requestListDB('DB_Ab1_Transport_Wage');
        $this->_requestListDB('DB_Ab1_Transport_FormPayment');

        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/atc/shoptransportmark/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Mark();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Transport_Type1c', $model->getTransportType1CID());
        $this->_requestListDB('DB_Ab1_Transport_View', $model->getTransportViewID());
        $this->_requestListDB('DB_Ab1_Transport_Work', $model->getTransportWorkID());
        $this->_requestListDB('DB_Ab1_Transport_Wage', $model->getTransportWageID());
        $this->_requestListDB('DB_Ab1_Transport_FormPayment', $model->getTransportFormPaymentID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}

