<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_CashRegister_Aura3_Goods
{
    /**
     * Наименование товара или услуги
     * Не более 42 символов при печати на ленте шириной 80мм, в противном случае наименование товара будет обрезаться
     * @var string
     */
    private $_name = '';

    /**
     * Section
     * @var int
     */
    private $_section = 1;

    /**
     * Количество товара или услуги
     * @var float
     */
    private $_quantity = 0;

    /**
     * Цена товара
     * @var float
     */
    private $_price = 0;

    /**
     * Скидка, заданная процентом от стоимости товара
     * @var float
     */
    private $_discountPercent = 0;

    /**
     * Скидка, заданная суммой
     * @var float
     */
    private $_discountSum = 0;

    /**
     * Наценка, заданная процентом от стоимости товара
     * @var float
     */
    private $_markupPercent = 0;

    /**
     * Наценка, заданная суммой
     * @var float
     */
    private $_markupSum = 0;

    /**
     * Путь к изображению товара
     * Печатает изображение товара
     * @var string
     */
    private $_imagePath = '';

    /**
     * Код штрих-кода в формате EAN13
     * Печатает штрих код, относящийся к товару
     * @var string
     */
    private $_barcode = '';

    /**
     * Номер акцизной марки
     * Для подакцизных товаров может указываться номер марки
     * @var string
     */
    private $_exciseStamp = '';

    /**
     * Получаем товар в виде XML
     * @param string $taxXML - налоги
     * @return string
     */
    public function getXMLStr($taxXML = ''){
        $result = '<Item>'
            . '<Section>'.$this->_section.'</Section>'
            . '<Name>'.htmlspecialchars($this->_name, ENT_XML1).'</Name>'
            . '<Quantity>'.Drivers_CashRegister_Aura3_Convert::floatToInt($this->_quantity).'</Quantity>'
            . '<Price>'.Drivers_CashRegister_Aura3_Convert::moneyToXML($this->_price).'</Price>';

        // Скидка, заданная процентом от стоимости товара
        if($this->_discountPercent > 0){
            $result .= '<DiscountPercent>'.Drivers_CashRegister_Aura3_Convert::floatToInt($this->_discountPercent).'</DiscountPercent>';
        }

        // Скидка, заданная суммой
        if($this->_discountSum > 0){
            $result .= '<DiscountSum>'.Drivers_CashRegister_Aura3_Convert::moneyToXML($this->_discountSum).'</DiscountSum>';
        }

        // Наценка, заданная процентом от стоимости товара
        if($this->_markupPercent > 0){
            $result .= '<MarkupPercent>'.Drivers_CashRegister_Aura3_Convert::floatToInt($this->_markupPercent).'</MarkupPercent>';
        }

        // Наценка, заданная суммой
        if($this->_markupSum > 0){
            $result .= '<MarkupSum>'.Drivers_CashRegister_Aura3_Convert::moneyToXML($this->_markupSum).'</MarkupSum>';
        }

        // Печатает штрих код, относящийся к товару
        if(!empty($this->_barcode)){
            $result .= '<BarcodeItem>'.Drivers_CashRegister_Aura3_Convert::barcodeToXML($this->_markupSum).'</BarcodeItem>';
        }

        // Номер акцизной марки
        if(!empty($this->_exciseStamp)){
            $result .= '<ExciseStamp>'.htmlspecialchars($this->_exciseStamp, ENT_XML1).'</ExciseStamp>';
        }

        if(!empty($taxXML)){
            $result .= '<Taxes>'.$taxXML.'</Taxes>';

        }

        $result .= '</Item>';

        return $result;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getSection(): int
    {
        return $this->_section;
    }

    /**
     * @param int $section
     * @return $this
     */
    public function setSection(int $section)
    {
        $this->_section = $section;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->_quantity;
    }

    /**
     * @param float $quantity
     * @return $this
     */
    public function setQuantity(float $quantity)
    {
        $this->_quantity = $quantity;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->_price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price)
    {
        $this->_price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscountPercent(): float
    {
        return $this->_discountPercent;
    }

    /**
     * @param float $discountPercent
     * @return $this
     */
    public function setDiscountPercent(float $discountPercent)
    {
        $this->_discountPercent = $discountPercent;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscountSum(): float
    {
        return $this->_discountSum;
    }

    /**
     * @param float $discountSum
     * @return $this
     */
    public function setDiscountSum(float $discountSum)
    {
        $this->_discountSum = $discountSum;
        return $this;
    }

    /**
     * @return float
     */
    public function getMarkupPercent(): float
    {
        return $this->_markupPercent;
    }

    /**
     * @param float $markupPercent
     * @return $this
     */
    public function setMarkupPercent(float $markupPercent)
    {
        $this->_markupPercent = $markupPercent;
        return $this;
    }

    /**
     * @return float
     */
    public function getMarkupSum(): float
    {
        return $this->_markupSum;
    }

    /**
     * @param float $markupSum
     * @return $this
     */
    public function setMarkupSum(float $markupSum)
    {
        $this->_markupSum = $markupSum;
        return $this;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->_imagePath;
    }

    /**
     * @param string $imagePath
     * @return $this
     */
    public function setImagePath(string $imagePath)
    {
        $this->_imagePath = $imagePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->_barcode;
    }

    /**
     * @param string $barcode
     * @return $this
     */
    public function setBarcode(string $barcode)
    {
        $this->_barcode = $barcode;
        return $this;
    }

    /**
     * @return string
     */
    public function getExciseStamp(): string
    {
        return $this->_exciseStamp;
    }

    /**
     * @param string $exciseStamp
     * @return $this
     */
    public function setExciseStamp(string $exciseStamp)
    {
        $this->_exciseStamp = $exciseStamp;
        return $this;
    }

    /**
     * Сохраняем в JSON строку
     * @return string
     */
    public function saveJson(): string
    {
        return Json::json_encode(
            array(
                'name' => $this->_name,
                'section' => $this->_section,
                'quantity' => $this->_quantity,
                'price' => $this->_price,
                'discountPercent' => $this->_discountPercent,
                'discountSum' => $this->_discountSum,
                'markupPercent' => $this->_markupPercent,
                'markupSum' => $this->_markupSum,
                'imagePath' => $this->_imagePath,
                'barcode' => $this->_barcode,
                'exciseStamp' => $this->_exciseStamp,
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

        $this->_name = $data['name'];
        $this->_section = $data['section'];
        $this->_quantity = $data['quantity'];
        $this->_price = $data['price'];
        $this->_discountPercent = $data['discountPercent'];
        $this->_discountSum = $data['discountSum'];
        $this->_markupPercent = $data['markupPercent'];
        $this->_markupSum = $data['markupSum'];
        $this->_imagePath = $data['imagePath'];
        $this->_barcode = $data['barcode'];
        $this->_exciseStamp = $data['exciseStamp'];
    }
}