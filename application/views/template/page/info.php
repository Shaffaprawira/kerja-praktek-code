<div class="content-wrapper">
	<section class="content-header">
		<h1><?php echo ucwords($title);?></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/info';?>">Site Management</a></li>
			<li class="active"><?php echo ucwords($title);?></li>
		</ol>
	</section>
	<?php 
		if(empty($info_content)){
			$info_content="";
		}
	?>
	<section class="content">
		<form action="<?php echo base_url().'dashboard/update/info';?>" method="POST">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-body">
						<div class="form-group">
							<textarea name="info_content" class="form-control description summernote" rows="10" placeholder="Info Content" required><?php echo $info_content;?></textarea>
						</div>
						<hr/>
						<div class="form-action">
							<input type="submit" class="btn btn-primary" value="Update">
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</section>
</div>