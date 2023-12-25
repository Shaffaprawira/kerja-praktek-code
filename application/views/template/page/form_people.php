<div class="content-wrapper">
	<section class="content-header">
		<h1><?php echo ucwords($title);?></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/people';?>">Site Management</a></li>
			<li class="active">Add People</li>
		</ol>
	</section>
	<?php 
		# data news
		if(!empty($item)){
			$id = $item[0]['pid'];
			$salutation = $item[0]['salutation'];
			$name = $item[0]['fullname'];
			$affiliation = $item[0]['affiliation'];
			$email = $item[0]['email'];
			
			$url = $item[0]['url'];
			$rgate = $item[0]['research_gate'];
			$gscholar = $item[0]['google_scholar'];
			$scopus = $item[0]['scopus'];
			
			$status = $item[0]['status'];
			$country = $item[0]['country'];
			$photo = $item[0]['photo'];
			$action = 'update';
		}else{
			$id = '';
			$salutation = '';
			$name = '';
			$affiliation = '';
			$email = '';

			$url = '';
			$rgate = '';
			$gscholar = '';
			$scopus = '';
			
			$status = '';
			$country = '';
			$photo = '';
			$action = 'insert';
		}
	?>
	<section class="content">
		<form action="<?php echo base_url().'dashboard/'.$action.'/people';?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="pid" value="<?php echo $id;?>">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-user"></i> &nbsp;<?php echo $title ? $title : 'Add People';?></h3>
					</div>
					<div class="box-body">
						<div class="<?php echo $action == 'update' ? 'col-md-8':'col-md-8';?>">
							<div class="form-group">
								<label>Status <span>*</span></label>
								<select name="status" class="form-control">
									<option value="1" <?php echo $status == 1 ? 'selected':'';?>>Editor in Chief</option>
									<option value="2" <?php echo $status == 2 ? 'selected':'';?>>Managing Editor</option>
									<option value="3" <?php echo $status == 3 ? 'selected':'';?>>Member</option>
								</select>
							</div>
							<div class="form-group">
								<label>Salutation <span>*</span></label>
								<select name="salutation" class="form-control">
									<option value="Dr." <?php echo $salutation == 'Dr.' ? 'selected':'';?>>Dr.</option>
									<option value="Prof." <?php echo $salutation == 'Prof.' ? 'selected':'';?>>Prof.</option>
									<option value="Prof. Dr." <?php echo $salutation == 'Prof. Dr.' ? 'selected':'';?>>Prof. Dr.</option>
								</select>
							</div>
							<div class="form-group">
								<label>Fullname <span>*</span></label>
								<input type="text" name="fullname" class="form-control" value='<?php echo $name;?>' placeholder="Fullname" required>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" name="email" class="form-control" value='<?php echo $email;?>' placeholder="Email">
							</div>
							<div class="form-group">
								<label>URL</label>
								<input type="url" name="url" class="form-control" value='<?php echo $url;?>' placeholder="URL">
							</div>
							<h3>Research ID</h3>
							<div class="form-group">
								<label>Research Gate</label>
								<input type="url" name="rgate" class="form-control" value='<?php echo $rgate;?>' placeholder="Research Gate">
							</div>
							<div class="form-group">
								<label>Google Scholar</label>
								<input type="url" name="gscholar" class="form-control" value='<?php echo $gscholar;?>' placeholder="Google Scholar">
							</div>
							<div class="form-group">
								<label>Scopus</label>
								<input type="url" name="scopus" class="form-control" value='<?php echo $scopus;?>' placeholder="Scopus">
							</div>
							<div class="form-group">
								<label>Affiliation/Institution <span>*</span></label>
								<textarea name="affiliation" class="form-control" required><?php echo $affiliation;?></textarea>
							</div>
							<div class="form-group">
								<label>Country <span>*</span></label>
								<select name="country" class="form-control select" required>
									<option value="">- Select Country -</option>
									<?php foreach ($countries as $c) {?>
										<option value="<?php echo $c['country_name'];?>" <?php echo $c['country_name'] == $country ? 'selected':'';?>><?php echo $c['country_name'];?></option>
									<?php } ?>
								</select>
							</div>							
							<div class="form-group">
								<label>Photo</label>
								<input type="file" name="userfile" class="btn btn-sm btn-default" value="">
							</div>							
						</div>
						<?php if($action == 'update'){?>
							<div class="col-md-4" style="padding:50px; padding-top:0px; padding-bottom:0px">
								<img src="<?php echo $photo !== NULL? base_url().$photo : base_url().'uploads/team/default.jpg';?>" class="thumb img-responsive">
							</div>
						<?php }else{?>
							<div class="col-md-4" style="padding:50px; padding-top:0px; padding-bottom:0px">
								
							</div>
						<?php } ?>
						<div class="col-md-12">
							<hr/>
							<div class="form-action">
								<input type="submit" name="submit" class="btn btn-primary" value="<?php echo $action == 'insert'? 'Save':'Update';?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</section>
</div>