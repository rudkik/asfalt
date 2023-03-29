<?php

function isIgnore($name){
    return ! ($name == 'id' || $name == 'name' ||$name == 'shop_table_catalog_id');

    switch($name){
        case 'preview_count': return TRUE; break;
        case 'addresscontact_id': return TRUE; break;
        case 'update_user_id': return TRUE; break;
        case 'updated_at': return TRUE; break;
        case 'deleted_at': return TRUE; break;
        case 'delete_user_id': return TRUE; break;
        case 'sort': return TRUE; break;
        case 'seo': return TRUE; break;
        case 'global_id': return TRUE; break;
        case 'language_id': return TRUE; break;
        case Model_Basic_BasicObject::FIELD_ELEMENTS: return TRUE; break;
        case 'remarketing': return TRUE; break;
        case 'is_additional_discount': return TRUE; break;
        case 'discount': return TRUE; break;
        case 'is_percent': return TRUE; break;
        case 'sales_addresscontact_count': return TRUE; break;
        case 'options': return TRUE; break;
        case 'info': return TRUE; break;
        default:
            return FALSE;
    }
}

function writeElementName(&$data, $name, $value){
    switch($name){
        case 'shop_table_catalog_id':
            $options = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_table_catalog_id.options', '');

            $result = '';
            foreach($options as $option){
                $result = $result . writeValue(Arr::path($data->values['options'], $option['field'], ''));
            }

            return $result;
            break;
        case 'shop_table_rubric_id': $result = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_table_rubric_id.name', ''); break;
        case 'addresscontact_select_type_id': $result = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.addresscontact_select_type_id.name', ''); break;
        case 'shop_addresscontact_unit_type_id': $result = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_addresscontact_unit_type_id.name', ''); break;
        default:
            $result = $value;
    }

    $result = writeValue($result);
    return $result;
}

function writeValue($value){
    $value = str_replace('"', '""', str_replace("\r\r", '\r\n', $value));
    if((strpos($value, '"') !== FALSE) || (strpos($value, ';') !== FALSE)){
        $value = '"'.$value.'"';
    }

    return $value.';';
}
?>