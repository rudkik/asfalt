<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_XML {
    /**
     * @param $name
     * @param SimpleXMLElement $fields
     * @return bool
     */
    public static function isXMLField($name, $fields)
    {
        $children = $fields->children();
        foreach($children as $child){
            if ($child->getName() == $name) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $field
     * @param $name
     * @return array|mixed|string
     */
    public static function getXMLFieldValue($field, $name)
    {
        try {
            $result = $field->$name;
        }catch (Exception $e){
            $result = '';
        }

        if (is_array($result) && (count($result) == 1)){
            $result = array_shift($result);
        }
        if (!is_array($result)){
            $result = trim(strval($result));
        }
        if($result == 'NULL' || $result == '#NULL!'){
            $result = null;
        }

        return $result;
    }

    /**
     * @param $value
     * @return array|mixed|string
     */
    public static function getXMLValue($value)
    {
        if (is_array($value) && (count($value) == 1)){
            $value = array_shift($value);
        }
        if (!is_array($value)){
            $value = trim(strval($value));
        }
        if($value == 'NULL' || $value == '#NULL!'){
            $value = null;
        }

        return $value;
    }

    /**
     * Получаем массив и XML
     * @param SimpleXMLElement $xml
     * @return array
     */
    public static function xmlToArray(SimpleXMLElement $xml): array
    {
        $parser = function (SimpleXMLElement $xml, array $collection = []) use (&$parser) {
            $nodes = $xml->children();
            $attributes = $xml->attributes();

            if (0 !== count($attributes)) {
                foreach ($attributes as $attrName => $attrValue) {
                    $collection['attributes'][$attrName] = strval($attrValue);
                }
            }

            if (0 === $nodes->count()) {
                $collection['value'] = strval($xml);
                return $collection;
            }

            foreach ($nodes as $nodeName => $nodeValue) {
                if (count($nodeValue->xpath('../' . $nodeName)) < 2) {
                    $collection[$nodeName] = $parser($nodeValue);
                    continue;
                }

                $collection[$nodeName][] = $parser($nodeValue);
            }

            return $collection;
        };

        return [
            $xml->getName() => $parser($xml)
        ];
    }

    /**
     * Получаем массив и XML
     * @param XMLReader $xml
     * @return array
     */
    public function xmlReaderToArray(XMLReader $xml) {
        $tree = null;

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::END_ELEMENT) {
                return $tree;
            } else if ($xml->nodeType == XMLReader::ELEMENT) {
                if ((!$xml->isEmptyElement)) {
                    $childs = self::xmlReaderToArray($xml);

                    if (count($childs) > 1) {
                        if (isset($tree[$xml->localName])) {
                            if (!isset($tree[$xml->localName][0])) {
                                $moved = $tree[$xml->localName];
                                unset($tree[$xml->localName]);
                                $tree[$xml->localName][0] = $moved;
                            }
                            $tree[$xml->localName][] = $childs;
                        } else {
                            $tree[$xml->localName] = $childs;
                        }
                    } else {
                        $tree[$xml->localName] = $childs;
                    }
                }
            } else if ($xml->nodeType == XMLReader::TEXT) {
                $tree = $xml->value;
            }
        }
        return $tree;
    }
}