<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Nbc_ShopBoxcar extends Controller_Ab1_Nbc_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Boxcar';
        $this->controllerName = 'shopboxcar';
        $this->tableID = Model_Ab1_Shop_Boxcar::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Boxcar::TABLE_NAME;
        $this->objectName = 'boxcar';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/nbc/shopboxcar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/list/index',
            )
        );

        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);
        $this->_requestShopRaws();

        // получаем список
        View_View::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID,
            "_shop/boxcar/list/index", "_shop/boxcar/one/index",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'sort_by' => array(
                        'updated_at' => 'desc',
                    ),
                    'shop_raw_id.shop_raw_rubric_id' => $this->_sitePageData->operation->getShopRawRubricIDsArray(),
                    'limit' => 1000, 'limit_page' => 25,
                ),
                false
            ),
            array(
                'shop_raw_id' => array('name'),
                'shop_boxcar_client_id' => array('name'),
                'shop_client_id' => array('name'),
                'drain_from_shop_operation_id_1' => array('name'),
                'drain_to_shop_operation_id_1' => array('name'),
                'drain_from_shop_operation_id_2' => array('name'),
                'drain_to_shop_operation_id_2' => array('name'),
                'drain_zhdc_from_shop_operation_id' => array('name'),
                'drain_zhdc_to_shop_operation_id' => array('name'),
                'zhdc_shop_operation_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/boxcar/index');
    }

    public function action_drain_from()
    {
        $this->_sitePageData->url = '/nbc/shopboxcar/drain_from';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/one/drain_from',
                'view::_shop/operation/list/drain-zhdc-from',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Boxcar();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Boxcar not is found!');
        }

        $this->_requestShopRawDrainChutes($model->getShopRawDrainChuteID());

        $data = $this->_requestShopOperations(
            Model_Ab1_Shop_Operation::RUBRIC_NBC, $model->getBrigadierDrainFromShopOperationID()
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/operation/list/brigadier', $data);

        $data = $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_NBC, $model->getDrainFromShopOperationID1());
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/operation/list/list_1', $data);

        $data = $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_NBC, $model->getDrainFromShopOperationID2());
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/operation/list/list_2', $data);

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, "_shop/boxcar/one/drain_from",
            $this->_sitePageData, $this->_driverDB, array('id' => $id),
            array(
                'shop_raw_id' => array('name'),
                'shop_boxcar_client_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/boxcar/drain_from');
    }

    public function action_drain_to()
    {
        $this->_sitePageData->url = '/nbc/shopboxcar/drain_to';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/one/drain_to',
                'view::_shop/operation/list/drain-zhdc-to',
                'view::_shop/operation/list/zhdc',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Boxcar();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Boxcar not is found!');
        }

        $data = $this->_requestShopOperations(
            Model_Ab1_Shop_Operation::RUBRIC_NBC, $model->getBrigadierDrainToShopOperationID()
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/operation/list/brigadier', $data);

        $data = $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_NBC, $model->getDrainToShopOperationID1());
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/operation/list/list_1', $data);

        $data = $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_NBC, $model->getDrainToShopOperationID2());
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/operation/list/list_2', $data);

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, "_shop/boxcar/one/drain_to",
            $this->_sitePageData, $this->_driverDB, array('id' => $id),
            array(
                'shop_raw_id' => array('name'),
                'shop_boxcar_client_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/boxcar/drain_to');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/nbc/shopboxcar/save';

        $result = Api_Ab1_Shop_Boxcar::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
