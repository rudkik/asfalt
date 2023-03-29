<?php defined('SYSPATH') or die('No direct script access.');

class PDF_Tax_Return_910_001 extends PDF_Tax_Return{

    function __construct($author = 'Bigbuh.kz')
    {
        parent::__construct($author);
    }

    function setBackgroundPages($languageID) {
        $path = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'tax' . DIRECTORY_SEPARATOR . 'client' . DIRECTORY_SEPARATOR
            . $languageID . DIRECTORY_SEPARATOR . '_shop' . DIRECTORY_SEPARATOR . 'tax' . DIRECTORY_SEPARATOR . 'return'
            . DIRECTORY_SEPARATOR . '910' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . '001' . DIRECTORY_SEPARATOR;

        $this->setBackgroundImage($path.'page_1.jpg');

        $this->AddPage(PDF_PAGE_ORIENTATION, PDF_PAGE_FORMAT);
        $this->setBackgroundImage($path.'page_2.jpg');

        $this->AddPage(PDF_PAGE_ORIENTATION, PDF_PAGE_FORMAT);
        $this->setBackgroundImage($path.'page_3.jpg');

        $this->AddPage(PDF_PAGE_ORIENTATION, PDF_PAGE_FORMAT);
        $this->setBackgroundImage($path.'page_4.jpg');
    }

    /**
     * Устанавливаем БИН
     * @param $bin
     */
    function setBIN($bin) {
        $this->setPage(1);
        $this->setTextBreakSymbol(34,42.2, $bin);

        $this->setPage(2);
        $this->setTextBreakSymbol(32.3,9.3, $bin);

        $this->setPage(3);
        $this->setTextBreakSymbol(32.3,9.3, $bin);

        $this->setPage(4);
        $this->setTextBreakSymbol(32.3,9.3, $bin);
    }

    /**
     * Устанавливаем название компании
     * @param $name
     */
    function setName($name) {
        $this->setPage(1);
        $this->setTextBreakSymbolAndLine(
            array(
                0 => array('x' => 58, 'y' => 49.2, 'size' => 27),
                1 => array('x' => 18.2, 'y' => 56, 'size' => 35),
                2 => array('x' => 18.2, 'y' => 62.7, 'size' => 35),
            ),
            $name
        );
    }

    /**
     * Устанавливаем БИН Акимата
     * @param $bin
     */
    function setBINAkimat($bin) {
        $this->setPage(4);
        $this->setTextBreakSymbol(142,37.5, $bin);
    }

    /**
     * Устанавливаем БИН Акимата
     * @param $bin
     */
    function setOperationName($name) {
        $this->setPage(4);
        $this->Text(8,69.5, $name);
    }


    /**
     * Устанавливаем Код органа государственных доходов по месту нахождения
     * @param $value
     */
    function setKOGDN($value) {
        $this->setPage(4);
        $this->setTextBreakSymbol(49.2,96.6, $value);
    }

    /**
     * Устанавливаем Код органа государственных доходов по месту жительства
     * @param $value
     */
    function setKOGDZH($value) {
        $this->setPage(4);
        $this->setTextBreakSymbol(116,96.6, $value);
    }

    /**
     * Устанавливаем значение категорию налогоплательщика
     * @param $value
     */
    function setCategoryTaxpayer($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(96.4, 81.2, 'X');
        $this->setNumberBreakSymbol(96.4, 93, 'X');
        $this->setNumberBreakSymbol(188.4, 81.2, 'X');
        $this->setNumberBreakSymbol(188.4, 93, 'X');
    }

    /**
     * Устанавливаем значение вид деклараций
     * @param $value
     */
    function setView($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(40.1,108, 'X');
        $this->setNumberBreakSymbol(70.2,108, 'X');
        $this->setNumberBreakSymbol(109.1,108, 'X');
        $this->setNumberBreakSymbol(148.2,108, 'X');
        $this->setNumberBreakSymbol(187.2,108, 'X');
    }

    /**
     * Устанавливаем значение резиденства
     * @param $value
     */
    function setIsResident($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(150.3,131.1, 'X');
        $this->setNumberBreakSymbol(198,131.3, 'X');
    }



    /**
     * Устанавливаем полугодие
     * @param $halfYear
     */
    function setHalfYear($halfYear) {
        $this->setPage(1);
        $this->setTextBreakSymbol(146.1,70, $halfYear);

        $this->setPage(2);
        $this->setTextBreakSymbol(141.5,16.6, $halfYear);

        $this->setPage(3);
        $this->setTextBreakSymbol(141.5,16.6, $halfYear);

        $this->setPage(4);
        $this->setTextBreakSymbol(141.5,16.6, $halfYear);
    }

    /**
     * Устанавливаем год
     * @param $year
     */
    function setYear($year) {
        $this->setPage(1);
        $this->setTextBreakSymbol(161.2,70, $year);

        $this->setPage(2);
        $this->setTextBreakSymbol(170,16.6, $year);

        $this->setPage(3);
        $this->setTextBreakSymbol(170,16.6, $year);

        $this->setPage(4);
        $this->setTextBreakSymbol(170,16.6, $year);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_001($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,151.2, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_002($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,158.4, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_003($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,166.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_003_a($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,173.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_003_b($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,181, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_004($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,190.7, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_005($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,197.7, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_006($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,205, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_007($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,212.4, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_008($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,219.9, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_009($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,227.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_010_1($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(84.9,253, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_010_2($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(84.9,260.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_010_3($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(84.9,267.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_010_4($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,246.4, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_010_5($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,253, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_010_6($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,260.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_010_7($value) {
        $this->setPage(1);
        $this->setNumberBreakSymbol(197,267.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_011_1($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.6,39.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_011_2($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.6,46.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_011_3($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.6,53.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_011_4($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,34.9, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_011_5($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,41.6, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_011_6($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,48.6, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_011_7($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,55.6, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_012_1($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,71.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_012_2($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,78.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_012_3($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,85.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_012_4($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,66.6, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_012_5($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,73.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_012_6($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,80.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_012_7($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,87.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_013_1($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,102.8, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_013_2($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,110, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_013_3($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,116.8, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_013_4($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,98.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_013_5($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,105, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_013_6($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,112.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_013_7($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,119, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_014_1($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,134.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_014_2($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,141.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_014_3($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,148.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_014_4($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,130, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_014_5($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,136.7, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_014_6($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,143.8, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_014_7($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,150.7, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_015_1($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,177.2, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_015_2($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,184.2, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_015_3($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,191.2, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_015_4($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,172.7, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_015_5($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,179.4, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_015_6($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,186.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_015_7($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,193.4, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_016_1($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,210.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_016_2($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,217.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_016_3($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,224.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_016_4($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,206, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_016_5($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,212.7, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_016_6($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,219.8, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_016_7($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,226.7, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_017_1($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,243.9, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_017_2($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,250.9, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_017_3($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(85.5,257.9, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_017_4($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,239.4, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_017_5($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,246.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_017_6($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,253.2, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_017_7($value) {
        $this->setPage(2);
        $this->setNumberBreakSymbol(197,260.1, $value);
    }


    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_018_1($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.6,40.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_018_2($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.6,47.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_018_3($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.6,54.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_018_4($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,35.9, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_018_5($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,42.6, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_018_6($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,49.6, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_018_7($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,56.6, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_019_1($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,73.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_019_2($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,80.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_019_3($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,87.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_019_4($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,68.8, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_019_5($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,75.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_019_6($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,82.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_019_7($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,89.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_020_1($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,103.8, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_020_2($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,111, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_020_3($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,117.8, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_020_4($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,99.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_020_5($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,106, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_020_6($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,113.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_020_7($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,120, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_021_1($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,136.8, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_021_2($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,143.8, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_021_3($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,150.8, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_021_4($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,132.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_021_5($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,139, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_021_6($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,146.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_021_7($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,153, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_022_1($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,170, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_022_2($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,177, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_022_3($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,184, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_022_4($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,165.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_022_5($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,172.2, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_022_6($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,179.3, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_022_7($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,186.2, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_023_1($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,202.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_023_2($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,209.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_023_3($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,216.5, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_023_4($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,198, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_023_5($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,204.7, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_023_6($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,211.8, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_023_7($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,218.7, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_024_1($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,234.9, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_024_2($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,241.9, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_024_3($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(85.5,248.9, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_024_4($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,230.4, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_024_5($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,237.1, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_024_6($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,244.2, $value);
    }

    /**
     * Устанавливаем значение
     * @param $value
     */
    function set_910_00_024_7($value) {
        $this->setPage(3);
        $this->setNumberBreakSymbol(197,251.1, $value);
    }
}