<?php if(count($data['view::View_Shop_Good\group\basic\rubrikatciya-s-detvoroi']->childs) > 0){ ?>
<div class="col-md-6 col-sm-12">
    <div class="kc-col-container">
        <div class="kc_text_block">
            <ul>
				<?php
				$n = ceil(count($data['view::View_Shop_Good\group\basic\rubrikatciya-s-detvoroi']->childs));
				$i = 1;
				foreach ($data['view::View_Shop_Good\group\basic\rubrikatciya-s-detvoroi']->childs as $value){
					if($i == $n + 1){
						echo '</ul></div></div></div><div class="col-md-6 col-sm-12"><div class="kc-col-container"><div class="kc_text_block"><ul>';
						$i = 1;
					}
					$i++;
					echo $value->str;
				}
				?>
            </ul>
        </div>
    </div>
</div>
<?php }?>