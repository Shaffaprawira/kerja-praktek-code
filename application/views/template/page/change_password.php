<div class="content-wrapper">
	<section class="content-header">
		<h1>User <small> Credential</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/profile';?>">Profile</a></li>
			<li class="active">Change Password</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
		<form action="<?php echo base_url().'dashboard/update/password';?>" method="POST">
		<input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id');?>">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-key"></i> &nbsp; Change Password</h3>						
					</div>
					<div class="box-body">
						<div class="col-md-12">							
							<div class="form-group">
								<label>Username</label>
								<input type="text" name="user_id" class="form-control" value="<?php echo $this->session->userdata('user_id');?>" readonly>
							</div>
							<div class="form-group">
								<label>New Password<span>*</span></label>
								<input type="password" name="user_password" class="form-control" required>
							</div>				
							<div class="form-group">
								<label>Confirm Password<span>*</span></label>
								<input type="password" name="user_repassword" class="form-control" required>
							</div>
							<div class="form-action">
								<input type="reset" name="reset" class="btn btn-default" value="Batal">
								<input type="submit" name="submit" class="btn btn-warning" value="Change Password">
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		</div>
	</section>
</div>