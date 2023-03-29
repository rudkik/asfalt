<?php defined('SYSPATH') or die('No direct script access.');

require_once Helpers_Path::getPathFile(APPPATH, ['vendor', 'PhpSpreadsheet'], 'autoload.php');

use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Helpers_Spreadsheet
{

    /**
     * Кодируем штрихкод для Excel
     * Необходим шрифт Code EAN13
     * Ссылка для скачивания: https://ultilitum.ucoz.ru/files/generatorEAN13/ean13.ttf
     * @param string $barcode
     * @return string
     */
    public static function getEncodeEAN13(string $barcode):string
    {
        if(strlen($barcode) != 13){
            return '';
        }

        $barcode = str_replace(
            '#barcode#',
            $barcode,
            '=LEFTB(&quot;#barcode#&quot;)&amp;CHAR(MID(&quot;#barcode#&quot;,2,1)+65)&amp;CHAR((--LEFTB(&quot;#barcode#&quot;)&gt;3)*10+65+MID(&quot;#barcode#&quot;,3,1))&amp;CHAR(MID(&quot;#barcode#&quot;,4,1)+75-ISNUMBER(SEARCH(LEFTB(&quot;#barcode#&quot;),&quot;0478&quot;))*10)&amp;CHAR(MID(&quot;#barcode#&quot;,5,1)+75-ISNUMBER(SEARCH(LEFTB(&quot;#barcode#&quot;),&quot;01459&quot;))*10)&amp;CHAR(MID(&quot;#barcode#&quot;,6,1)+75-ISNUMBER(SEARCH(LEFTB(&quot;#barcode#&quot;),&quot;02567&quot;))*10)&amp;CHAR(MID(&quot;#barcode#&quot;,7,1)+75-ISNUMBER(SEARCH(LEFTB(&quot;#barcode#&quot;),&quot;03689&quot;))*10)&amp;&quot;*&quot;&amp;CHAR(MID(&quot;#barcode#&quot;,8,1)+97)&amp;CHAR(MID(&quot;#barcode#&quot;,9,1)+97)&amp;CHAR(MID(&quot;#barcode#&quot;,10,1)+97)&amp;CHAR(MID(&quot;#barcode#&quot;,11,1)+97)&amp;CHAR(MID(&quot;#barcode#&quot;,12,1)+97)&amp;CHAR(MID(&quot;#barcode#&quot;,13,1)+97)&amp;&quot;+&quot;'
        );

        return $barcode;
    }

    /**
     * Добавляем табличные данные
     * @param $countDelete
     * @param $field
     * @param $childName
     * @param $start
     * @param Worksheet $sheet
     * @param array $data
     * @param array $list
     * @param bool $isDeleteExcessRow
     * @param bool $isDeleteNewLogic
     * @return int
     */
    private static function _addFileList(&$countDelete, $field, $childName, $start, Worksheet $sheet, array $data,
                                         array $list = array(), $isDeleteExcessRow = TRUE, $isDeleteNewLogic = TRUE)
    {
        $finish = -1;
        $s = '&&&'.$field.'#end^';

        $nColumn = Coordinate::columnIndexFromString($sheet->getHighestColumn());
        for ($i = $start + 1; $i <= $sheet->getHighestRow(); $i++) {
            $isAutoHeight = FALSE;
            for ($j = 0; $j < $nColumn; $j++) {
                $value = $sheet->getCellByColumnAndRow($j, $i)->getValue();
                if ($value == '%%auto_height%%'){
                    $sheet->getCellByColumnAndRow($j, $i)->setValue('');
                    $isAutoHeight = TRUE;
                    continue;
                }

                if($value != $s){
                    continue;
                }else{
                    $finish = $i;
                    $sheet->getCellByColumnAndRow($j, $i)->setValue('');
                    break 2;
                }
            }
            // автоподбор строки
            if ($isAutoHeight) {
                $sheet->getRowDimension($i)->setRowHeight(-1);
            }
        }

        if($finish == -1){
           return 0;
        }

        // кол-во строк занимаемая элементом
        $countOne = 1;

        $table = $list[$field];

        // кол-во строк, которые можно задать исходя из XLS-файла
        $count = count($table);
        if($count > ($finish - $start)){
            $count = ($finish - $start);
        }
        for ($i = 0; $i < $count; $i++) {
            $one = current($table);
            for ($j = 0; $j < $nColumn; $j++) {
                $value = $sheet->getCellByColumnAndRow($j, $i + $start + 1)->getValue();
                if(empty($value)){
                    continue;
                }
                $b = 0;
                $b = mb_strpos($value, '&&&', $b);
                $n = 0;
                while($b !== FALSE) {
                    $n++;
                    if($n == 10) {
                       // die;
                    }
                    $e = mb_strpos($value, '^', $b);
                    if ($e === FALSE) {
                        $b = FALSE;
                        continue;
                    }

                    $str = mb_substr($value, $b, $e - $b + 1);
                    $bf = mb_strpos($str, '#', 3);
                    if ($bf === FALSE) {
                        $b = $e + 1;
                        $b = mb_strpos($value, '&&&', $b);
                        continue;
                    }

                    $field = mb_substr($str, 3, $bf - 3);
                    if ($field == $childName) {
                        $path = mb_substr($str, $bf + 1, strlen($str) - $bf - 2);
                        $new = Arr::path($one, $path, '');
                        $value = Func::mb_str_replace($str, $new, $value);
                        $sheet->getCellByColumnAndRow($j, $i  + $start + 1)->setValue($value);

                        $b = $b + mb_strlen($new);
                    }elseif (key_exists($field, $data)) {
                        $path = mb_substr($str, $bf + 1, strlen($str) - $bf - 2);
                        $new = Arr::path($data, $field . '.' . $path, '');
                        $value = Func::mb_str_replace($str, $new, $value);

                        $sheet->getCellByColumnAndRow($j, $i  + $start + 1)->setValue($value);

                        $b = $b + mb_strlen($new);
                    } else {
                        $b = $b + mb_strlen($str);
                    }
                    $b = mb_strpos($value, '&&&', $b);
                }
            }
            next($table);
        }

        if ($isDeleteExcessRow) {
            if($isDeleteNewLogic && false){
                $cellController  = $sheet->getCellCacheController();
                foreach ($cellController->getCellList() as $coord) {
                    sscanf($coord, '%[A-Z]%d', $c, $r);
                    if ($r >= $start + $count + 1 && $r <= $start + $count + 1) {
                        $cellController->deleteCacheData($coord);
                    }
                }

                $objReferenceHelper = Spreadsheet_ReferenceHelper::getInstance();
                $objReferenceHelper->insertNewBefore('A' . ($finish+1), 0, -($finish - ($start + $count)), $sheet);
            }else{
                for ($i = $finish; $i >= $start + $count + 1; $i--) {
                    $sheet->removeRow($i, 1);
                }
            }

            $countDelete = $countDelete + $finish - $start - $count - 1;
            return $count * $countOne;
        }else {
            for ($i = $start + $count + 1; $i <= $finish; $i++) {
                $sheet->getRowDimension($i)->setVisible(false);
                for ($j = 0; $j < $nColumn; $j++) {
                    $sheet->getCellByColumnAndRow($j, $i)->setValue('');
                }
            }

            return $finish - $start;
        }
    }

    /**
     * выводим данные по шаблону
     * @param $fileName
     * @param array $data
     * @param array $list
     * @param string $fileSave
     * @param null $fileNameSave
     * @param bool $isDeleteNewLogic
     * @throws HTTP_Exception_500
     */
    public static function saleInFile($fileName, array $data, array $list = array(), $fileSave = 'php://output',
                                      $fileNameSave = NULL, $isDeleteNewLogic = TRUE)
    {
        ob_end_clean();

        /** @var Spreadsheet $objSpreadsheet */
        $objSpreadsheet = PhpSpreadsheet\IOFactory::load($fileName);

    foreach ($objSpreadsheet->getAllSheets() as $sheet) {
        $shift = 0;
        $countDelete = 0;
        $nColumn = Coordinate::columnIndexFromString($sheet->getHighestColumn());
        $nRow = $sheet->getHighestRow();
        for ($i = 1; $i <= $nRow; $i++) {
            if ($nRow < $i + $shift + $countDelete) {
                break;
            }

            $isAutoHeight = FALSE;
            for ($j = 0; $j <= $nColumn; $j++) {
                $value = $sheet->getCellByColumnAndRow($j, $i + $shift)->getValue();
                if (empty($value)) {
                    continue;
                }
                if ($value == '%%auto_height%%') {
                    $sheet->getCellByColumnAndRow($j, $i + $shift)->setValue('');
                    $isAutoHeight = TRUE;
                    continue;
                }
                if (strpos($value, '%%auto_height%%') !== FALSE) {
                    $value = parse_url($value);

                    if (!empty($value['query'])) {
                        parse_str($value['query'], $value);

                        $isAutoHeight = key_exists('width', $value) && key_exists('column_from', $value);

                        // %%auto_height%%?width=662&column_from=1&column_to=ZZ
                        if ($isAutoHeight) {
                            $sheet->setCellValue($value['column_to'] . ($i + $shift), $sheet->getCellByColumnAndRow($value['column_from'] - 1, $i + $shift)->getValue());
                            $sheet->getColumnDimension($value['column_to'])->setWidth($value['width'])->setVisible(false);
                            $sheet->getStyle($value['column_to'] . ($i + $shift))->getAlignment()->setWrapText(true);
                        }
                    }

                    $sheet->getCellByColumnAndRow($j, $i + $shift)->setValue('');
                    continue;
                }

                $b = 0;
                $b = mb_strpos($value, '&&&', $b);
                while ($b !== FALSE) {
                    $e = mb_strpos($value, '^', $b);
                    if ($e === FALSE) {
                        $b = FALSE;
                        continue;
                    }

                    $str = mb_substr($value, $b, $e - $b + 1);
                    $bf = mb_strpos($str, '#', 3);
                    if ($bf === FALSE) {
                        $b = $e;
                        $b = mb_strpos($value, '&&&', $b);
                        continue;
                    }

                    $field = mb_substr($str, 3, $bf - 3);
                    if (key_exists($field, $data)) {
                        $path = mb_substr($str, $bf + 1, strlen($str) - $bf - 2);
                        $new = Arr::path($data, $field . '.' . $path, '');
                        $value = Func::mb_str_replace($str, $new, $value);

                        $sheet->getCellByColumnAndRow($j, $i + $shift)->setValue($value);

                        $b = $b + mb_strlen($new);
                    } elseif (key_exists($field, $list)) {
                        $child = mb_substr($str, $bf + 1, mb_strlen($str) - $bf - 2);

                        // добавляем табличные данные
                        $sheet->getCellByColumnAndRow($j, $i + $shift)->setValue('');
                        $shift = $shift + self::_addFileList(
                                $countDelete, $field, $child, $i + $shift, $sheet,
                                $data, $list, true, false
                            );

                        break;
                    } else {
                        $b = $b + mb_strlen($value);
                    }

                    if (mb_strlen($value) < $b) {
                        $b = FALSE;
                    } else {
                        $b = mb_strpos($value, '&&&', $b);
                    }
                }
            }

            // автоподбор строки
            if ($isAutoHeight) {
                $sheet->getRowDimension($i + $shift)->setRowHeight(-1);
            }
        }
        // $sheet->getRowDimension($i)->setVisible(false);
    }

        if ($fileSave == 'php://output') {
            if(empty($fileNameSave)){
                $fileNameSave = $fileName;
            }

            header('Content-Type: application/x-download;charset=UTF-8');
            header("Content-Disposition: attachment; filename*=UTF-8''".rawurlencode($fileNameSave));
            header('Cache-Control: max-age=0');
        }

        $objWriter = new Xlsx($objSpreadsheet);
        try{
            $objWriter->save($fileSave);
        }catch (Exception $e){
            throw new HTTP_Exception_500($e->getMessage());
        }
    }

    /**
     * Загрузить данные в массив из Excel-файла
     * @param $fileName
     * @param $firstRow
     * @param array $options
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function loadFileInData($fileName, $firstRow, array $options)
    {
        if(! file_exists($fileName)){
            return array();
        }

        // приводим настройки в надлежащий вид
        $list = [];
        foreach($options as $option){
            if(!is_array($option)){
                continue;
            }

            $list[] = [
                'field' => Arr::path($option, 'field', ''),
                'is_check' => Request_RequestParams::isBoolean(Arr::path($option, 'is_check', false)),
                'column' => Arr::path($option, 'column', ''),
                'formula' => Arr::path($option, 'formula', ''),
                'is_join_horizontal ' => Request_RequestParams::isBoolean(Arr::path($option, 'is_join_horizontal ', false)),
                'join_level_vertical' => Arr::path($option, 'join_level_vertical', 0),
                'is_template' => Request_RequestParams::isBoolean(Arr::path($option, 'is_template', false)),
                'default' => Arr::path($option, 'default', ''),
            ];
        }
        $options = $list;

        $objSpreadsheet = PhpSpreadsheet\IOFactory::load($fileName);
        $sheet = $objSpreadsheet->getActiveSheet();

        $result = array();
        $nRow = $sheet->getHighestRow();
        $nCol = Coordinate::columnIndexFromString($sheet->getHighestColumn());
        $joinList = array();
        // последняя строчка были ли успешно считана
        $isLastRecord = false;
        for ($i = $firstRow; $i <= $nRow; $i++) {
            $values = array();
            $isCheck = TRUE;
            $joinValues = [];
            foreach($options as $option){
                $column = $option['column'];
                $field = $option['field'];

                $value = '';
                if($option['is_template']){
                    $template = $column;
                    for ($j = 1; $j <= $nCol; $j++) {
                        $value = $sheet->getCellByColumnAndRow($j - 1, $i)->getCalculatedValue();
                        if($value == '#REF!'){
                            $value = '';
                        }

                        $template = Func::mb_str_replace('{' . $j . '}', $value, $template);
                    }

                    $value = $template;
                }elseif ($column > 0) {
                    $value = $sheet->getCellByColumnAndRow($column - 1, $i)->getCalculatedValue();
                    if ($value == '#REF!') {
                        $value = '';
                    }
                }

                // для соединение несколько строк в одну
                // Холодильная камера
                // Бюруза
                // 210 хs
                // в Холодильная камера Бюруза 210 хs
                if(!empty($value) && $option['join_level_vertical'] > 0) {
                    $joinValues[$field] = [
                        'level' => $option['join_level_vertical'],
                        'value' => $value,
                    ];
                }

                // значение по умолчанию
                if(empty($value)){
                    $value = $option['default'];
                }

                if($option['is_check'] && empty($value)){
                    $isCheck = FALSE;
                    continue;
                }

                if(empty($value)){
                    continue;
                }

                $formula = $option['formula'];
                if (!empty($formula)){
                    if(!function_exists('eval')) {
                        throw new HTTP_Exception_500('Eval function is not enabled.');
                    }

                    try {
                        $sFormula = str_replace('#field#', $value, $formula);
                        eval("\$r = $sFormula;");
                        $value = $r;
                    }catch (Exception $e){
                        throw new HTTP_Exception_500('Formula "'.$formula.'" not correct.');
                    }
                }

                if (key_exists($field, $values)) {
                    if($option['is_join_horizontal']) {
                        // нужно ли горизонтально соединять колонки, формируя запись из нескольких колонок
                        $values[$field] = $values[$field] . ' ' . $value;
                    }else{
                        if (!is_array($values[$field])) {
                            $values[$field] = array($values[$field]);
                        }
                        $values[$field][] = $value;
                    }
                } else {
                    $values[$field] = $value;
                }
            }

            if($isCheck){
                if(!empty($values)){
                    // добавляем верхнии уровни
                    foreach ($joinList as $field => $child){
                        $child = implode(' ', $child);
                        if(key_exists($field, $values)){
                            $values[$field] = $child . ' ' . $values[$field];
                        }else{
                            $values[$field] = $child;
                        }
                    }

                    $result[] = $values;
                    $isLastRecord = true;
                }
            }else{
                foreach ($joinValues as $field => $child){
                    if(key_exists($field, $joinList)){
                        $count = count($joinList[$field]);
                        if ($count >= $child['level']) {
                            if (!$isLastRecord) {
                                // сдвигаем вверх
                                for ($j = 0; $j < $count - 1; $j++) {
                                    $joinList[$field][$j] = $joinList[$field][$j + 1];
                                }
                            }
                            $count--;
                        }

                        $joinList[$field][$count] = $child['value'];
                    }else{
                        $joinList[$field] = [$child['value']];
                    }
                }

                $isLastRecord = false;
            }
        }

        return $result;
    }
}