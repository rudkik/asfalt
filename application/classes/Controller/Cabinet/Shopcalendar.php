<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopCalendar extends Controller_Cabinet_File
{

	public function __construct(Request $request, Response $response)
	{
        $this->dbObject = 'DB_Shop_Calendar';
		$this->controllerName = 'shopcalendar';
		$this->tableID = Model_Shop_Calendar::TABLE_ID;
		$this->tableName = Model_Shop_Calendar::TABLE_NAME;
		$this->objectName = 'calendar';

		parent::__construct($request, $response);
		$this->_sitePageData->controllerName = $this->controllerName;
	}

	public function action_index() {
		$this->_sitePageData->url = '/cabinet/shopcalendar/index';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/calendar/list/index',
			)
		);

		// тип объекта
		$type = $this->_getType();
		// список объектов
		$this->_requestTableObjects($type);

		// получаем список
        View_View::find('DB_Shop_Calendar', $this->_sitePageData->shopID, "_shop/calendar/list/index", "_shop/calendar/one/index",
			$this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('shop_table_rubric_id'));

		$this->_putInMain('/main/_shop/calendar/index');
	}

	public function action_sort(){
		$this->_sitePageData->url = '/cabinet/shopcalendar/sort';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/calendar/list/index',
			)
		);

		// тип объекта
		$type = $this->_getType();
		// список объектов
		$this->_requestTableObjects($type);

		// получаем список
		$this->_sitePageData->replaceDatas['view::_shop/calendar/list/index'] = View_View::find('DB_Shop_Calendar', $this->_sitePageData->shopID,
			"_shop/calendar/list/sort", "_shop/calendar/one/sort",
			$this->_sitePageData, $this->_driverDB,
			array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, 'type' => $type['id'], Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

		$this->_putInMain('/main/_shop/calendar/index');
	}

	public function action_index_edit() {
		$this->_sitePageData->url = '/cabinet/shopcalendar/index_edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/calendar/list/index',
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
			.'<option data-id="info" value="info">Описание</option>'
			.'<option data-id="article" value="article">Артикул</option>'
			.'<option data-id="options" value="options">Все заполненные атрибуты</option>';

		$arr = Arr::path($type['fields_options'], 'shop_calendar', array());
		foreach($arr as $key => $value){
			$s = 'options.'.htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);
			$fields = $fields .'<option data-id="'.$s.'" value="'.$s.'">'.$value['title'].'</option>';
		}
		$fields = $fields
			.'<option data-id="is_public" value="is_public">Опубликован</option>'
			.'<option data-id="shop_table_rubric_id" value="shop_table_rubric_id">Рубрика</option>'
			.'<option data-id="shop_table_brand_id" value="shop_table_brand_id">Бренд</option>'
			.'<option data-id="shop_table_unit_id" value="shop_table_unit_id">Единица измерения</option>'
			.'<option data-id="shop_table_select_id" value="shop_table_select_id">Вид выделения</option>';
		$this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

		// получаем список
		$this->_sitePageData->replaceDatas['view::_shop/calendar/list/index'] = View_View::find('DB_Shop_Calendar', $this->_sitePageData->shopID,
			"_shop/calendar/list/index-edit", "_shop/calendar/one/index-edit",
			$this->_sitePageData, $this->_driverDB,
			array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
			array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/calendar/index');
	}

	public function action_new()
	{
		$this->_sitePageData->url = '/cabinet/shopcalendar/new';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/calendar/one/new',
			)
		);

		// тип объекта
		$type = $this->_getType();

		$this->_requestTableObject($type);

		// получаем языки перевода
		$this->getLanguagesByShop(
			URL::query(
				array(
					'type' => $type['id'],
					'is_group' => Request_RequestParams::getParamBoolean('is_group')
				), FALSE
			),
			FALSE
		);

        $this->_requestCalendarEventTypes();

		$dataID = new MyArray();
		$dataID->id = 0;
		// дополнительные поля
		Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
		$dataID->isFindDB = TRUE;

		$this->_sitePageData->replaceDatas['view::_shop/calendar/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_Calendar(),
			'_shop/calendar/one/new', $this->_sitePageData, $this->_driverDB);

		$this->_putInMain('/main/_shop/calendar/new');
	}

	public function action_edit()
	{
		$this->_sitePageData->url = '/cabinet/shopcalendar/edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/calendar/one/edit',
			)
		);

		// id записи
		$shopCalendarID = Request_RequestParams::getParamInt('id');
		if ($shopCalendarID === NULL) {
			throw new HTTP_Exception_404('Calendars not is found!');
		}else {
			$modelCalendar = new Model_Shop_Calendar();
			if (! $this->dublicateObjectLanguage($modelCalendar, $shopCalendarID)) {
				throw new HTTP_Exception_404('Calendars not is found!');
			}
		}

		// тип объекта
		$type = $this->_getType();

		$this->_requestTableObject($type, $modelCalendar);

        $this->_requestCalendarEventTypes($modelCalendar->getCalendarEventTypeID());

		// получаем языки перевода
		$this->getLanguagesByShop(
			URL::query(
				array(
					'id' => $shopCalendarID,
					'type' => $type['id'],
					'is_group' => Request_RequestParams::getParamBoolean('is_group')
				), FALSE
			),
			FALSE
		);

		// получаем данные
        View_View::findOne('DB_Shop_Calendar', $this->_sitePageData->shopID, "_shop/calendar/one/edit",
			$this->_sitePageData, $this->_driverDB, array('id' => $shopCalendarID), array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/calendar/edit');
	}

	public function action_save()
	{
		$this->_sitePageData->url = '/cabinet/shopcalendar/save';
		$result = Api_Shop_Calendar::save($this->_sitePageData, $this->_driverDB);
		$this->_redirectSaveResult($result);
	}

    /**
     * @param null|int $currentID
     */
    protected function _requestCalendarEventTypes($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::calendareventtype/list/list',
            )
        );

        $data = View_View::find(
            'DB_CalendarEventType', $this->_sitePageData->shopMainID,
            "calendareventtype/list/list", "calendareventtype/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc')))
        );

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::calendareventtype/list/list'] = $data;
        }
    }
}
