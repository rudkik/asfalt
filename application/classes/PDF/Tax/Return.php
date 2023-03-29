<?php defined('SYSPATH') or die('No direct script access.');

require_once APPPATH . 'vendor' . DIRECTORY_SEPARATOR . 'TCPDF' . DIRECTORY_SEPARATOR . 'tcpdf.php';

class PDF_Tax_Return extends TCPDF
{
    function __construct($title, $author = 'Bigbuh.kz')
    {
        $orientation = PDF_PAGE_ORIENTATION;
        $unit = PDF_UNIT;
        $size = PDF_PAGE_FORMAT;
        parent::__construct($orientation, $unit, $size, true, 'UTF-8', false);

        $this->SetAuthor($author);
        $this->SetTitle($title);

        $this->AddPage(PDF_PAGE_ORIENTATION, PDF_PAGE_FORMAT);

        $this->SetFont('Helvetica','',20);
        $this->SetFontSize(10);
        $this->SetDrawColor(50,60,100);
    }

    /**
     * Установить картинку размером со всю страницу
     * @param $path
     */
    function setBackgroundImage($path) {
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);

        $this->SetMargins(0, 0, 0, true);
        $this->SetAutoPageBreak(false, 0);

        $this->Image($path, 0, 0, 210, 297, '', '', '', true, 300, '', false, false, 0, false, false, true);
    }

    /**
     * Вставляем текст разбитый по ячейкам
     * @param $x
     * @param $y
     * @param $text
     */
    function setTextBreakSymbol($x, $y, $text) {
        for ($i = 0; $i < mb_strlen($text); $i++){
            $this->Text($x, $y, mb_substr($text, $i, 1, 'UTF8'));
            $x += 5;
        }
    }

    /**
     * Выводит многострочный текст разбитый по ячейкам
     * @param array $lines - array(0 => array('x' => 34, 'y' => 42, 'size' => 34), 1 => array('x' => 14, 'y' => 62, 'size' => 57))
     * @param $text
     */
    function setTextBreakSymbolAndLine(array $lines, $text) {
        $shift = 0;
        foreach ($lines as &$line){
            $this->setTextBreakSymbol($line['x'], $line['y'], trim(mb_substr($text, $shift, $line['size'], 'UTF8')));
            $shift += $line['size'];
        }
    }

    /**
     * Вставляем число разбитый по ячейкам
     * @param $x
     * @param $y
     * @param $number
     */
    function setNumberBreakSymbol($x, $y, $number) {
        $number = str_replace(' ', '', $number);
        for ($i = mb_strlen($number) - 1; $i > -1; $i--){
            $this->Text($x, $y, mb_substr($number, $i, 1, 'UTF8'));
            $x -= 5;
        }
    }
}