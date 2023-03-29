<h3 class="title-red">Размеры и виды льда предлагаемые к поставке:</h3>
<div class="row" style="margin: 0px -7.5px">
    <?php
    foreach ($data['view::View_Shop_New\vid_lda']->childs as $value){
    echo $value->str;
    }
    ?>
</div>
