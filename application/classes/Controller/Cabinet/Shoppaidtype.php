<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopPaidType extends Controller_Cabinet_BasicCabinet
{
	public function __construct(Request $request, Response $response)
	{
        $this->dbObject = 'DB_Shop_PaidType';
		$this->controllerName = 'shoppaidtype';
		$this->tableID = Model_Shop_PaidType::TABLE_ID;
		$this->tableName = Model_Shop_PaidType::TABLE_NAME;
		$this->objectName = 'paidtype';

		parent::__construct($request, $response);
		$this->_sitePageData->controllerName = $this->controllerName;
	}

	public function action_index()
	{
		$this->_sitePageData->url = '/cabinet/shoppaidtype/index';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/paidtype/list/index',
			)
		);

		// получаем список
        View_View::find('DB_Shop_PaidType', $this->_sitePageData->shopID, "_shop/paidtype/list/index", "_shop/paidtype/one/index",
			$this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

		$this->_putInMain('/main/_shop/paidtype/index');
	}

	public function action_sort()
	{
		$this->_sitePageData->url = '/cabinet/shoppaidtype/sort';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/paidtype/list/index',
			)
		);

		// получаем список
		$this->_sitePageData->replaceDatas['view::_shop/paidtype/list/index'] = View_View::find('DB_Shop_PaidType', $this->_sitePageData->shopID,
			"_shop/paidtype/list/sort", "_shop/paidtype/one/sort", $this->_sitePageData, $this->_driverDB,
			array_merge($_GET, $_POST, array('sort_by' => array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

		$this->_putInMain('/main/_shop/paidtype/index');
	}

	public function action_index_edit()
	{
		$this->_sitePageData->url = '/cabinet/shoppaidtype/index_edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/paidtype/list/index',
				'view::editfields/list',
			)
		);


		$fields =
			'<option data-id="old_id" value="old_id">ID</option>'
			. '<option data-id="name" value="name">Название</option>'
			. '<option data-id="price" value="price">Цена</option>'
			. '<option data-id="text" value="info">Описание</option>'
			. '<option data-id="options" value="options">Все заполненные атрибуты</option>';

		$fields = $fields
			. '<option data-id="is_public" value="is_public">Опубликован</option>';
		$this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

		// получаем список
		$this->_sitePageData->replaceDatas['view::_shop/paidtype/list/index'] = View_View::find('DB_Shop_PaidType', $this->_sitePageData->shopID,
			"_shop/paidtype/list/index-edit", "_shop/paidtype/one/index-edit",
			$this->_sitePageData, $this->_driverDB,
			array_merge(array('sort_by' => array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
			array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/paidtype/index');
	}

	public function action_new()
	{
		$this->_sitePageData->url = '/cabinet/shoppaidtype/new';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/paidtype/one/new',
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

		$this->_sitePageData->replaceDatas['view::_shop/paidtype/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_PaidType(),
			'_shop/paidtype/one/new', $this->_sitePageData, $this->_driverDB);

		$this->_putInMain('/main/_shop/paidtype/new');
	}

	public function action_edit()
	{
		$this->_sitePageData->url = '/cabinet/shoppaidtype/edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/paidtype/one/edit',
			)
		);

		// id записи
		$shopPaidTypeID = Request_RequestParams::getParamInt('id');
		if ($shopPaidTypeID === NULL) {
			throw new HTTP_Exception_404('Paid type not is found!');
		} else {
			$modelPaidType = new Model_Shop_PaidType();
			if (!$this->dublicateObjectLanguage($modelPaidType, $shopPaidTypeID)) {
				throw new HTTP_Exception_404('Paid type not is found!');
			}
		}

		// получаем языки перевода
		$this->getLanguagesByShop(
			URL::query(
				array(
					'id' => $shopPaidTypeID,
				), FALSE
			),
			FALSE
		);

		// получаем данные
        View_View::findOne('DB_Shop_PaidType', $this->_sitePageData->shopID, "_shop/paidtype/one/edit",
			$this->_sitePageData, $this->_driverDB, array('id' => $shopPaidTypeID), array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/paidtype/edit');
	}

	public function action_save()
	{
		$this->_sitePageData->url = '/cabinet/shoppaidtype/save';
		$result = Api_Shop_PaidType::save($this->_sitePageData, $this->_driverDB);
		$this->_redirectSaveResult($result);
	}
}