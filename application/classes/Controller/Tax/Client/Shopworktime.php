<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopWorkTime extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopworktime';
        $this->tableID = Model_Tax_Shop_Work_Time::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Work_Time::TABLE_NAME;
        $this->objectName = 'worktime';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopworktime/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/work/time/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Tax_Shop_Work_Time', $this->_sitePageData->shopID, "_shop/work/time/list/index",
            "_shop/work/time/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/work/time/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/tax/shopworktime/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/work/time/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Tax_Shop_Work_Time', $this->_sitePageData->shopID, "_shop/work/time/list/list",
            "_shop/work/time/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc'))));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_actionJSON(
            'Request_Tax_Shop_Work_Time',
            'findShopWorkTimeIDs',
            array(
                'shop_worker_id' => array('name'),
                'work_time_type_id' => array('name')
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tax/shopworktime/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/work/time/one/new',
            )
        );

        $this->_requestWorkTimeTypes();
        $this->_requestShopWorkers();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/work/time/one/new'] = Helpers_View::getViewObject($dataID, new Model_Tax_Shop_Work_Time(),
            '_shop/work/time/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopworktime/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/work/time/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Work_Time();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Work time not is found!');
        }

        $this->_requestWorkTimeTypes($model->getWorkTimeTypeID());
        $this->_requestShopWorkers($model->getShopWorkerID());

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_Work_Time', $this->_sitePageData->shopID, "_shop/work/time/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopworktime/save';

        $result = Api_Tax_Shop_Work_Time::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult(
            $result,
            array(
                'work_time_type_name' => array(
                    'id' => 'work_time_type_id',
                    'model' => new Model_Tax_WorkTimeType(),
                ),
                'shop_worker_name' => array(
                    'id' => 'shop_worker_id',
                    'model' => new Model_Tax_Shop_Worker(),
                ),
            )
        );
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/tax/shopworktime/del';

        Api_Tax_Shop_Work_Time::delete($this->_sitePageData, $this->_driverDB);

        $this->response->body(Json::json_encode(array('error' => TRUE)));
    }

    /**
     * Делаем запрос на список
     * @param null|int $currentID
     */
    protected function _requestShopWorkers($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/list/list',
            )
        );
        $data = View_View::find('DB_Tax_Shop_Worker', $this->_sitePageData->shopID,
            "_shop/worker/list/list", "_shop/worker/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/worker/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список
     * @param $shopContractorID
     * @param null $currentID
     */
    protected function _requestWorkTimeTypes($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::work-time-type/list/list',
            )
        );
        $data = View_View::find('DB_Tax_WorkTimeType', $this->_sitePageData->shopID,
            "work-time-type/list/list", "work-time-type/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::work-time-type/list/list'] = $data;
        }
    }
}
