<div id="carousel-sector" class="carousel slide">
    <div class="carousel-inner">
        <?php
        $id = Request_RequestParams::getParamInt('sector');
        $n = 4;
        $j = 1;
        if ($id > 0) {
            $s = '';
            foreach ($data['view::View_Shop\basic\napravleniya']->childs as $value) {
                if($j == $n + 1){
                    $s .= '</div><div class="item">';
                    $j = 1;
                }
                $j++;

                $s .= $value->str;
            }
            echo str_replace('class="col-md-3 sector" data-id="'.$id.'"', 'class="col-md-3 sector active" data-id="'.$id.'"', $s);
        }else{
            echo '<div class="item active">';
            $i = 1;
            foreach ($data['view::View_Shop\basic\napravleniya']->childs as $value) {
                if ($i == 1){
                    $value->str = str_replace('class="col-md-3 sector"', 'class="col-md-3 sector active"', $value->str);
                    $i++;
                }

                if($j == $n + 1){
                    echo '</div><div class="item">';
                    $j = 1;
                }
                $j++;
                echo $value->str;
            }
            echo '</div>';
        }
        ?>
    </div>
    <a class="left carousel-control" href="#carousel-sector" role="button" data-slide="prev">
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/sector-left.png">
    </a>
    <a class="right carousel-control" href="#carousel-sector" role="button" data-slide="next">
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/sector-right.png">
    </a>
</div>

