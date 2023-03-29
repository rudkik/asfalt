<record>
    <?php

    foreach($data->values as $key => $value){
        if($key != Model_Basic_BasicObject::FIELD_ELEMENTS) {
            if (is_array($value)) {
                Func::echoArrayInXML($key, $value);
            } else {
                echo '<' . $key . '>' . htmlspecialchars($value) . '</' . $key . '>';
            }
        }
    }
    ?>
</record>