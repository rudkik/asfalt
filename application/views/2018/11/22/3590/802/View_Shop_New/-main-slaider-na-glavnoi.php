<div class="slider" style="background-image: url(<?php echo $data->values['image_path']; ?>)">
	<div class="col-md-5 box-title">
		<h2><?php echo $data->values['name']; ?></h2>
		<div class="line"></div>
		<p><?php echo $data->values['text']; ?></p>
		<div class="number">
			<span class="current">#index#</span>
			<span>/</span>
			<span class="all">#count#</span>
		</div>
	</div>
</div>