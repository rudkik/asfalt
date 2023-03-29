<?php if(count($data['view::View_ShopGallery\event_generalnyi-sponsor']->childs) > 0){ ?>
	<section class="tz-portfolio-wrapper">
		<h3>Генеральный спонсор:</h3>
		<div class="row">
			<?php 
			 foreach ($data['view::View_ShopGallery\event_generalnyi-sponsor']->childs as $value){
			echo $value->str;
			}
			?>
		</div>
	</section>
<?php } ?>