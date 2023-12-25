<div class="container">

	<div class="row">
		<div class="col-md-8">
			<h2 class="heading"><i class="fa fa-bookmark"></i> <?php echo $title;?></h2>
			<div class="row">				
				<form class="" action="<?php echo site_url().'login/proc_register';?>" method="POST">
					<div class="col-md-12">
						<?php if($this->session->flashdata('success') !== NULL){?>
							<div class="alert alert-dismissible alert-success">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<h4>Success</h4>
								<p><?php echo $this->session->flashdata('success');?></p>
							</div>
						<?php } if($this->session->flashdata('warning') !== NULL){?>
							<div class="alert alert-dismissible alert-danger">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<h4>Warning</h4>
								<p><?php echo $this->session->flashdata('warning');?></p>
							</div>
						<?php } ?>
						<!--div>Please fill your data correctly. We will send you an activation link to your email. </div><hr/-->
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Salutation <span>*</span></label>
							<select name="salutation" class="form-control" required>
								<option value="">--None--</option>
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
						<div style="display: none">
							<input type="email" name="email"> <!-- si spam suka sangat sama field email ,,|,, -->
						</div>
						<div class="form-group" id="main-interest">
							<label>Section or field</label>
							<select name="section_id" class="form-control select">
								<option value="">- Select the closest section or field -</option>
								<?php if (!empty($section)){ foreach ($section as $s){ if ($s['section_abv'] !== 'E'){ ?>
									<option value="<?php echo $s['section_id'];?>"><?php echo $s['section_title'];?></option>
								<?php }}} ?>
							</select>							
						</div>
						<div class="form-group">
							<label>Affiliation</label>
							<input type="text" name="affiliation" class="form-control" placeholder="Affiliation">
						</div>
						<div class="form-group">
							<label>SCOPUS ID</label>
							<div class="small">Please fill the SCOPUS ID <i>( if available )</i>!</div>
							<input type="text" name="scopus" class="form-control" placeholder="Ex: 54975406000">
						</div>						
					</div>

					<div class="col-md-6">
						
						<div class="form-group">
							<label>Email <span>*</span></label>							
							<input type="email" name="email_gue" class="form-control" placeholder="Email" id="email" required>
							<div class="note-email" style="display:none"><i class="fa fa-warning"></i> Email has been used. Please use another one.</div>
						</div>
						<!--div class="form-group">
							<label>Username <span>*</span></label><div class="small">only lowercase letters, numbers, and hyphens/underscores</div>
							<input type="text" name="username" class="form-control" placeholder="Username" id="user_id" required>
							<div class="note-userid" style="display:none"><i class="fa fa-warning"></i> Username has been used. Please use another one.</div>
						</div-->
						<div class="form-group">
							<label>Password <span>*</span></label><div class="small">Must be at least 6 characters </div>
							<input type="password" name="password" class="form-control" placeholder="Password" required>
						</div>
						<div class="form-group">
							<label>Confirm Password <span>*</span></label>
							<input type="password" name="repassword" class="form-control" placeholder="Confirm Password" required>
						</div>						
						<div class="form-group">
							<div class="g-recaptcha" data-sitekey="6LfIyx4UAAAAAAEYl7CrnPtaeP6-Oa9xn5F5dZ9C"></div>
						</div>
						<hr/>
						<div class="form-action">
							<!-- <input type="reset" name="reset" class="btn btn-default" value="Batal"> -->
							<input type="submit" name="submit" class="btn btn-warning submit" value="Register">
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php $this->load->view('template/inc/sidebar');?>
	</div>
</div>