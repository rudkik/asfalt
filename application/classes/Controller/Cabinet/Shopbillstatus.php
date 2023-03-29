<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopBillStatus extends Controller_Cabinet_BasicCabinet
{
	public function __construct(Request $request, Response $response)
	{
        $this->dbObject = 'DB_Shop_Bill_Status';
		$this->controllerName = 'shopbillstatus';
		$this->tableID = Model_Shop_Bill_Status::TABLE_ID;
		$this->tableName = Model_Shop_Bill_Status::TABLE_NAME;
		$this->objectName = 'billstatus';

		parent::__construct($request, $response);
		$this->_sitePageData->controllerName = $this->controllerName;
	}

	public function action_index()
	{
		$this->_sitePageData->url = '/cabinet/shopbillstatus/index';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/bill/status/list/index',
			)
		);

		// получаем список
        View_View::find('DB_Shop_Bill_Status', $this->_sitePageData->shopID, "_shop/bill/status/list/index", "_shop/bill/status/one/index",
			$this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

		$this->_putInMain('/main/_shop/bill/status/index');
	}

	public function action_sort()
	{
		$this->_sitePageData->url = '/cabinet/shopbillstatus/sort';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/bill/status/list/index',
			)
		);

		// получаем список
		$this->_sitePageData->replaceDatas['view::_shop/bill/status/list/index'] = View_View::find('DB_Shop_Bill_Status', $this->_sitePageData->shopID,
			"_shop/bill/status/list/sort", "_shop/bill/status/one/sort", $this->_sitePageData, $this->_driverDB,
			array_merge($_GET, $_POST, array('sort_by' => array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

		$this->_putInMain('/main/_shop/bill/status/index');
	}

	public function action_index_edit()
	{
		$this->_sitePageData->url = '/cabinet/shopbillstatus/index_edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/bill/status/list/index',
				'view::editfields/list',
			)
		);


		$fields =
			'<option data-id="old_id" value="old_id">ID</option>'
			. '<option data-id="name" value="name">Название</option>';

		$fields = $fields
			. '<option data-id="is_public" value="is_public">Опубликован</option>';
		$this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

		// получаем список
		$this->_sitePageData->replaceDatas['view::_shop/bill/status/list/index'] = View_View::find('DB_Shop_Bill_Status', $this->_sitePageData->shopID,
			"_shop/billstatus/list/index-edit", "_shop/bill/status/one/index-edit",
			$this->_sitePageData, $this->_driverDB,
			array_merge(array('sort_by' => array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
			array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/bill/status/index');
	}

	public function action_new()
	{
		$this->_sitePageData->url = '/cabinet/shopbillstatus/new';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/bill/status/one/new',
			)
		);

		// получаем языки перевода
		$this->getLanguagesByShop(
			URL::query(
				array(), FALSE
			),
			FALSE
		);

		$dataID = new MyArray();
		$dataID->id = 0;
		$dataID->isFindDB = TRUE;

		$this->_sitePageData->replaceDatas['view::_shop/bill/status/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_Bill_Status(),
			'_shop/bill/status/one/new', $this->_sitePageData, $this->_driverDB);

		$this->_putInMain('/main/_shop/bill/status/new');
	}

	public function action_edit()
	{
		$this->_sitePageData->url = '/cabinet/shopbillstatus/edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/bill/status/one/edit',
			)
		);

		// id записи
		$shopBillStatusID = Request_RequestParams::getParamInt('id');
		if ($shopBillStatusID === NULL) {
			throw new HTTP_Exception_404('Bill status not is found!');
		} else {
			$modelBillStatus = new Model_Shop_Bill_Status();
			if (!$this->dublicateObjectLanguage($modelBillStatus, $shopBillStatusID)) {
				throw new HTTP_Exception_404('Bill status not is found!');
			}
		}

		// получаем языки перевода
		$this->getLanguagesByShop(
			URL::query(
				array(
					'id' => $shopBillStatusID,
				), FALSE
			),
			FALSE
		);

		// получаем данные
        View_View::findOne('DB_Shop_Bill_Status', $this->_sitePageData->shopID, "_shop/bill/status/one/edit",
			$this->_sitePageData, $this->_driverDB, array('id' => $shopBillStatusID), array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/bill/status/edit');
	}

	public function action_save()
	{
		$this->_sitePageData->url = '/cabinet/shopbillstatus/save';
		$result = Api_Shop_Bill_Status::save($this->_sitePageData, $this->_driverDB);
		$this->_redirectSaveResult($result);
	}
}