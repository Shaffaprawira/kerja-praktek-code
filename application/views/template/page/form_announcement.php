<div class="content-wrapper">
	<section class="content-header">
		<h1><?php echo ucwords($title);?></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/announcement';?>">Site Management</a></li>
			<li class="active"><?php echo ucwords($title);?></li>
		</ol>
	</section>
	<?php 
		# data news
		if(!empty($ann)){
			$id = $ann[0]['ann_id'];
			$title = $ann[0]['ann_title'];
			$description = $ann[0]['ann_description'];
			$expired = $ann[0]['expire_date'];			
			$date_input = $ann[0]['date_input'];			
			$issue_id = $ann[0]['issue_id']; //ruki
			$action = 'update';
		}else{
			$id = '';
			$title = '';
			$description = '';
			$expired = '';
			$date_input = '';
			$issue_id = '';  //ruki
			$action = 'insert';
		}
	?>
	<section class="content">
		<form action="<?php echo base_url().'dashboard/'.$action.'/announcement';?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="ann_id" value="<?php echo $id;?>">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp;<?php echo $title ? $title : 'Create Announcement';?></h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label>Title <span>*</span></label>
							<input type="text" name="ann_title" class="form-control" value='<?php echo $title;?>' placeholder="Announcement Title" required>
						</div>
						<div class="form-group">
							<label>Description <span>*</span></label>
							<textarea name="ann_description" class="form-control description summernote" placeholder="Announcement Content" required><?php echo $description;?></textarea>
						</div>
						<div class="form-group">
							<label>Issue</label>
              <select name="issue_id" class="form-control select" id="issue">
                <option value="">- Please select an Issue -</option>
                <?php if(!empty($issue)){ foreach($issue as $i){?>
                <option value="<?php echo $i['issue_id'];?>" <?php echo $i['issue_id'] == (isset($issue_id) ? $issue_id : '') ? 'selected':'';?>><?php echo 'Vol '.$i['volume'].', No '.$i['issue_number'].' ('.$i['year'].')';?></option>
                <?php }} ?>
              </select>
						</div>
						<div class="form-group">
							<label>Date</label>
							<input type="text" name="date_input" class="form-control datepicker" value="<?php echo $date_input !== '0000-00-00 00:00:00'? $date_input:'';?>" placeholder="<?php echo date('Y-m-d');?>">
						</div>
						<div class="form-group">
							<label>Expired Date</label>
							<input type="text" name="expire_date" class="form-control datepicker" value="<?php echo $expired !== '0000-00-00 00:00:00'? $expired:'';?>" placeholder="No expired date">
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