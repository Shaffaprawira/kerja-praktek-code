<div class="container">

	<div class="row">
		<div class="col-md-8">			
			<h2 class="heading"><?php echo $title;?></h2>
			<!-- description issue -->
			<div class="row">
				<?php if(!empty($issue)){ foreach ($issue as $i){?>
					<div class="col-md-4">
						<a href="<?php echo site_url().'issue/'.$i['issue_id'];?>">
						<div class="list-group">
							<div class="list-group-item"><img class="img-responsive thumbnail" src="<?php echo $i['cover_image'] ? site_url().$i['cover_image']: site_url().'assets/front/img/cover-default.gif';?>"></div>
							<div class="list-group-item active">Vol <?php echo $i['volume'];?>, No <?php echo $i['issue_number'].' ('.$i['year'].')';?>  <?php if($i['special_issue']==1){echo 'SE'; } ?></div>
						</div>
						</a>
					</div>
				<?php }} ?>
			</div>

		</div>
		<?php $this->load->view('template/inc/sidebar');?>
	</div>

</div>
