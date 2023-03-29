<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AutoPath_Write_Action extends Controller_AutoPath_Write_BasicCabinet {

    public function action_photo(){
        $this->_sitePageData->url = '/stock_write/action/photo';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/catalog/list/good-add',
            )
        );

        View_View::find('DB_Shop_Table_Catalog', $this->_sitePageData->shopID, '_shop/_table/catalog/list/good-add', '_shop/_table/catalog/one/good-add',
            $this->_sitePageData, $this->_driverDB, array('table_id' => Model_Shop_Good::TABLE_ID));

        $this->_putInMain('/main/action/photo');
    }

    public function action_stock(){
        $this->_sitePageData->url = '/stock_write/action/stock';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/catalog/list/good-stock',
            )
        );

        View_View::find('DB_Shop_Table_Catalog', $this->_sitePageData->shopID, '_shop/_table/catalog/list/good-stock', '_shop/_table/catalog/one/good-stock',
            $this->_sitePageData, $this->_driverDB, array('table_id' => Model_Shop_Good::TABLE_ID));

        $this->_putInMain('/main/action/stock');
    }

    public function action_revision(){
        $this->_sitePageData->url = '/stock_write/action/revision';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/catalog/list/good-revision',
            )
        );

        View_View::find('DB_Shop_Table_Catalog', $this->_sitePageData->shopID, '_shop/_table/catalog/list/good-revision', '_shop/_table/catalog/one/good-revision',
            $this->_sitePageData, $this->_driverDB, array('table_id' => Model_Shop_Good::TABLE_ID));

        $this->_putInMain('/main/action/revision');
    }
}
