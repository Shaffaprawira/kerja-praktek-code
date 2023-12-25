<div class="container">

	<div class="row">
		<div class="col-md-8">
			<h2 class="heading"><i class="fa fa-lock"></i> <?php echo $this->uri->segment(1) == 'login' ? 'Login':'Reset Password';?></h2>
			<div class="row">				
				<div class="col-md-12">
					<?php echo $this->session->flashdata('invalid');?>
					<?php if($this->session->flashdata('message') !== NULL && $this->session->flashdata('message') !== ""){?>
					<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4>Message:</h4>
						<p><?php echo $this->session->flashdata('message');?></p>
					</div>
					<?php } ?>
				</div>
				<div class="col-md-6">
					<form action="<?php echo site_url().'login/auth';?>" method="POST">
						<div>Please enter your username and password to login. </div><hr/>
						<div class="form-group">
							<label>Username or Email </label>
							<input type="text" name="username" class="form-control" placeholder="Username or Email" required>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" placeholder="Password">
						</div>
						<div class="form-group">							
							<input type="submit" name="submit" class="btn btn-primary" value="Login">
						</div>					
					</form>
					<hr/>
					<form action="<?php echo site_url().'login/reset_password';?>" method="POST">
						<div class="alert alert-note">
							<h3>Forget Password <i class="fa fa-question-circle"></i></h3>
							<!--h5>Forgot your User ID and/or Password?</h5-->
							<p>Enter your e-mail address to reset your password. You will receive instructions and a temporary password via e-mail.</p>
							<div class="form-group">
								<label>Enter Your Email</label>
								<div class="input-group">
									<input type="email" name="email" class="form-control" placeholder="Email">
									<span class="input-group-btn">
										<button class="btn btn-primary"><i class="fa fa-envelope"></i></button>
									</span>
								</div>
							</div>
						</div>						
					</form>
				</div>
				<div class="col-md-6">
					<div class="alert alert-note">
						<h4>New user ? <a href="<?php echo site_url().'register';?>">Create an Account</a></h4>
						If you have authored or reviewed for IJTech in the past, you may already be registered. 
						Type your e-mail address into the Forgot Password? field at left to see if you have an account.
					</div>
					<h4>More information about :</h4>
					<ul>
						<li><a href="<?php echo site_url().'about/3/online-submission';?>">How to submit manuscript/Journal Article</a></li>
						<li><a href="<?php echo site_url().'about/10/policy';?>">Information for Reviewer</a></li>
						<li><a href="<?php echo site_url().'about/10/policy';?>">Ethical Guidelines & Plagiarism Screening</a></li>
						<li><a href="<?php echo site_url().'about/9/sponsorship';?>">Copyright/Journal Publishing Agreemet</a></li>
						<li><a href="<?php echo site_url().'about/9/sponsorship';?>">Permission & Credit Lines</a></li>
						<li><a href="<?php echo site_url().'about/6/open-access-policy';?>">Open Access Policy</a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php $this->load->view('template/inc/sidebar');?>
	</div>
</div>
