<?php

function isIgnore($name){
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
        default:
            return FALSE;
    }
}

function writeElementName(&$data, $name){
    switch($name){
        case 'shop_table_rubric_id': $result = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_table_rubric_id.name', ''); break;
        case 'addresscontact_select_type_id': $result = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.addresscontact_select_type_id.name', ''); break;
        case 'shop_addresscontact_unit_type_id': $result = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_addresscontact_unit_type_id.name', ''); break;
        default:
            $result = '';
    }

    if(!empty($result)) {
        $result = '<' . $name.'_name' . '>' . htmlspecialchars($result, ENT_XML1) . '</' . $name.'_name' . '>' . "\r\n";
    }
    return $result;
}

function writeValue(&$value){
    if(is_array($value)){
        $result = '';
        foreach($value as $key1 => $value1) {
            if(!Func::emptyValue($value1)) {
                if (is_numeric($key1)) {
                    $key1 = 'data';
                }

                $result = $result . '<' . $key1 . '>' . writeValue($value1) . '</' . $key1 . '>' . "\r\n";
            }
        }
    }else{
        $result = htmlspecialchars($value, ENT_XML1);
    }

    return $result;
}
?>