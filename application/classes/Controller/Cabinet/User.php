<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_User extends Controller_Cabinet_BasicCabinet {

	public function __construct(Request $request, Response $response)
	{
        $this->dbObject = 'DB_User';
		$this->controllerName = 'user';
		$this->tableID = Model_User::TABLE_ID;
		$this->tableName = Model_User::TABLE_NAME;
		$this->objectName = 'operation';

		parent::__construct($request, $response);
		$this->_sitePageData->controllerName = $this->controllerName;
	}

	public function action_index() {
		$this->_sitePageData->url = '/cabinet/user/index';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::user/list/index',
			)
		);

		// получаем список
        View_View::find('DB_User', $this->_sitePageData->shopID, "user/list/index", "user/one/index",
			$this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

		$this->_putInMain('/main/user/index');
	}

	public function action_new()
	{
		$this->_sitePageData->url = '/cabinet/user/new';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::user/one/new',
			)
		);

		$this->_requestShopLanguages();

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

		$this->_sitePageData->replaceDatas['view::user/one/new'] = Helpers_View::getViewObject($dataID, new Model_User(),
			'user/one/new', $this->_sitePageData, $this->_driverDB);

		$this->_putInMain('/main/user/new');
	}

	public function action_edit()
	{
		$this->_sitePageData->url = '/cabinet/user/edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::user/one/edit',
			)
		);

		// id записи
		$shopOperationID = Request_RequestParams::getParamInt('id');
        $modelOperation = new Model_User();
        if (! $this->dublicateObjectLanguage($modelOperation, $shopOperationID, -1, FALSE)) {
            throw new HTTP_Exception_404('Operations not is found!');
        }

		// получаем языки перевода
		$this->getLanguagesByShop(
			URL::query(
				array(), FALSE
			),
			FALSE
		);

		// получаем данные
        View_View::findOne('DB_User', $this->_sitePageData->shopID, "user/one/edit",
			$this->_sitePageData, $this->_driverDB, array('id' => $shopOperationID), array('shop_table_catalog_id'));

		$this->_putInMain('/main/user/edit');
	}

	public function action_save()
	{
		$this->_sitePageData->url = '/cabinet/user/save';
		$result = Api_User::save($this->_sitePageData, $this->_driverDB);
		$this->_redirectSaveResult($result);
	}

	/**
	 * Удаление
	 */
	public function action_del() {
		$this->_sitePageData->url = '/cabinet/user/del';

		Api_User::delete($this->_sitePageData, $this->_driverDB);
		$this->response->body(Json::json_encode(array('error' => FALSE)));
	}

}
