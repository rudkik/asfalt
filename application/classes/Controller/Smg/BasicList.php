<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_BasicList extends Controller_Smg_BasicShop
{
    /**
     * Делаем запрос на список записей DB_ объекта
     * @param $dbObject
     * @param null $currentID
     * @param int $shopID
     * @param array $params
     * @param null $elements
     * @param string $file
     * @param string $field
     * @return string
     */
    protected function _requestListDB($dbObject, $currentID = NULL, $shopID = 0, array $params = array(), $elements = null,
                                      $file = 'list', $field = 'name')
    {
        if($shopID < 0){
            $shopID = $this->_sitePageData->shopID;
        }

        $view = DB_Basic::getViewPath($dbObject);
        if(file_exists(VIEWPATH . 'smg/market/' . $this->_sitePageData->dataLanguageID . '/' . $view . 'list/list.php')){
            $template = 'smg/market';
            $viewPath = $view;
        }else{
            $template = 'smg/_all';
            $viewPath = '_db/';
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::' . $view . 'list/'.$file,
            )
        );

        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'sort_by' => array(
                        $field => 'asc'
                    )
                )
            ),
            $params
        );

        $ids = Request_Request::find(
            $dbObject, $shopID, $this->_sitePageData, $this->_driverDB, $params, 1000, true, $elements
        );
        $ids->addAdditionDataChilds(['field' => $field]);

        $this->_sitePageData->newShopShablonPath($template);
        $data = Helpers_View::getViews(
            $viewPath . 'list/list', $viewPath . 'one/list',
            $this->_sitePageData, $this->_driverDB, $ids, false
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::' . $view . 'list/' . $file, $data);

        return $data;
    }

    /**
     * Получаем список записей для select
     */
    public function action_list() {
        $this->_sitePageData->url = '/'.$this->_sitePageData->actionURLName.'/' . $this->controllerName . '/list';
        $this->response->body($this->_requestListDB($this->dbObject));
    }
}