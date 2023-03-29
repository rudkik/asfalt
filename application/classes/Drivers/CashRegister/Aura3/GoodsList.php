<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_CashRegister_Aura3_GoodsList extends Helpers_Array_Collection
{
    /**
     * Получаем товар в виде XML
     * @param string $taxXML - налоги
     * @return string
     */
    public function getXMLStr($taxXML = ''){
        $result = '';

        /** @var Drivers_CashRegister_Aura3_Goods $child */
        foreach ($this->getValues() as $child){
            $result .= $child->getXMLStr($taxXML);
        }

        return $result;
    }

    /**
     * Добавить товар
     * @param $name
     * @param $price
     * @param $quantity
     * @return Drivers_CashRegister_Aura3_Goods
     */
    public function addGoods($name, $price, $quantity){
        $goods = new Drivers_CashRegister_Aura3_Goods();
        $goods->setName($name);
        $goods->setPrice($price);
        $goods->setQuantity($quantity);

        $this->add($goods);

        return $goods;
    }

    /**
     * Сохраняем в JSON строку
     * @return string
     */
    public function saveJson(): string
    {
        $result = array();
        /** @var Drivers_CashRegister_Aura3_Goods $child */
        foreach ($this->getValues() as $child){
            $result[] = $child->saveJson();
        }

        return Json::json_encode($result);
    }

    /**
     * Загружаем JSON строку
     * @return string
     */
    public function loadJson(string $data)
    {
        $data = json_decode($data, TRUE);

        $this->clear();
        foreach ($data as $child){
            $goods = new Drivers_CashRegister_Aura3_Goods();
            $this->add($goods);

            $goods->loadJson($child);
        }
    }
}