<?php if(count($data['view::View_Shop_New\basic\sotcialnye-seti']->childs) > 0){?>
    <div class="footer-social-icons">
        <ul class="social-icons nav">
            <?php
            foreach ($data['view::View_Shop_New\basic\sotcialnye-seti']->childs as $value){
                echo $value->str;
            }
            ?>
        </ul>
    </div>
<?php }?>

