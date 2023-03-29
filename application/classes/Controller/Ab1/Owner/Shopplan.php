<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_ShopPlan extends Controller_Ab1_Owner_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/owner/shopplan/statistics';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/plan/list/statistics',
            )
        );
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $days = new MyArray();

        $dateFrom = Helpers_DateTime::plusDays(date('Y-m-d').' 06:00:00', 1);

        $periods = array();
        for ($i = 1; $i < 4; $i++) {
            $periods[] = array(
                'date_from' => $dateFrom,
                'date_to' => $dateFrom,
            );
            $dateFrom = Helpers_DateTime::minusDays($dateFrom, 1);
        }
        $periods[] = array(
            'date_from' => Helpers_DateTime::plusDays(date('Y-m-d').' 06:00:00', 30),
            'date_to' => date('Y-m-d'),
        );

        foreach ($periods as $period){
            /** Планируемая реализация продукции текущего дня **/
            $paramsPlan = Request_RequestParams::setParams(
                array(
                    'plan_date_from_equally' => $period['date_from'],
                    'plan_date_to' => Helpers_DateTime::plusDays($period['date_to'], 1),
                )
            );
            $elementsPlan = array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'root_rubric_id' => array('name', 'id'),
                'shop_product_rubric_id' => array('name', 'id'),
            );
            $ids = Request_Request::find('DB_Ab1_Shop_Plan_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPlan, 10, TRUE, $elementsPlan
            );

            // список клиентов
            $shopClientIDs = array();
            $shopClientsQuantity = array(
                0 => array(
                    'quantity_plan' => 0,
                    'quantity_realization' => 0,
                )
            );
            foreach ($ids->childs as $child) {
                $client = $child->values['shop_client_id'];
                if (!key_exists($client, $shopClientIDs)) {
                    $shopClientIDs[$client] = ' '.$child->getElementValue('shop_client_id');
                    $shopClientsQuantity[$client] = array(
                        'quantity_plan' => 0,
                        'quantity_realization' => 0,
                    );
                }
            }
            $shopClientIDs[0] = 'Прочие';
            uasort($shopClientIDs, function ($x, $y) {
                return strcasecmp($x, $y);
            });

            $day = new MyArray();
            $day->setIsFind(true);
            $day->values['quantity_plan'] = 0;
            $day->values['quantity_realization'] = 0;
            $day->values['date'] = Helpers_DateTime::getDateFormatRus($period['date_from']);
            $day->additionDatas['shop_client_ids'] = $shopClientIDs;
            $day->additionDatas['quantity'] = $shopClientsQuantity;

            if($period['date_from'] == $period['date_to']){
                $day->values['title'] = Helpers_DateTime::getDateFormatRus($period['date_from']);
            }else{
                $day->values['title'] = Helpers_DateTime::getDateFormatRus($period['date_from']) . ' - '.Helpers_DateTime::getDateFormatRus($period['date_to']);
            }
            $days->childs[$dateFrom] = $day;
            foreach ($ids->childs as $child) {
                $root = $child->getElementValue('root_rubric_id', 'id');
                if (!key_exists($root, $day->childs)) {
                    $tmp = new MyArray();
                    $tmp->setIsFind(true);
                    $tmp->id = $root;
                    $tmp->values['quantity_plan'] = 0;
                    $tmp->values['quantity_realization'] = 0;
                    $tmp->values['name'] = $child->getElementValue('root_rubric_id');
                    $tmp->additionDatas = $shopClientsQuantity;
                    $day->childs[$root] = $tmp;
                }

                $rubric = $child->getElementValue('shop_product_rubric_id', 'id');
                if (!key_exists($rubric, $day->childs[$root]->childs)) {
                    $tmp = new MyArray();
                    $tmp->setIsFind(true);
                    $tmp->id = $rubric;
                    $tmp->values['quantity_plan'] = 0;
                    $tmp->values['quantity_realization'] = 0;
                    $tmp->values['name'] = $child->getElementValue('shop_product_rubric_id');
                    $tmp->additionDatas = $shopClientsQuantity;
                    $day->childs[$root]->childs[$rubric] = $tmp;
                }

                $product = $child->values['shop_product_id'];
                if (!key_exists($product, $day->childs[$root]->childs[$rubric]->childs)) {
                    $tmp = new MyArray();
                    $tmp->setIsFind(true);
                    $tmp->id = $product;
                    $tmp->values['quantity_plan'] = 0;
                    $tmp->values['quantity_realization'] = 0;
                    $tmp->values['name'] = $child->getElementValue('shop_product_id');
                    $tmp->additionDatas = $shopClientsQuantity;
                    $day->childs[$root]->childs[$rubric]->childs[$product] = $tmp;
                }

                $client = $child->values['shop_client_id'];
                if (!key_exists($client, $day->childs[$root]->childs[$rubric]->childs[$product]->childs)) {
                    $tmp = new MyArray();
                    $tmp->setIsFind(true);
                    $tmp->id = $client;
                    $tmp->values['quantity_plan'] = 0;
                    $tmp->values['quantity_realization'] = 0;
                    $tmp->additionDatas = $shopClientsQuantity;

                    if ($client > 0) {
                        $tmp->values['name'] = $child->getElementValue('shop_client_id');
                    } else {
                        $tmp->values['name'] = 'Прочие';
                    }
                    $day->childs[$root]->childs[$rubric]->childs[$product]->childs[$client] = $tmp;
                }

                $quantity = $child->values['quantity'];

                $day->childs[$root]->childs[$rubric]->childs[$product]->childs[$client]->values['quantity_plan'] += $quantity;
                $day->childs[$root]->childs[$rubric]->childs[$product]->values['quantity_plan'] += $quantity;
                $day->childs[$root]->childs[$rubric]->values['quantity_plan'] += $quantity;
                $day->childs[$root]->values['quantity_plan'] += $quantity;
                $day->values['quantity_plan'] += $quantity;

                $day->childs[$root]->childs[$rubric]->childs[$product]->childs[$client]->additionDatas[$client]['quantity_plan'] += $quantity;
                $day->childs[$root]->childs[$rubric]->childs[$product]->additionDatas[$client]['quantity_plan'] += $quantity;
                $day->childs[$root]->childs[$rubric]->additionDatas[$client]['quantity_plan'] += $quantity;
                $day->childs[$root]->additionDatas[$client]['quantity_plan'] += $quantity;
                $day->additionDatas['quantity'][$client]['quantity_plan'] += $quantity;
            }

            /** Итоговая реализация продукции текущего дня **/
            $paramsRealization = Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => Helpers_DateTime::plusDays($dateFrom, 1),
                    'is_exit' => TRUE,
                    'is_charity' => FALSE,
                )
            );
            $elementsRealization = array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'root_rubric_id' => array('name', 'id'),
                'shop_product_rubric_id' => array('name', 'id'),
            );
            $ids = Request_Request::find('DB_Ab1_Shop_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsRealization, 0, TRUE,
                $elementsRealization
            );

            foreach ($ids->childs as $child) {
                $root = $child->getElementValue('root_rubric_id', 'id');
                if (!key_exists($root, $day->childs)) {
                    $tmp = new MyArray();
                    $tmp->setIsFind(true);
                    $tmp->id = $root;
                    $tmp->values['quantity_plan'] = 0;
                    $tmp->values['quantity_realization'] = 0;
                    $tmp->values['name'] = $child->getElementValue('root_rubric_id');
                    $tmp->additionDatas = $shopClientsQuantity;
                    $day->childs[$root] = $tmp;
                }

                $rubric = $child->getElementValue('shop_product_rubric_id', 'id');
                if (!key_exists($rubric, $day->childs[$root]->childs)) {
                    $tmp = new MyArray();
                    $tmp->setIsFind(true);
                    $tmp->id = $rubric;
                    $tmp->values['quantity_plan'] = 0;
                    $tmp->values['quantity_realization'] = 0;
                    $tmp->values['name'] = $child->getElementValue('shop_product_rubric_id');
                    $tmp->additionDatas = $shopClientsQuantity;
                    $day->childs[$root]->childs[$rubric] = $tmp;
                }

                $product = $child->values['shop_product_id'];
                if (!key_exists($product, $day->childs[$root]->childs[$rubric]->childs)) {
                    $tmp = new MyArray();
                    $tmp->setIsFind(true);
                    $tmp->id = $product;
                    $tmp->values['quantity_plan'] = 0;
                    $tmp->values['quantity_realization'] = 0;
                    $tmp->values['name'] = $child->getElementValue('shop_product_id');
                    $tmp->additionDatas = $shopClientsQuantity;
                    $day->childs[$root]->childs[$rubric]->childs[$product] = $tmp;
                }

                $client = $child->values['shop_client_id'];
                if (!key_exists($client, $day->childs[$root]->childs[$rubric]->childs[$product]->childs)) {
                    $client = 0;
                }

                if (!key_exists($client, $day->childs[$root]->childs[$rubric]->childs[$product]->childs)) {
                    $tmp = new MyArray();
                    $tmp->setIsFind(true);
                    $tmp->id = $client;
                    $tmp->values['quantity_plan'] = 0;
                    $tmp->values['quantity_realization'] = 0;
                    $tmp->additionDatas = $shopClientsQuantity;

                    if ($client > 0) {
                        $tmp->values['name'] = $child->getElementValue('shop_client_id');
                    } else {
                        $tmp->values['name'] = 'Прочие';
                    }
                    $day->childs[$root]->childs[$rubric]->childs[$product]->childs[$client] = $tmp;
                }

                $quantity = $child->values['quantity'];

                $day->childs[$root]->childs[$rubric]->childs[$product]->childs[$client]->values['quantity_realization'] += $quantity;
                $day->childs[$root]->childs[$rubric]->childs[$product]->values['quantity_realization'] += $quantity;
                $day->childs[$root]->childs[$rubric]->values['quantity_realization'] += $quantity;
                $day->childs[$root]->values['quantity_realization'] += $quantity;
                $day->values['quantity_realization'] += $quantity;

                $day->childs[$root]->childs[$rubric]->childs[$product]->childs[$client]->additionDatas[$client]['quantity_realization'] += $quantity;
                $day->childs[$root]->childs[$rubric]->childs[$product]->additionDatas[$client]['quantity_realization'] += $quantity;
                $day->childs[$root]->childs[$rubric]->additionDatas[$client]['quantity_realization'] += $quantity;
                $day->childs[$root]->additionDatas[$client]['quantity_realization'] += $quantity;
                $day->additionDatas['quantity'][$client]['quantity_realization'] += $quantity;
            }
        }

        foreach ($days->childs as $day) {
            $day->childsSortBy(['name']);

            foreach ($day->childs as $root) {
                $root->childsSortBy(['name']);

                foreach ($root->childs as $rubric) {
                    $rubric->childsSortBy(['name']);
                }
            }
        }

        $this->_sitePageData->replaceDatas['view::_shop/plan/list/statistics'] = Helpers_View::getViewObjects(
            $days, new Model_Ab1_Shop_Plan(),
            '_shop/plan/list/statistics','_shop/plan/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/plan/statistics');
    }
}
