<?php
$isActive = TRUE;
$random = rand(1,1000);
if(count($data['view::View_Shop_Good\group\basic\menyu']->childs) > 0){ ?>
    <?php
    $arr = array();
    foreach ($data['view::View_Shop_Good\group\basic\menyu']->childs as $value){
        $arr[] = json_decode($value->str, TRUE);
    }
    ?>
    <div class="dropdown-menu box-my-menu">
        <div class="media-left" style="padding: 0px;">
            <ul class="nav navbar-nav box-menu-title">
                <?php
                $i = 1;
                foreach ($arr as $child){
                    if ($isActive && ($i == 1)){
                        $child['one'] = str_replace('<li class=""', '<li class="active"', $child['one']);
                        $i++;
                    }
                    echo $child['one'];
                }
                ?>
            </ul>
        </div>
        <div class="media-body box-child-menu">
            <?php
            $i = 1;
            foreach ($arr as $child){
                if ($isActive && ($i == 1)){
                    $child['list'] = str_replace('box-menu-child-list', 'box-menu-child-list active', $child['list']);
                    $i++;
                }
                echo $child['list'];
            }
            ?>
        </div>
    </div>
<?php } ?>
