<div class="content-wrapper">
	<section class="content-header"><h1><?=$title?></h1></section>
	<section class="content usetooltip">
		<div class="box box-primary">
			<div class="box-body">
				<?php
				if(isset($beforeGC)){echo $beforeGC;}
				if(isset($replaceGC)){echo $replaceGC;}else{echo $output->output; }
				if(isset($afterGC)){echo $afterGC;}
				?>
			</div>
		</div>
	</section>
</div>
