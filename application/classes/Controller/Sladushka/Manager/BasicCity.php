<?php
class Controller_Sladushka_Manager_BasicCity extends Controller_Sladushka_Manager_File
{

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

        $data = View_View::find('DB_Land', $this->_sitePageData->shopID,
            "land/list/list", "land/one/list", $this->_sitePageData, $this->_driverDB);

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::land/list/list'] = $data;
        }
    }

}