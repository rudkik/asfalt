<div id="comments" class="carousel slide" data-ride="carousel" data-interval="10000">
    <div class="carousel-inner">
        <?php
        $i = 0;
        foreach ($data['view::View_Shop_Comment\-otzyvy']->childs as $value){
            if($i == 0){
                $value->str = str_replace('<div class="item">', '<div class="item active">', $value->str);
                $i++;
            }
            echo $value->str;
        }
        ?>
    </div>
</div>
<!-- Индикаторы -->
<ol class="box-indicators">
    <?php
    $i = 0;
    foreach ($data['view::View_Shop_Comment\-otzyvy']->childs as $value){
        if($i == 0){
            echo '<li data-target="#comments" data-slide-to="0" class="active"></li>';
        }else{
            echo '<li data-target="#comments" data-slide-to="'.$i.'"></li>';
        }
      $i++;
    }
    ?>
</ol>

