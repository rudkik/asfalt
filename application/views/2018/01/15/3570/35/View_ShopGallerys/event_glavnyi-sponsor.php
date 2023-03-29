<?php if(count($data['view::View_ShopGallery\event_glavnyi-sponsor']->childs) > 0){ ?>
	<section class="tz-portfolio-wrapper">
		<h3>Главный спонсор:</h3>
		<div class="row">
			<?php 
			 foreach ($data['view::View_ShopGallery\event_glavnyi-sponsor']->childs as $value){
			echo $value->str;
			}
			?>
		</div>
	</section>
<?php } ?>
?>