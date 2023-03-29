<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopDeliveryType extends Controller_Cabinet_BasicCabinet {

	public function __construct(Request $request, Response $response)
	{
        $this->dbObject = 'DB_Shop_DeliveryType';
		$this->controllerName = 'shopdeliverytype';
		$this->tableID = Model_Shop_DeliveryType::TABLE_ID;
		$this->tableName = Model_Shop_DeliveryType::TABLE_NAME;
		$this->objectName = 'deliverytype';

		parent::__construct($request, $response);
		$this->_sitePageData->controllerName = $this->controllerName;
	}

	public function action_index()
	{
		$this->_sitePageData->url = '/cabinet/shopdeliverytype/index';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/deliverytype/list/index',
			)
		);

		// получаем список
        View_View::find('DB_Shop_DeliveryType', $this->_sitePageData->shopID, "_shop/deliverytype/list/index", "_shop/deliverytype/one/index",
			$this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

		$this->_putInMain('/main/_shop/deliverytype/index');
	}

	public function action_sort()
	{
		$this->_sitePageData->url = '/cabinet/shopdeliverytype/sort';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/deliverytype/list/index',
			)
		);

		// получаем список
		$this->_sitePageData->replaceDatas['view::_shop/deliverytype/list/index'] = View_View::find('DB_Shop_DeliveryType', $this->_sitePageData->shopID,
			"_shop/deliverytype/list/sort", "_shop/deliverytype/one/sort", $this->_sitePageData, $this->_driverDB,
			array_merge($_GET, $_POST, array('sort_by' => array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, 'type' => $type['id'], Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

		$this->_putInMain('/main/_shop/deliverytype/index');
	}

	public function action_index_edit()
	{
		$this->_sitePageData->url = '/cabinet/shopdeliverytype/index_edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/deliverytype/list/index',
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
		$this->_sitePageData->replaceDatas['view::_shop/deliverytype/list/index'] = View_View::find('DB_Shop_DeliveryType', $this->_sitePageData->shopID,
			"_shop/deliverytype/list/index-edit", "_shop/deliverytype/one/index-edit",
			$this->_sitePageData, $this->_driverDB,
			array_merge(array('sort_by' => array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
			array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/deliverytype/index');
	}

	public function action_new()
	{
		$this->_sitePageData->url = '/cabinet/shopdeliverytype/new';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/deliverytype/one/new',
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

		$this->_sitePageData->replaceDatas['view::_shop/deliverytype/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_DeliveryType(),
			'_shop/deliverytype/one/new', $this->_sitePageData, $this->_driverDB);

		$this->_putInMain('/main/_shop/deliverytype/new');
	}

	public function action_edit()
	{
		$this->_sitePageData->url = '/cabinet/shopdeliverytype/edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/deliverytype/one/edit',
			)
		);

		// id записи
		$shopDeliveryTypeID = Request_RequestParams::getParamInt('id');
		if ($shopDeliveryTypeID === NULL) {
			throw new HTTP_Exception_404('Delivery type not is found!');
		} else {
			$modelDeliveryType = new Model_Shop_DeliveryType();
			if (!$this->dublicateObjectLanguage($modelDeliveryType, $shopDeliveryTypeID)) {
				throw new HTTP_Exception_404('Delivery type not is found!');
			}
		}

		// получаем языки перевода
		$this->getLanguagesByShop(
			URL::query(
				array(
					'id' => $shopDeliveryTypeID,
				), FALSE
			),
			FALSE
		);

		// получаем данные
        View_View::findOne('DB_Shop_DeliveryType', $this->_sitePageData->shopID, "_shop/deliverytype/one/edit",
			$this->_sitePageData, $this->_driverDB, array('id' => $shopDeliveryTypeID), array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/deliverytype/edit');
	}

	public function action_save()
	{
		$this->_sitePageData->url = '/cabinet/shopdeliverytype/save';
		$result = Api_Shop_DeliveryType::save($this->_sitePageData, $this->_driverDB);
		$this->_redirectSaveResult($result);
	}
}
