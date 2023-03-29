<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Paradise_Region extends Controller_Paradise_BasicShop {

    public function action_index() {
        $this->_sitePageData->url = '/';

        $regions = Request_Request::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB, array('type' => 3624, 'root_id' => 0, 'sort_by' => array('value' => array('order' => 'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            6, TRUE);

        $this->_calcWeightRegion($regions, 2);

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($this->_driverDB);
        $result = Helpers_View::getViewObjects($regions, $model, 'region/list/index', 'region/one/index',
            $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::region/list/index', $result);

        $this->_putInMain('/main/index');
    }

    public function action_region() {
        $this->_sitePageData->url = '/region';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::region/list/index',
                'view::region/one/show',
                'view::people/list/index',
            )
        );

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($this->_driverDB);
        if (!$this->getDBObject($model, $id)){
            throw new HTTP_Exception_404('Region not found.');
        }

        View_View::findOne('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, 'region/one/show',
            $this->_sitePageData, $this->_driverDB, array('id' => $id, 'is_error_404' => TRUE,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $peoplesCount = Request_Request::find('DB_Shop_Operation',$this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB, array('type' => 3624, 'shop_table_rubric_id' => $id, 'count_id' => TRUE,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE))->childs[0]->values['count'];

        $regions = Request_Request::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB, array('type' => 3624, 'root_id' => $id, 'sort_by' => array('value' => array('order' => 'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            6, TRUE);

        $this->_calcWeightRegion($regions, intval(Arr::path($model->getOptionsArray(), 'rows', 1)), $peoplesCount);

        if ($peoplesCount > 0){
            if ($peoplesCount < 4){
                $peoples = Request_Request::find('DB_Shop_Operation',$this->_sitePageData->shopID, $this->_sitePageData,
                    $this->_driverDB, array('type' => 3624, 'shop_table_rubric_id' => $id,
                        Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 3, TRUE);

                $tmp = $regions->findChild('peoples');
                $tmp->isFindDB = TRUE;
                $this->_calcWeightPeoples($peoples, 1, $tmp->additionDatas['weight_width'], $tmp->additionDatas['weight_height']);

                $model = new Model_Shop_Operation();
                $model->setDBDriver($this->_driverDB);
                $result = Helpers_View::getViewObjects($peoples, $model, 'people/list/index', 'people/one/index',
                    $this->_sitePageData, $this->_driverDB);
                $this->_sitePageData->addReplaceAndGlobalDatas('view::people/list/index', $result);
            }
        }

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($this->_driverDB);
        $result = Helpers_View::getViewObjects($regions, $model, 'region/list/index', 'region/one/index',
            $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::region/list/index', $result);

        $this->_putInMain('/main/region');
    }

    private function _calcWeightPeoples(MyArray $peoples, $lineCount, $weightWidth = 100, $weightHeight = 100) {
        if ($lineCount < 1){
            $lineCount = 1;
        }

        $peoplesCount = count($peoples->childs);
        if($peoplesCount == 0){
            return FALSE;
        }

        $lineChild = ceil($peoplesCount / $lineCount);

        // разбираем места по линиям
        $i = 1;
        $row = 0;
        $weight = $peoplesCount;
        $lines = array(
            $row => array(
                'people' => array(),
                'weight' => 0
            )
        );
        foreach ($peoples->childs as $people){
            if ($i > $lineChild){
                $i = 1;
                $row++;
                $lines[$row] = array(
                    'people' => array(),
                    'weight' => 0
                );
            }

            $lines[$row]['people'][] = $people;

            $count = $people->values['order'];
            if($count < 1){
                $count = 1;
            }

            $lines[$row]['weight'] += $count;
            $weight += $count;

            $i++;
        }
        // определяем развер по ширине и по высоте
        foreach ($lines as $line){
            $weightLine = $line['weight'];
            $weightHeight = $weightLine * $weightHeight / $weight;
            foreach ($line['people'] as $people){
                $people->additionDatas['weight_height'] = $weightHeight;

                $count = $people->values['order'];
                if($count < 1){
                    $count = 1;
                }
                $people->additionDatas['weight_width'] = $count * $weightWidth / $weightLine;
            }
        }

        return TRUE;
    }

    private function _calcWeightRegion(MyArray $regions, $lineCount, $peoplesCount = 0, $weightWidth = 100, $weightHeight = 100) {
        if ($lineCount < 1){
            $lineCount = 1;
        }

        // если в регионе есть жители, то фиктивно для них добавляем одну зону
        if ($peoplesCount > 0){
            $regions->addChild('peoples')->values['element_count'] = $peoplesCount;
        }

        $regionsCount = count($regions->childs);
        if($regionsCount == 0){
            return FALSE;
        }

        $lineChild = ceil($regionsCount / $lineCount);

        // разбираем места по линиям
        $i = 1;
        $row = 0;
        $weight = $peoplesCount;
        $lines = array(
            $row => array(
                'region' => array(),
                'weight' => 0
            )
        );
        foreach ($regions->childs as $region){
            if ($i > $lineChild){
                $i = 1;
                $row++;
                $lines[$row] = array(
                    'region' => array(),
                    'weight' => 0
                );
            }

            $lines[$row]['region'][] = $region;

            $count = $region->values['element_count'];
            if($count < 1){
                $count = 1;
            }

            $lines[$row]['weight'] += $count;
            $weight += $count;

            $i++;
        }
        // определяем развер по ширине и по высоте
        foreach ($lines as $line){
            $weightLine = $line['weight'];
            $weightHeight = $weightLine * $weightHeight / $weight;
            foreach ($line['region'] as $region){
                $region->additionDatas['weight_height'] = $weightHeight;

                $count = $region->values['element_count'];
                if($count < 1){
                    $count = 1;
                }
                $region->additionDatas['weight_width'] = $count * $weightWidth / $weightLine;
            }
        }

        return TRUE;
    }
}
