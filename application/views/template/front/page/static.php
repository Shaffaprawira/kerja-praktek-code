<div class="container">
	<div class="row">
		<div class="col-md-8">
			<?php if(!empty($content)){?>
				<!-- h3 class="heading"><?php echo $content[0]['page_title'];?></h3 -->
				<?php echo $content[0]['page_content'];?>
			<?php }else{ echo ucwords($param); } ?>
		</div>
		<?php $this->load->view('template/inc/sidebar');?>
	</div>
</div>