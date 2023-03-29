<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Word
{
    /**
     * Замена текста на другой
     * @param $sections - $phpWord->getSections()
     * @param string $search
     * @param string $replace
     */
    public static function replaceText($sections, $search, $replace)
    {
        $text_class = 'PhpOffice\PhpWord\Element\Text';
        $table_class = 'PhpOffice\PhpWord\Element\Table';
        foreach ($sections as $e) {
            if (get_class($e) !== $text_class && method_exists($e, 'getElements')) {
                self::replaceText($e->getElements(), $search, $replace);
            } elseif (get_class($e) === $text_class && ($match_count = substr_count($e->getText(), $search))) {
                for ($i = 1; $i <= $match_count; $i++) {
                    $e->setText(str_replace($search, $replace, $e->getText()));
                }
            } elseif (get_class($e) === $table_class && ($row_count = count($e->getRows()))) {
                foreach ($e->getRows() as $row) {
                    foreach ($row->getCells() as $cell) {
                        self::replaceText($cell->getElements(), $search, $replace);
                    }
                }
            }
        }
    }
}