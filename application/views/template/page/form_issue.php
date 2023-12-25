<div class="content-wrapper">
	<section class="content-header">
		<h1><?php echo ucwords($title);?></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/issue';?>">Issue Management</a></li>
			<li class="active"><?php echo ucwords($title);?></li>
		</ol>
	</section>
	<?php 
		# data news
		if(!empty($item)){
			$id = $item[0]['issue_id'];
			$volume = $item[0]['volume'];
			$issue_number = $item[0]['issue_number'];
			$year = $item[0]['year'];
			$cover = $item[0]['cover_image'];
			$reviewers_list_file = $item[0]['reviewers_list_file'];
			$date = $item[0]['date_publish'];
			$special = $item[0]['special_issue'];
			$action = 'update';
		}else{
			$id = '';
			$volume = '';
			$issue_number = '';
			$year = '';
			$cover = '';
			$reviewers_list_file = '';
			$special = 0;
			$date = date('Y-m-d H:i:s');
			$action = 'insert';
		}
	?>
	<section class="content">
		<form action="<?php echo base_url().'dashboard/'.$action.'/issue';?>" method="POST" enctype="multipart/form-data" name="form1">
		<input type="hidden" name="issue_id" value="<?php echo $id;?>">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-book"></i> &nbsp;<?php echo $title ? $title : 'Create Issue';?></h3>
					</div>
					<div class="box-body">
						<div class="<?php echo $action == 'update' ? 'col-md-8':'col-md-8';?>">
							<div class="form-group">
								<label>Volume <span>*</span></label>
								<input type="number" min="1" name="volume" class="form-control" value='<?php echo $volume;?>' placeholder="Volume" required>
							</div>
							<div class="form-group">
								<label>Number <span>*</span></label>
								<input type="number" min="1" name="issue_number" class="form-control" value='<?php echo $issue_number;?>' placeholder="Number" required>
							</div>						
							<div class="form-group">
								<label>Year <span>*</span></label>
								<input type="number" min="1" name="year" class="form-control" value='<?php echo $year;?>' placeholder="Year" required>
							</div>
							<div class="form-group">
								<label>Date Published</label>
								<input type="text" name="date_publish" class="form-control datepicker" value='<?php echo $date;?>' placeholder="<?php echo $date;?>"><br><span style="color:red">If this is later than now, after clicking 'Save', please set Current Issue to the previous issue</span>
							</div>
							<!--div class="form-group">
								<label>Cover Image (max. 2 MB)</label>
								<input type="file" name="userfile" class="btn btn-sm btn-default" value="">
							</div-->
						</div>
						<?php if($action == 'update'){?>
							<div class="col-md-4" style="padding:50px; padding-top:0px; padding-bottom:0px">
								<!--img src="<?php echo $cover !== NULL? base_url().$cover : base_url().'uploads/default.jpg';?>" class="thumb img-responsive"-->
							</div>
						<?php }else{?>
							<div class="col-md-4" style="padding:50px; padding-top:0px; padding-bottom:0px">
								<div class="alert alert-default">
									<h4>Note:</h4>
									<p>
										Newly-added issue will be set automatically as Current Issue.
									</p>
								</div>
							</div>
						<?php } ?>
						<div class="col-md-12">
							<hr/>
							<div class="form-action">
								<input type="checkbox" name="special" value="1" <?php echo $special == 1 ? 'checked':'';?>> Check this if this is a special issue.<br><br>
								<input type="submit" name="submit" class="btn btn-primary" value="<?php echo $action == 'insert'? 'Save':'Update';?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
<?php if($action == 'update'){?>
		<form action="<?php echo base_url().'dashboard/update/issue_reviewers';?>" method="POST" enctype="multipart/form-data" name="form2"> <!--ruki25jan2019-->
		<input type="hidden" name="issue_id" value="<?php echo $id;?>">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-body">
						<div class="<?php echo $action == 'update' ? 'col-md-8':'col-md-8';?>">
							<div class="form-group">
								<label>List of reviewers</label> <!--ruki25jan2019-->
								<br>&nbsp;&nbsp;&nbsp; Existing file: <?php if($reviewers_list_file){ ?><a href="<?php echo base_url().$reviewers_list_file;?>">Download</a> (<a href="<?php echo base_url().'dashboard/delete/reviewers_list_file/'.$id;?>">Delete</a>)<?php }else{ echo 'none';}?><br>
								&nbsp;&nbsp;&nbsp; Upload new file (PDF, max. 2 MB): <input type="file" name="reviewers_list_file" class="btn btn-sm btn-default" value=""> <br><input type="submit" name="submit" class="btn btn-primary" value="Upload">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
<?php } ?>
	</section>
</div>