<?php if(count($data['view::View_ShopGallery\event_premium-sponsor']->childs) > 0){ ?>
	<section class="tz-portfolio-wrapper">
		<h3>Премиум спонсор:</h3>
		<div class="row">
			<?php 
			 foreach ($data['view::View_ShopGallery\event_premium-sponsor']->childs as $value){
			echo $value->str;
			}
			?>
		</div>
	</section>
<?php } ?>