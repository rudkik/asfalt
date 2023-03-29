<?php defined('SYSPATH') or die('No direct script access.');

require_once APPPATH . 'vendor' . DIRECTORY_SEPARATOR . 'TCPDF' . DIRECTORY_SEPARATOR . 'tcpdf.php';

class PDF_Page extends TCPDF
{
    function __construct($title, $author = 'Er2003', $isAddPage = TRUE)
    {
        $orientation = PDF_PAGE_ORIENTATION;
        $unit = PDF_UNIT;
        $size = PDF_PAGE_FORMAT;
        parent::__construct($orientation, $unit, $size, true, 'UTF-8', false);

        $this->SetAuthor($author);
        $this->SetTitle($title);

        if ($isAddPage) {
            $this->AddPage(PDF_PAGE_ORIENTATION, PDF_PAGE_FORMAT);
        }

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
     * Добавление таблицы через HTML код
     * @param array $styleColumns
     * @param array $data
     */
    function setTable(array $styleColumns, array $data) {
        $styleColumns = array_values($styleColumns);

        $html = '<table>';
        foreach ($data as $row){
            $html = $html. '<tr>';

            $i = 0;
            foreach ($row as $col){
                $html = $html . '<td '.Arr::path($styleColumns, $i, '').'>' . $col . '</td>';
                $i++;
            }

            $html = $html. '</tr>';
        }
        $html .= '</table>';

        $this->writeHTML($html, true, false, true, false, '');
    }

    /**
     * Добавление нового шрифта из TTF должен лежать в папки application\vendor\TCPDF\ttf
     * @param $fontFile
     * @param string $fontType
     * @return mixed|string
     */
    function addNewFont($fontFile, $fontType = 'TrueTypeUnicode')
    {
        return TCPDF_FONTS::addTTFfont(APPPATH . 'vendor' . DIRECTORY_SEPARATOR . 'TCPDF' . DIRECTORY_SEPARATOR .
            'ttf'. DIRECTORY_SEPARATOR.$fontFile, $fontType, '', 32);
    }
}