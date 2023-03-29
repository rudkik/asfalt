<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_BasicList extends Controller_BasicAdmin
{

    /**
     * Делаем запрос на список языков магазина
     * @param null|int $currentID
     */
    protected function _requestShopLanguages($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::language/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::findAll('DBLanguage', $this->_sitePageData->shopID,
            "language/list/list", "language/one/list",
            $this->_sitePageData, $this->_driverDB, $params);

        if ($currentID !== NULL) {
            if(is_array($currentID)) {
                foreach($currentID as $value) {
                    $s = 'data-id="' . $value . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else{
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
            $this->_sitePageData->replaceDatas['view::language/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список валют
     * @param null $currentID
     */
    protected function _requestCurrencies($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::currency/list/list',
            )
        );

        $data = View_View::find('DB_Currency', $this->_sitePageData->shopID,
            "currency/list/list", "currency/one/list", $this->_sitePageData, $this->_driverDB);

        if($currentID !== NULL){
            if(is_array($currentID)) {
                foreach($currentID as $value) {
                    $s = 'data-id="' . $value . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
                $this->_sitePageData->replaceDatas['view::currency/list/list'] = $data;
            }else{
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
                $this->_sitePageData->replaceDatas['view::currency/list/list'] = $data;
            }
        }
    }

    /**
     * Делаем запрос на список городов
     * @param $landID
     * @param null|integer|array $currentID
     */
    protected function _requestCity($landID, $currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::city/list/list',
            )
        );

        $data = View_View::find('DB_City', $this->_sitePageData->shopID, "city/list/list", "city/one/list",
            $this->_sitePageData, $this->_driverDB, array('sort_by' => array('value' => array('land_id' => 'asc', 'name' => 'asc')),
                'land_id' => $landID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            if(is_array($currentID)) {
                foreach($currentID as $value) {
                    $s = 'data-id="' . $value . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
                $this->_sitePageData->replaceDatas['view::city/list/list'] = $data;
            }else{
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
                $this->_sitePageData->replaceDatas['view::city/list/list'] = $data;
            }
        }
    }

    /**
     * Делаем запрос на список стран
     * @param null $currentID
     */
    protected function _requestLand($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::land/list/list',
            )
        );

        $data = View_View::findAll('DB_Land', $this->_sitePageData->shopID,
            "land/list/list", "land/one/list", $this->_sitePageData, $this->_driverDB);

        if($currentID !== NULL){
            if(is_array($currentID)) {
                foreach($currentID as $value) {
                    $s = 'data-id="' . $value . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
                $this->_sitePageData->replaceDatas['view::land/list/list'] = $data;
            }else{
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
                $this->_sitePageData->replaceDatas['view::land/list/list'] = $data;
            }
        }
    }

    /**
     * Делаем запрос на список языков магазина
     * @param null|int $currentID
     */
    protected function _requestShopCurrencies($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::currency/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::findAll('DB_Currency', $this->_sitePageData->shopID,
            "currency/list/list", "currency/one/list",
            $this->_sitePageData, $this->_driverDB, $params);

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::currency/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список стран
     * @param null|int $currentID
     */
    protected function _requestShopLands($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shop/land/list/list',
            )
        );

        if (!empty($this->_sitePageData->shop->getLandIDsArray())) {
            $params = Request_RequestParams::setParams(
                array(
                    'sort_by' => array('name' => 'asc'),
                    'id' => $this->_sitePageData->shop->getLandIDsArray(),
                )
            );
            $data = View_View::find('DB_Land', $this->_sitePageData->shopID,
                "land/list/list", "land/one/list",
                $this->_sitePageData, $this->_driverDB, $params);

            if ($currentID !== NULL) {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }else{
            $data = '';
        }
        $this->_sitePageData->replaceDatas['view::shop/land/list/list'] = $data;

        return $data;
    }

    /**
     * Делаем запрос на список городов страны
     * @param $landID
     * @param null $currentID
     */
    protected function _requestCities($landID, $currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::city/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
                'land_id' => $landID,
            )
        );
        $data = View_View::find('DB_City', $this->_sitePageData->shopID,
            "city/list/list", "city/one/list",
            $this->_sitePageData, $this->_driverDB, $params);

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::city/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список стран
     * @param null|int $currentID
     */
    protected function _requestLands($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::land/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Land', $this->_sitePageData->shopID,
            "land/list/list", "land/one/list",
            $this->_sitePageData, $this->_driverDB, $params);

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::land/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список моделей
     * @param int $shopMarkID
     * @param null|int $currentID
     */
    protected function _requestShopModels($shopMarkID, $currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/model/list/list',
            )
        );
        
        $params = Request_RequestParams::setParams(
            array(
               'shop_mark_id' => $shopMarkID,
                'sort_by' => array('name' => 'asc'),
            )    
        );
        $data = View_View::find('DB_Shop_Model', $this->_sitePageData->shopID,
            "_shop/model/list/list", "_shop/model/one/list",
            $this->_sitePageData, $this->_driverDB, $params);

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/model/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список машин балласта
     * @param null|int $currentID
     */
    protected function _requestShopMarks($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/mark/list/list',
            )
        );
        $data = View_View::find('DB_Shop_Mark', $this->_sitePageData->shopID,
            "_shop/mark/list/list", "_shop/mark/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/mark/list/list'] = $data;
        }
    }
}