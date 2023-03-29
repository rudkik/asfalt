<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopAction extends Controller_Cabinet_File
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Action';
        $this->controllerName = 'shopaction';
        $this->tableID = Model_Shop_Action::TABLE_ID;
        $this->tableName = Model_Shop_Action::TABLE_NAME;
        $this->objectName = 'action';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shopaction/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/action/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Shop_Action', $this->_sitePageData->shopID, "_shop/action/list/index", "_shop/action/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

        $this->_putInMain('/main/_shop/action/index');
    }

    public function action_sort(){
        $this->_sitePageData->url = '/cabinet/shopaction/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/action/list/index',
            )
        );

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/action/list/index'] = View_View::find('DB_Shop_Action', $this->_sitePageData->shopID,
            "_shop/action/list/sort", "_shop/action/one/sort",
            $this->_sitePageData, $this->_driverDB,
            array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

        $this->_putInMain('/main/_shop/action/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shopaction/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/action/list/index',
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
        $this->_sitePageData->replaceDatas['view::_shop/action/list/index'] = View_View::find('DB_Shop_Action', $this->_sitePageData->shopID,
            "_shop/action/list/index-edit", "_shop/action/one/index-edit",
            $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/action/index');
    }

    public function action_new() {
        $this->_sitePageData->url = '/cabinet/shopaction/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/action/one/new',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop('', FALSE);

        $this->_requestShopGoodRubric(new MyArray());
        $this->_requestShopGoodPromo(new MyArray(), new MyArray());

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_Action();
        $this->_sitePageData->replaceDatas['view::_shop/action/one/new'] = Helpers_View::getViewObject($dataID, $model,
            '_shop/action/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/action/new');
    }

    public function action_edit() {
        $this->_sitePageData->url = '/cabinet/shopaction/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Action not is found!');
        }else {
            $model = new Model_Shop_Action();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Action not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/action/one/edit',
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

        $shopActionID = new MyArray();
        $shopActionID->id = $id;
        $shopActionID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        $shopActionID->isFindDB = TRUE;

        // данные акции
        $dataArray = $model->getDataArray();
        $promoIDs = new MyArray();
        $shopTableRubricIDs = new MyArray();
        switch ($model->getActionTypeID()) {
            case Model_ActionType::ACTION_TYPE_GOODS:
                $promoIDs = new MyArray(Arr::path($dataArray, 'id', array()));
                $shopActionID->additionDatas['shop_goods_count'] = Arr::path($dataArray, 'count', '');
                $shopActionID->additionDatas['shop_goods_amount'] = Arr::path($dataArray, 'amount', '');
                break;
            case Model_ActionType::ACTION_TYPE_CATALOGS:
                $shopTableRubricIDs = new MyArray(Arr::path($dataArray, 'id', array()));
                $shopActionID->additionDatas['shop_table_rubrics_count'] = Arr::path($dataArray, 'count', '');
                $shopActionID->additionDatas['shop_table_rubrics_amount'] = Arr::path($dataArray, 'amount', '');
                break;
            case Model_ActionType::ACTION_TYPE_BILL_AMOUNT:
                $shopActionID->additionDatas['amount'] = Arr::path($dataArray, 'amount', '');
                break;
        }

        // подарочные товары
        $dataArray = $model->getGiftIDsArray();
        $promoGiftIDs = new MyArray();
        switch ($model->getGiftTypeID()) {
            case Model_GiftType::GIFT_TYPE_BILL_GIFT:
                $promoGiftIDs = new MyArray(Arr::path($dataArray, 'id', array()));
                $shopActionID->additionDatas['gift_shop_goods_count'] = Arr::path($dataArray, 'count', '');
                break;
            case Model_GiftType::GIFT_TYPE_BILL_COMMENT:
                $shopActionID->additionDatas['gift_bill_comment'] = Arr::path($dataArray, 'comment', '');
                break;
        }

        $this->_requestShopGoodRubric($shopTableRubricIDs);
        $this->_requestShopGoodPromo($promoIDs, $promoGiftIDs);

        $this->_sitePageData->replaceDatas['view::_shop/action/one/edit'] = Helpers_View::getViewObject($shopActionID, $model,
            '_shop/action/one/edit', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/action/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopaction/save';
        $result = Api_Shop_Action::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    /**
     * Делаем запрос на список рубрик
     * @param MyArray $current
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
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams()
        );

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/rubric/list/promo'] = $this->getViewObjects(
            $current, $model, '_shop/_table/rubric/list/promo', '_shop/_table/rubric/one/promo'
        );
    }

    /**
     * Делаем запрос на список рубрик
     * @param MyArray $promo
     * @param MyArray $promoGift
     */
    protected function _requestShopGoodPromo(MyArray $promo, MyArray $promoGift){
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
        $this->_sitePageData->replaceDatas['view::_shop/good/list/promo-gift'] = $this->getViewObjects($promoGift, $model,
            "_shop/good/list/promo-gift", "_shop/good/one/promo-gift");
    }
}
