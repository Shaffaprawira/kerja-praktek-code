<div class="content-wrapper">
	<section class="content-header">
		<h1><?php echo ucwords($title);?></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/section';?>">Site Management</a></li>
			<li class="active"><?php echo ucwords($title);?></li>
		</ol>
	</section>
	<?php 
		if(!empty($item)){
			$id = $item[0]['id'];
			$title = $item[0]['title'];
			$abv = $item[0]['abv'];
			$status = $item[0]['status'];
			$action = 'update';
		}else{
			$id = '';
			$title = '';
			$abv = '';
			$status = '';
			$action = 'insert';
		}
	?>
	
	<section class="content">
		<div class="row">
			<form action="<?php echo base_url().'dashboard/'.$action.'/edition';?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<div class="col-md-8">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp;<?php echo $title ? $title : 'Create Edition';?></h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label>Title <span>*</span></label>
							<input type="text" name="title" class="form-control" value='<?php echo $title;?>' placeholder="Edition Title" required>
						</div>
						<div class="form-group">
							<label>Unique Abbreviation <span>*</span></label>
							<input type="text" name="abv" class="form-control" value='<?php echo $abv;?>' placeholder="Edition Abbreviation" required>
						</div>
						<div class="form-group">
							<label>Status</label>
							<select name="status" class="form-control">
								<option value="Active" <?php echo $status == 'Active' ? 'selected':'';?>>Active</option>
								<option value="Inactive" <?php echo $status == 'Inactive' ? 'selected':'';?>>Inactive</option>
							</select>
						</div>
						<hr/>
						<div class="form-action">
							<input type="submit" name="submit" class="btn btn-primary" value="<?php echo $action == 'insert'? 'Save':'Update';?>">
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</section>
	
</div>
