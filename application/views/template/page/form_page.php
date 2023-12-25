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
		# data news
		if(!empty($item)){
			$id = $item[0]['page_id'];
			$title = $item[0]['page_title'];
			$content = $item[0]['page_content'];
			$action = 'update';
		}else{
			$id = '';
			$title = '';
			$content = '';
			$action = 'insert';
		}
	?>
	<section class="content">
		<form action="<?php echo base_url().'dashboard/'.$action.'/page';?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="page_id" value="<?php echo $id;?>">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp;<?php echo $title ? $title : 'Create New Page';?></h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label>Page Title <span>*</span></label>
							<input type="text" name="page_title" class="form-control" value='<?php echo $title;?>' placeholder="Page Title" required>
						</div>
						<div class="form-group">
							<label>Content <span>*</span></label>
							<textarea name="page_content" class="form-control summernote" placeholder="Content Page"><?php echo $content;?></textarea>
						</div>						
						<hr/>
						<div class="form-action">
							<input type="submit" name="submit" class="btn btn-primary" value="<?php echo $action == 'insert'? 'Save':'Update';?>">
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</section>
</div>