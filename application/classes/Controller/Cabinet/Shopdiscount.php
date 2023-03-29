<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopDiscount extends Controller_Cabinet_File
{
	public function __construct(Request $request, Response $response)
	{
        $this->dbObject = 'DB_Shop_Discount';
		$this->controllerName = 'shopdiscount';
		$this->tableID = Model_Shop_Discount::TABLE_ID;
		$this->tableName = Model_Shop_Discount::TABLE_NAME;
		$this->objectName = 'discount';

		parent::__construct($request, $response);
		$this->_sitePageData->controllerName = $this->controllerName;
	}

	public function action_index() {
		$this->_sitePageData->url = '/cabinet/shopdiscount/index';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/discount/list/index',
			)
		);

		// получаем список
        View_View::find('DB_Shop_Discount', $this->_sitePageData->shopID, "_shop/discount/list/index", "_shop/discount/one/index",
			$this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

		$this->_putInMain('/main/_shop/discount/index');
	}

	public function action_sort(){
		$this->_sitePageData->url = '/cabinet/shopdiscount/sort';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/discount/list/index',
			)
		);

		// получаем список
		$this->_sitePageData->replaceDatas['view::_shop/discount/list/index'] = View_View::find('DB_Shop_Discount', $this->_sitePageData->shopID,
			"_shop/discount/list/sort", "_shop/discount/one/sort",
			$this->_sitePageData, $this->_driverDB,
			array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

		$this->_putInMain('/main/_shop/discount/index');
	}

	public function action_index_edit() {
		$this->_sitePageData->url = '/cabinet/shopdiscount/index_edit';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/discount/list/index',
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
			.'<option data-id="text" value="text">Описание</option>'
			.'<option data-id="is_public" value="is_public">Опубликован</option>';
		$this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

		// получаем список
		$this->_sitePageData->replaceDatas['view::_shop/discount/list/index'] = View_View::find('DB_Shop_Discount', $this->_sitePageData->shopID,
			"_shop/discount/list/index-edit", "_shop/discount/one/index-edit",
			$this->_sitePageData, $this->_driverDB,
			array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
			array('shop_table_catalog_id'));

		$this->_putInMain('/main/_shop/discount/index');
	}

	public function action_new() {
		$this->_sitePageData->url = '/cabinet/shopdiscount/new';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/discount/one/new',
			)
		);

		// получаем языки перевода
		$this->getLanguagesByShop('', FALSE);

        $this->_requestShopGoodRubric(new MyArray());
        $this->_requestShopGoodPromo(new MyArray());

		$dataID = new MyArray();
		$dataID->id = 0;
		$dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/discount/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_Discount(),
            '_shop/discount/one/new', $this->_sitePageData, $this->_driverDB);

		$this->_putInMain('/main/_shop/discount/new');
	}

	public function action_edit() {
		$this->_sitePageData->url = '/cabinet/shopdiscount/edit';

		// id записи
		$id = Request_RequestParams::getParamInt('id');
		if ($id === NULL) {
			throw new HTTP_Exception_404('Discount not is found!');
		}else {
			$model = new Model_Shop_Discount();
			if (! $this->dublicateObjectLanguage($model, $id)) {
				throw new HTTP_Exception_404('Discount not is found!');
			}
		}

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_shop/discount/one/edit',
			)
		);

		// получаем языки перевода
		$this->getLanguagesByShop(
			URL::query(
				array(
					'id' => $id,
				), FALSE
			),
			FALSE
		);

		$shopDiscountID = new MyArray();
		$shopDiscountID->id = $id;
		$shopDiscountID->isFindDB = TRUE;
		$shopDiscountID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopID);

		// данные акции
		$dataArray = $model->getDataArray();

        $promoIDs = new MyArray();
        $shopTableRubricIDs = new MyArray();
		switch ($model->getDiscountTypeID()) {
			case Model_DiscountType::DISCOUNT_TYPE_GOODS:
                $promoIDs = new MyArray(Arr::path($dataArray, 'id', array()));
                $shopDiscountID->additionDatas['shop_goods_count'] = Arr::path($dataArray, 'count', '');
                $shopDiscountID->additionDatas['shop_goods_amount'] = Arr::path($dataArray, 'amount', '');
				break;
			case Model_DiscountType::DISCOUNT_TYPE_CATALOGS:
                $shopTableRubricIDs = new MyArray(Arr::path($dataArray, 'id', array()));
                $shopDiscountID->additionDatas['shop_table_rubrics_count'] = Arr::path($dataArray, 'count', '');
                $shopDiscountID->additionDatas['shop_table_rubrics_amount'] = Arr::path($dataArray, 'amount', '');
				break;
			case Model_DiscountType::DISCOUNT_TYPE_BILL_AMOUNT:
				$shopDiscountID->additionDatas['amount'] = $dataArray['amount'];
				break;
		}

        $this->_requestShopGoodRubric($shopTableRubricIDs);
        $this->_requestShopGoodPromo($promoIDs);

        $this->_sitePageData->replaceDatas['view::_shop/discount/one/edit'] = Helpers_View::getViewObject($shopDiscountID, $model,
			'_shop/discount/one/edit', $this->_sitePageData, $this->_driverDB);

		$this->_putInMain('/main/_shop/discount/edit');
	}

	public function action_save()
	{
		$this->_sitePageData->url = '/cabinet/shopdiscount/save';
        $result = Api_Shop_Discount::save($this->_sitePageData, $this->_driverDB);
		$this->_redirectSaveResult($result);
	}

    /**
     * Делаем запрос на список рубрик
     * @param null $currentID
     */
    protected function _requestShopGoodRubric(MyArray $current){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/rubric/list/list',
                'view::_shop/_table/rubric/list/promo',
            )
        );

        View_Shop_Table_View::findRubrics(
            DB_Shop_Good::NAME, $this->_sitePageData->shopID,
            '_shop/_table/rubric/list/list', '_shop/_table/rubric/one/list',
            $this->_sitePageData, $this->_driverDB, array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)
        );

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/rubric/list/promo'] = $this->getViewObjects($current, $model,
            '_shop/_table/rubric/list/promo', '_shop/_table/rubric/one/promo');
    }

    /**
     * Делаем запрос на список рубрик
     * @param null $currentID
     */
    protected function _requestShopGoodPromo(MyArray $promo){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/list/promo',
                'view::_shop/good/list/promo-gift',
            )
        );

        $model = new Model_Shop_Good();
        $model->setDBDriver($this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/good/list/promo'] = $this->getViewObjects($promo, $model,
            "_shop/good/list/promo", "_shop/good/one/promo");
    }
}
