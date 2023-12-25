<!-- i need get screen width -->
<script type="text/javascript">
	var x = window.screen.width;
	var y = window.screen.height;	
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1 id="author">Journal Detail</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/submission';?>">Journal</a></li>
			<li class="active"><?php echo strlen($title) > 50 ? ucwords(substr($title, 0 ,50)).'...': ucwords($title);?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp; Detail Submission <?php echo $sub[0]['round'] > 1 ? '<span class="badge alert-danger">R'.($sub[0]['round']-1).'</span>':'';?></h3>
					</div>
					<div class="box-body">
						<div class="col-md-8">
							<div class="form-group" id="author">
								<?php echo $sub[0]['date_publish'];?>
								<h3><?php echo $sub[0]['sub_title'];?></h3>
							</div>
							<div class="form-group">
								<div class="section-title" id="abstract">Abstract</div>
								<p class="justify"><?php echo $sub[0]['abstract'];?></p>							
								<div>Keywords</div>
								<p class="justify"><?php echo $sub[0]['keywords'];?></p>
							</div>

							<div class="form-group">
								<div class="section-title" id="introduction">Introduction</div>
								<p><?php echo $sub[0]['introduction'];?></p>
							</div>
							<div class="form-group">
								<div class="section-title" id="experimental">Experimental Method</div>
								<p><?php echo $sub[0]['experimental_method'];?></p>
							</div>
							<div class="form-group">
								<div class="section-title" id="result">Results and Discussion</div>
								<p><?php echo $sub[0]['result'];?></p>
							</div>
							<div class="form-group">
								<div class="section-title" id="conclusion">Conclusion</div>
								<p><?php echo $sub[0]['conclusion'];?></p>
							</div>
							<div class="form-group">
								<div class="section-title" id="acknowledgement">Acknowledgement</div>
								<p><?php echo $sub[0]['acknowledgement'];?></p>
							</div>

							<div class="form-group">
								<div class="section-title" id="references">References</div>
								<p><?php echo $sub[0]['sub_references'];?></p>
							</div>							

						</div>
						<div class="col-md-4 hidden-xs hidden-sm sidebar-content">
							<div class="list-group">
								<div class="list-group-item active">Navigation</div>
								<div class="list-group-item"><a href="#author">Article</a></div>
								<div class="list-group-item"><a href="#abstract">Abstract</a></div>
								<div class="list-group-item"><a href="#introduction">Introduction</a></div>
								<div class="list-group-item"><a href="#experimental">Experimental</a></div>
								<div class="list-group-item"><a href="#result">Results and Discussion</a></div>
								<div class="list-group-item"><a href="#conclusion">Conclusion</a></div>
								<div class="list-group-item"><a href="#acknowledgement">Acknowledgement</a></div>
								<div class="list-group-item"><a href="#references">References</a></div>								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		
	</section>
</div>
