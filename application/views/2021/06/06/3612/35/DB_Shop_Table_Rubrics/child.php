<section class="header-rubric">
    <div class="row box-rubrics">
        <div class="col-md-3">
            <?php
            $count = count($data['view::DB_Shop_Table_Rubric\child']->childs);
            $n = ceil($count / 4);
            $i = 1;
            foreach ($data['view::DB_Shop_Table_Rubric\child']->childs as $value){
                if($i == $n + 1){
                    echo '</div><div class="col-md-3">';
                    $i = 1;
                }
                $i++;
                echo $value->str;
            }
            ?>
        </div>
    </div>
</section>


<style>
    .header-rubric{
        padding-bottom: 30px;
    }
    .box-rubrics{
        width: 100%;
        margin-right: -15px !important;
        margin-left: -15px !important;
    }
    .box-rubric{
        text-align: left;
        margin-bottom: 15px;
    }
    .box-rubric > a{
        text-decoration: underline;
    }
    .box-rubric > a:focus, .box-rubric > a:active, .box-rubric > a:hover{
        text-decoration: none;
    }
</style>