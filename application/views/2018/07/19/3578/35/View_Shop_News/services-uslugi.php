<div class="box-services">
    <div class="table-row">
        <?php
        $n = 3;
        $i = 1;
        $isBox = FALSE;
        foreach ($data['view::View_Shop_New\services-uslugi']->childs as $value){
            if($i == $n + 1){
                echo '</div></div></div><div class="line-service"></div><div class="box-services"><div class="table-row">';
                $i = 1;
                $isBox = FALSE;
            }
            if($i == 1){
                $value->str = str_replace('<div class="service">', '<div class="service box-service">', $value->str);
            }elseif($i == 2){
                echo '<div class="box-service">';
                $isBox = TRUE;
            }

            $i++;
            echo $value->str;
            if($i != 4) {
                echo '<div class="line-service"></div>';
            }
        }
        if($isBox){
            echo '</div>';
        }
        ?>
    </div>
</div>

