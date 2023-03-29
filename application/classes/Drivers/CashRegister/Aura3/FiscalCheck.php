<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_CashRegister_Aura3_FiscalCheck
{
    /**
     * Список товаров или услуг текстовыми строками
     * Информация о товарах или услугах, представленная текстовыми строками.
     * @var array
     */
    private $_document = array();

    /**
     * Строки в клише
     * Печатаются дополнительные строки в клише сразу после строк из настроек ККМ и строк с сервера ОФД.
     * @var array
     */
    private $_clisheStrings = array();

    /**
     * Строки в подвале
     * Печатает дополнительные строки в подвале чека сразу после строк из настроек ККМ и строк с сервера ОФД
     * @var array
     */
    private $_vaultStrings = array();

    /**
     * Список товаров
     * @var Drivers_CashRegister_Aura3_GoodsList
     */
    private $_goodsList = NULL;

    function __construct(){
        $this->_goodsList = new Drivers_CashRegister_Aura3_GoodsList();
    }

    /**
     * @return array
     */
    public function getDocument(): array
    {
        return $this->_document;
    }

    /**
     * @param array $document
     */
    public function setDocument(array $document)
    {
        $this->_document = $document;
    }

    /**
     * @return array
     */
    public function getClisheStrings(): array
    {
        return $this->_clisheStrings;
    }

    /**
     * @param array $clisheStrings
     */
    public function setClisheStrings(array $clisheStrings)
    {
        $this->_clisheStrings = $clisheStrings;
    }

    /**
     * @return array
     */
    public function getVaultStrings(): array
    {
        return $this->_vaultStrings;
    }

    /**
     * @param array $vaultStrings
     */
    public function setVaultStrings(array $vaultStrings)
    {
        $this->_vaultStrings = $vaultStrings;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function addVaultStrings(string $value)
    {
        $this->_vaultStrings[] = $value;
        return $this;
    }

    /**
     * @return Drivers_CashRegister_Aura3_GoodsList
     */
    public function getGoodsList(): Drivers_CashRegister_Aura3_GoodsList
    {
        return $this->_goodsList;
    }

    /**
     * Сохраняем в JSON строку
     * @return string
     */
    public function saveJson(): string
    {
        return Json::json_encode(
            array(
                'document' => $this->_document,
                'clisheStrings' => $this->_clisheStrings,
                'vaultStrings' => $this->_vaultStrings,
                'goodsList' => $this->_goodsList->saveJson(),
            )
        );
    }

    /**
     * Загружаем JSON строку
     * @return string
     */
    public function loadJson(string $data)
    {
        $data = json_decode($data, TRUE);

        $this->_document = $data['document'];
        $this->_clisheStrings = $data['clisheStrings'];
        $this->_vaultStrings = $data['vaultStrings'];
        $this->_goodsList->loadJson($data['goodsList']);
    }
}