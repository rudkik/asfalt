<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AutoPath_Write_ShopTableRevision extends Controller_AutoPath_Write_File {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoptablerevision';
        $this->tableID = Model_Shop_Table_Revision::TABLE_ID;
        $this->tableName = Model_Shop_Table_Revision::TABLE_NAME;

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/stock_write/shoptablerevision/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/revision/list/index',
            )
        );

        $typeID = intval(Request_RequestParams::getParamInt('type'));
        $type = $this->_getType();

        // получаем список
        View_View::find('DB_Shop_Table_Revision', $this->_sitePageData->shopID,
            "_shop/_table/revision/list/index", "_shop/_table/revision/one/index", $this->_sitePageData, $this->_driverDB,
            array('type' => $typeID, 'table_id' => Request_RequestParams::getParamInt('table_id'), 'limit_page' => 25), array('shop_table_rubric_id'));

        $this->_putInMain('/main/_shop/_table/revision/index');
    }

    public function action_new() {
        $this->_sitePageData->url = '/stock_write/shoptablerevision/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/revision/one/new',
                'view::_shop/_table/stock/list/list',
            )
        );

        $type = $this->_getType();
        $this->_requestShopTableStock($type);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_Table_Revision();
        $datas = Helpers_View::getViewObject($dataID, $model,
            '_shop/_table/revision/one/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/revision/one/new'] = $datas;

        $this->_putInMain('/main/_shop/_table/revision/new');
    }

    public function action_stock() {
        $this->_sitePageData->url = '/stock_write/shoptablerevision/stock';

        $type = $this->_getType(Request_RequestParams::getParamInt('goods-type'));

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Revision not is found!');
        }else {
            $model = new Model_Shop_Table_Revision();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Revision not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/revision/one/stock',
            )
        );

        // получаем данные
        View_View::findOne('DB_Shop_Table_Revision', $this->_sitePageData->shopID, "_shop/_table/revision/one/stock",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/_shop/_table/revision/stock');
    }

    public function action_save() {
        $this->_sitePageData->url = '/stock_write/shoptablerevision/save';
        $result = Api_Shop_Table_Revision::save($this->_sitePageData, $this->_driverDB);
        $result['goods-type'] = Request_RequestParams::getParamInt('goods-type');
        $this->_redirectSaveResult($result);
    }

    public function action_add_stock()
    {
        $this->_sitePageData->url = '/stock_write/shoptablerevision/add_stock';
        $result = Api_Shop_Good::addListRevisionGoods($this->_sitePageData, $this->_driverDB);
        if (!is_array($result)){
            $result = array_merge($_GET, $_POST);
            $result['result']['error'] = FALSE;
        }
        $result['goods-type'] = Request_RequestParams::getParamInt('goods-type');
        $this->_redirectSaveResult($result);
    }

    /**
     * Делаем запрос на список единиц измерения
     * @param array $type
     * @return string
     */
    protected function _requestShopTableStock(array $type, $currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/stock/list/list',
            )
        );

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.stock.id', 0));
        if($typeID < 1){
            return '';
        }

        $data = View_View::find('DB_Shop_Table_Stock', $this->_sitePageData->shopID,
            "_shop/_table/stock/list/list", "_shop/_table/stock/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array($typeID), 'sort_by' => array('value' => array('root_id' => 'asc', 'order' => 'asc', 'name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/_table/stock/list/list'] = $data;
        }

        return $data;
    }
}
