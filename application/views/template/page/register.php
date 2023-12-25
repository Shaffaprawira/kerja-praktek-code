<div class="content-wrapper">
	<section class="content-header">
		<h1>User <small>Registration</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/users';?>">Registered Users </a></li>
			<li class="active"><?php echo ucwords($title);?></li>
		</ol>
	</section>
	<section class="content">
		<form class="" action="<?php echo site_url().'dashboard/insert/user';?>" method="POST">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fa fa-user"></i> &nbsp;<?php echo $title ? $title : 'Register';?></h3>
						</div>
						<div class="box-body">
							<div class="col-md-12">
								<?php if($this->session->flashdata('warning') !== NULL){?>
									<div class="alert alert-dismissible alert-danger">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<h4><i class="fa fa-warning"></i> Warning</h4>
										<p><?php echo $this->session->flashdata('warning');?></p>
									</div>
								<?php } ?>
							</div>
							<div class="col-md-5">
								<div>Please fill data correctly. We will send an user account to registered email. </div><hr/>
								<div class="form-group">
									<label>Salutation <span>*</span></label>
									<select class="form-control" name="salutation" required>
										<option value="Prof.">Prof.</option>
										<option value="Dr.">Dr.</option>
										<option value="Mr.">Mr.</option>
										<option value="Mrs.">Mrs.</option>
										<option value="Ms.">Ms.</option>
									</select>
								</div>
								<div class="form-group">
									<label>First Name <span>*</span></label>
									<input type="text" name="first_name" class="form-control" placeholder="First Name" required>
								</div>								
								<div class="form-group">
									<label>Last Name</label>
									<input type="text" name="last_name" class="form-control" placeholder="Last Name">
								</div>
								<div class="form-group">
									<label>Register as :</label><br/>
									<select name="role_id[]" class="form-control">
										<option value="2">Secretariat</option>
										<option value="3">Editor</option>
										<option value="4" selected="selected">Section Editor</option>
										<option value="5">Author</option>
										<option value="6">Reviewer</option>
									</select>
								</div>
								<div class="form-group">
									<label>Section <span>*</span></label>
									<select name="section_id" class="form-control" required>
										<option value="">- Please select Section -</option>
										<?php foreach ($section as $sec){ 
											if ($sec['section_abv'] !== 'E'){ ?>
											<option value="<?php echo $sec['section_id'];?>"><?php echo $sec['section_title'];?></option>
										<?php }} ?>
									</select>
								</div>
								<div class="form-group">
									<label>Expertise (separated by comma)</label>
									<input type="text" name="expertise" class="form-control" placeholder="Expertise">
								</div>								
								<div class="form-group">
									<label>Phone</label>
									<input type="phone" name="phone" class="form-control" placeholder="Phone number">			
								</div>
								<div class="form-group">
									<label>Fax</label>
									<input type="text" name="fax" class="form-control" placeholder="Fax">
								</div>
								<div class="form-group">
									<label>Postal Address</label>
									<textarea name="postal_address" class="form-control" placeholder="Postal Address"></textarea>
								</div>
							</div>

							<div class="col-md-5">
								<br/><br/><br/>
								<div class="form-group">
									<label>Email <span>*</span></label>
									<input type="email" name="email" class="form-control" placeholder="Email" id="email" required>
									<div class="note-email text-danger" style="display:none"><i class="fa fa-warning"></i> Email has been used. Please use another one.</div>
								</div>
								<div class="form-group">
									<label>Username <span>*</span></label><br/><small>only lowercase letters, numbers, and hyphens/underscores</small>
									<input type="text" name="user_id" class="form-control" placeholder="Username" id="user_id" required>
									<div class="note-userid" style="display:none"><i class="fa fa-warning"></i> Username has been used. Please use another one.</div>
								</div>
								<div class="form-group">
									<label>Password <span>*</span></label><br/><small>Must be at least 6 characters </small>
									<input type="password" name="password" class="form-control" placeholder="Password" required>
								</div>
								<div class="form-group">
									<label>Confirm Password <span>*</span></label>
									<input type="password" name="repassword" class="form-control" placeholder="Confirm Password" required>
								</div>
								<hr/>
								<div class="form-action">
									<input type="reset" name="reset" class="btn btn-default" value="Batal">
									<input type="submit" name="submit" class="btn btn-warning submit" value="Register">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>