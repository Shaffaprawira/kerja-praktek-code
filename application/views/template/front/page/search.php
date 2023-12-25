<div class="container">

	<div class="row">
		<div class="col-md-8">			
			<h2 class="heading"><?php echo $title;?></h2>
			<!-- description issue -->
			<?php if(!empty($result)){ foreach($result as $s){?>
				<div class="row">
					<div class="col-md-2">
						<img class="img-responsive" alt="image" src="<?php echo $this->lib_view->preview_image($s['sub_id']);?>">
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
			<?php echo $paging; ?>
		</div>
		<?php $this->load->view('template/inc/sidebar');?>
	</div>

</div>
