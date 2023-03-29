<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopPaid extends Controller_Cabinet_BasicCabinet {

	public function __construct(Request $request, Response $response)
	{
        $this->dbObject = 'DB_Shop_Paid';
		$this->controllerName = 'shoppaid';
		$this->tableID = Model_Shop_Paid::TABLE_ID;
		$this->tableName = Model_Shop_Paid::TABLE_NAME;
		$this->objectName = 'paid';

		parent::__construct($request, $response);
		$this->_sitePageData->controllerName = $this->controllerName;
	}

	public function action_index() {
		$this->_sitePageData->url = '/cabinet/shoppaid/index';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/paid/list/index',
			)
		);

		// тип объекта
		$type = $this->_getType();
        $this->_requestShopTableRubric($type['id']);
        $this->_requestShopOperation();
        $this->_requestShopBranch();

		// получаем список
        View_View::find('DB_Shop_Paid', $this->_sitePageData->shopID, "_shop/paid/list/index", "_shop/paid/one/index",
			$this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('shop_operation_id', 'paid_shop_id'));

		$this->_putInMain('/main/_shop/paid/index');
	}

	public function action_new()
	{
		$this->_sitePageData->url = '/cabinet/shoppaid/new';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/paid/one/new',
			)
		);

		// тип объекта
		$type = $this->_getType();
        $this->_requestShopTableRubric($type['id']);
        $this->_requestShopOperation();
        $this->_requestShopBranch();

		// получаем языки перевода
		$this->getLanguagesByShop(
			URL::query(
				array(
					'type' => $type['id'],
				), FALSE
			),
			FALSE
		);

		$dataID = new MyArray();
		$dataID->id = 0;
		// дополнительные поля
		Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
		$dataID->isFindDB = TRUE;

		$this->_sitePageData->replaceDatas['view::_shop/paid/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_Paid(),
			'_shop/paid/one/new', $this->_sitePageData, $this->_driverDB);

		$this->_putInMain('/main/_shop/paid/new');
	}

	public function action_edit()
	{
		$this->_sitePageData->url = '/cabinet/shoppaid/edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/paid/one/edit',
			)
		);

		// id записи
		$shopPaidID = Request_RequestParams::getParamInt('id');
		if ($shopPaidID === NULL) {
			throw new HTTP_Exception_404('Paids not is found!');
		}else {
			$model = new Model_Shop_Paid();
			if (! $this->dublicateObjectLanguage($model, $shopPaidID)) {
				throw new HTTP_Exception_404('Paid not is found!');
			}
		}

		// тип объекта
		$type = $this->_getType();
        $this->_requestShopTableRubric($type['id'], $model->getShopTableRubricID());
        $this->_requestShopOperation($model->getShopOperationID());
        $this->_requestShopBranch($model->getPaidShopID());

		// получаем языки перевода
		$this->getLanguagesByShop(
			URL::query(
				array(
					'id' => $shopPaidID,
					'type' => $type['id'],
				), FALSE
			),
			FALSE
		);

		// получаем данные
        View_View::findOne('DB_Shop_Paid', $this->_sitePageData->shopID, "_shop/paid/one/edit",
			$this->_sitePageData, $this->_driverDB, array('id' => $shopPaidID), array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/paid/edit');
	}

	public function action_save()
	{
		$this->_sitePageData->url = '/cabinet/shoppaid/save';
		$result = Api_Shop_Paid::save($this->_sitePageData, $this->_driverDB);
		$this->_redirectSaveResult($result);
	}

	/**
	 * Удаление
	 */
	public function action_del() {
		$this->_sitePageData->url = '/cabinet/shoppaid/del';

		Api_Shop_Paid::delete($this->_sitePageData, $this->_driverDB);
		$this->response->body(Json::json_encode(array('error' => FALSE)));
	}

	/**
	 * Делаем запрос на список операторов
	 * @param array $type
	 * @return string
	 */
	protected function _requestShopOperation($currentID = NULL){
		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/operation/list/list',
			)
		);

		$data = View_View::find('DB_Shop_Operation', $this->_sitePageData->shopID,
			"_shop/operation/list/list", "_shop/operation/one/list", $this->_sitePageData, $this->_driverDB,
			array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

		if($currentID !== NULL){
			$s = 'data-id="'.$currentID.'"';
			$data = str_replace($s, $s.' selected', $data);
			$this->_sitePageData->replaceDatas['view::_shop/operation/list/list'] = $data;
		}

		return $data;
	}

    /**
     * Делаем запрос на список брендов
     * @param array $type
     * @return string
     */
    protected function _requestShopBranch($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/list',
            )
        );

        $data = View_View::find('DB_Shop', $this->_sitePageData->shopID,
            "_shop/branch/list/list", "_shop/branch/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/branch/list/list'] = $data;
        }

        return $data;
    }
}
