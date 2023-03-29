<div class="row">
	<div class="col-md-4">
		<ul class="box-menu-rubric">
			<?php
			$n = ceil(count($data['view::View_Shop_Good\-brands-rubriki-brendov']->childs) / 3);
			$i = 1;
			foreach ($data['view::View_Shop_Good\-brands-rubriki-brendov']->childs as $value){
				if($i == $n + 1){
					echo '</ul></div><div class="col-md-4"><ul class="box-menu-rubric">';
					$i = 1;
				}
				$i++;
				echo $value->str;
			}
			?>
			</ul>
	</div>		
</div>