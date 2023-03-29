[<?php
$s = '';
foreach ($data['view::View_Shop_Good\-produktciya']->childs as $value){
    $s .= $value->str.',';
}
echo mb_substr($s, 0, -1);
?>
]