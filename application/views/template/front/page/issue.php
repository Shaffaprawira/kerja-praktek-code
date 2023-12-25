<div class="container">

	<div class="row">
		<div class="col-md-8">			
			<h2 class="heading"><?php echo $title;?></h2>

			<!-- description issue -->
			<div class="row">
				<div class="col-md-6">
					<img class="img-responsive thumbnail" src="<?php echo $issue[0]['cover_image'] ? site_url().$issue[0]['cover_image']: site_url().'assets/front/img/cover-default.gif';?>">
				</div>
				<div class="col-md-6">
					<label><?php echo date('d M Y', strtotime($issue[0]['date_publish']));?></label>
					<p>Volume <?php echo $issue[0]['volume'];?>, Number <?php echo $issue[0]['issue_number'];?></p>
				</div>
			</div>
			<hr/>
			<?php if($issue[0]['reviewers_list_file']){ ?>
			<div class="row">
				<div class="col-md-2">
					<img class="img-responsive" alt="image" src="<?php echo site_url(); ?>assets/front/img/cover-mini.gif">
				</div>
				<div class="col-md-5">
					<h2 class="title"><a href="<?php echo site_url().$issue[0]['reviewers_list_file'];?>" target="_blank">Reviewer Acknowledgment</a></h2>
				</div>
				<div class="col-md-5 white">
					<div class="date">
						Publication Date (Online):<br><?php echo substr($issue[0]['date_publish'],-19,10);?><br>DOI: -<br>Pages : -</div>
				</div>
			</div>
			<hr/>
			<?php } ?>
			<?php if(!empty($submission)){ foreach($submission as $s){ ?>
			
			<div class="row">
				<div class="col-md-2">
					<img class="img-responsive" alt="Index terms: <?php echo $s['keywords'];?>" title="<?php echo $s['title'];?>" src="<?php echo $this->lib_view->preview_image($s['sub_id']);?>">
				</div>
				<div class="col-md-5">
					<h2 class="title"><a href="<?php echo site_url().'article/view/'.$s['sub_id'];?>"><?php echo $s['title'];?></a></h2>
					<p><?php echo $this->lib_view->author_submission($s['sub_id']);?></p>
				</div>
				<div class="col-md-5 white">
					<div class="date">
						Publication Date (Online):<br/><?php echo date('M d, Y', strtotime($s['date_publish']));?>
						<br/>DOI: <a href="<?php echo $s['doi_url'];?>"><?php echo $s['doi_url'];?></a><br/>
						<?php echo "Pages : ".$s['pages'];?>
					</div>
				</div>
			</div>
			<hr/>
			<?php }} ?>

			<!--a href="<?php echo site_url().'reviewer/'.$issue[0]['issue_id'];?>">
				<div class="btn btn-primary"> List of reviewers contributing in this issue</div>
			</a-->
		</div>
		<?php $this->load->view('template/inc/sidebar');?>
	</div>

</div>
