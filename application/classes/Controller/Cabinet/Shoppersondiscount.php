<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopPersonDiscount extends Controller_Cabinet_File
{
	public function __construct(Request $request, Response $response)
	{
        $this->dbObject = 'DB_Shop_PersonDiscount';
		$this->controllerName = 'shoppersondiscount';
		$this->tableID = Model_Shop_PersonDiscount::TABLE_ID;
		$this->tableName = Model_Shop_PersonDiscount::TABLE_NAME;
		$this->objectName = 'persondiscount';

		parent::__construct($request, $response);
		$this->_sitePageData->controllerName = $this->controllerName;
	}

	public function action_index() {
		$this->_sitePageData->url = '/cabinet/shoppersondiscount/index';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/person-discount/list/index',
			)
		);

		// тип объекта
		$type = $this->_getType();
		// список объектов
		$this->_requestTableObjects($type);

		// получаем список
        View_View::find('DB_Shop_PersonDiscount', $this->_sitePageData->shopID, "_shop/person-discount/list/index", "_shop/person-discount/one/index",
			$this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

		$this->_putInMain('/main/_shop/person-discount/index');
	}

	public function action_sort(){
		$this->_sitePageData->url = '/cabinet/shoppersondiscount/sort';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/person-discount/list/index',
			)
		);

		// тип объекта
		$type = $this->_getType();
		// список объектов
		$this->_requestTableObjects($type);

		// получаем список
		$this->_sitePageData->replaceDatas['view::_shop/person-discount/list/index'] = View_View::find('DB_Shop_PersonDiscount', $this->_sitePageData->shopID,
			"_shop/person-discount/list/sort", "_shop/person-discount/one/sort",
			$this->_sitePageData, $this->_driverDB,
			array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, 'type' => $type['id'], Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

		$this->_putInMain('/main/_shop/person-discount/index');
	}

	public function action_index_edit() {
		$this->_sitePageData->url = '/cabinet/shoppersondiscount/index_edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/person-discount/list/index',
				'view::editfields/list',
			)
		);

		// тип объекта
		$type = $this->_getType();
		// список объектов
		$this->_requestTableObjects($type);

		$fields =
			'<option data-id="old_id" value="old_id">ID</option>'
			.'<option data-id="name" value="name">Название</option>'
			.'<option data-id="price" value="price">Цена</option>'
			.'<option data-id="text" value="info">Описание</option>'
			.'<option data-id="article" value="article">Артикул</option>'
			.'<option data-id="options" value="options">Все заполненные атрибуты</option>';

		$arr = Arr::path($type['fields_options'], 'shop_person_discount', array());
		foreach($arr as $key => $value){
			$s = 'options.'.htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);
			$fields = $fields .'<option data-id="'.$s.'" value="'.$s.'">'.$value['title'].'</option>';
		}
		$fields = $fields
			.'<option data-id="price_old" value="price_old">Старая цена</option>'
			.'<option data-id="is_public" value="is_public">Опубликован</option>'
			.'<option data-id="shop_table_rubric_id" value="shop_table_rubric_id">Рубрика</option>'
			.'<option data-id="shop_table_brand_id" value="shop_table_brand_id">Бренд</option>'
			.'<option data-id="shop_table_unit_id" value="shop_table_unit_id">Единица измерения</option>'
			.'<option data-id="shop_table_select_id" value="shop_table_select_id">Вид выделения</option>';
		$this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

		// получаем список
		$this->_sitePageData->replaceDatas['view::_shop/person-discount/list/index'] = View_View::find('DB_Shop_PersonDiscount', $this->_sitePageData->shopID,
			"_shop/person-discount/list/index-edit", "_shop/person-discount/one/index-edit",
			$this->_sitePageData, $this->_driverDB,
			array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
			array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/person-discount/index');
	}

	public function action_new()
	{
		$this->_sitePageData->url = '/cabinet/shoppersondiscount/new';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/person-discount/one/new',
			)
		);

		// тип объекта
		$type = $this->_getType();
        $this->_requestShopTableRubric(-1, null, ['table_id' => Model_Shop_Good::TABLE_ID]);

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

		$this->_sitePageData->replaceDatas['view::_shop/person-discount/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_PersonDiscount(),
			'_shop/person-discount/one/new', $this->_sitePageData, $this->_driverDB);

		$this->_putInMain('/main/_shop/person-discount/new');
	}

	public function action_edit()
	{
		$this->_sitePageData->url = '/cabinet/shoppersondiscount/edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/person-discount/one/edit',
			)
		);

		// id записи
		$id = Request_RequestParams::getParamInt('id');
		if ($id === NULL) {
			throw new HTTP_Exception_404('Person discount not is found!');
		}else {
			$model = new Model_Shop_PersonDiscount();
			if (! $this->dublicateObjectLanguage($model, $id)) {
				throw new HTTP_Exception_404('Person discount not is found!');
			}
		}

		// тип объекта
		$type = $this->_getType();
		$this->_requestShopTableRubric(-1, $model->getShopTableRubricIDsArray(), ['table_id' => Model_Shop_Good::TABLE_ID]);

		// получаем языки перевода
		$this->getLanguagesByShop(
			URL::query(
				array(
					'id' => $id,
					'type' => $type['id'],
				), FALSE
			),
			FALSE
		);

		// получаем данные
        View_View::findOne('DB_Shop_PersonDiscount', $this->_sitePageData->shopID, "_shop/person-discount/one/edit",
			$this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/person-discount/edit');
	}

	public function action_save()
	{
		$this->_sitePageData->url = '/cabinet/shoppersondiscount/save';
		$result = Api_Shop_PersonDiscount::save($this->_sitePageData, $this->_driverDB);
		$this->_redirectSaveResult($result);
	}

	/**
	 * Удаление
	 */
	public function action_del() {
		$this->_sitePageData->url = '/cabinet/shoppersondiscount/del';

		Api_Shop_PersonDiscount::delete($this->_sitePageData, $this->_driverDB);
		$this->response->body(Json::json_encode(array('error' => FALSE)));
	}
}
