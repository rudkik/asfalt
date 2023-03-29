<?xml version="1.0" encoding="UTF-8" ?>
<records>
    <?php
    foreach ($data['view::shopmessage/save/xml']->childs as $value) {
        echo $value->str."\r\n";
    }
    ?>
</records>
