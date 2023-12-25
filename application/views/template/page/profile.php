<div class="content-wrapper">
	<section class="content-header">
		<h1>User <small> Profile</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/users';?>">User Management</a></li>
			<li class="active">Profile</li>
		</ol>
	</section>
	<?php if($this->uri->segment(2) == "edit"){?>
		<section class="content">
			<form action="<?php echo site_url().'dashboard/update/profile';?>" method="POST">
			<input type="hidden" name="user_id" value="<?php echo $user[0]['user_id'];?>">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-body">
							<div class="col-md-3">
              
                <!--img src="<?php echo set_image($user[0]['profile_image']);?>" class="img-responsive" data-toggle="modal" data-target="#modalProfile" style="cursor:pointer; margin:auto">
                <i class='fa fa-user'  class="img-responsive" data-toggle="modal" data-target="#modalProfile" style="cursor:pointer; margin:auto"></i>
								<hr/-->
                
								<div style="text-align:center">
									<label>Registered</label><br/>
									<?php echo date('d/m/Y H:i', strtotime($user[0]['date_create']));?><br/>
									<label>Last Login</label><br/>
									<?php echo date('d/m/Y H:i', strtotime($user[0]['last_login']));?>
								</div><hr/>

								<div class="btn-group btn-block" style="text-align:center;">
								  <a href="<?php echo site_url().'dashboard/edit/profile/'.md5($user[0]['user_id']);?>" type="button" class="btn btn-primary btn-block"><i class="fa fa-edit"></i> Edit Profile</a>
								</div>								
							</div>
							<div class="col-md-5">
								<h4>USER IDENTITY</h4><hr/>
								<div class="form-group">
									<label>Salutation <span>*</span></label>
									<select name="salutation" class="form-control">
										<option value="Prof." <?php echo $user[0]['salutation'] == 'Prof.' ? 'selected':'';?>>Prof.</option>
										<option value="Dr." <?php echo $user[0]['salutation'] == 'Dr.' ? 'selected':'';?>>Dr.</option>
										<option value="Mr." <?php echo $user[0]['salutation'] == 'Mr.' ? 'selected':'';?>>Mr.</option>
										<option value="Mrs." <?php echo $user[0]['salutation'] == 'Mrs.' ? 'selected':'';?>>Mrs.</option>
										<option value="Ms." <?php echo $user[0]['salutation'] == 'Ms.' ? 'selected':'';?>>Ms.</option>
									</select>
								</div>
								<div class="form-group">
									<label>First Name <span>*</span></label>
									<input type="text" name="first_name" class="form-control" value="<?php echo $user[0]['first_name'];?>">
								</div>
								<div class="form-group">
									<label>Last Name</label>
									<input type="text" name="last_name" class="form-control" value="<?php echo $user[0]['last_name'];?>">
								</div>
								<div class="form-group">
									<label>Department <span>*</span></label>
									<select name="section_id" class="form-control" required>
										<option value="">- Select Department -</option>
										<?php if(!empty($section)){ foreach ($section as $s){
											if($s['section_abv'] !== 'E'){?>
											<option value="<?php echo $s['section_id'];?>" <?php echo $s['section_id'] == $user[0]['section_id'] ? 'selected':'';?>><?php echo $s['section_title'];?></option>
										<?php }}} ?>
									</select>
								</div>
								<div class="form-group">
									<label>Expertise</label><div class="note">Please separate expertise with a comma</div>
									<textarea name="expertise" class="form-control" placeholder="Expertise"><?php echo $user[0]['expertise'];?></textarea>
								</div>
								<div class="form-group">
									<label>Phone</label>
									<input type="phone" name="phone" class="form-control" value="<?php echo $user[0]['phone'];?>" placeholder="Phone number">
								</div>
								<div class="form-group">
									<label>Postal Address</label>
									<textarea name="postal_address" class="form-control" placeholder="Postal Address"><?php echo $user[0]['postal_address'];?></textarea>
								</div>
								<div class="form-group">
									<label>Fax</label>
									<input type="text" name="fax" class="form-control" value="<?php echo $user[0]['fax'];?>" placeholder="Fax number">
								</div>
								<div class="form-group">
									<label>Country</label>
									<select name="country" class="form-control">
										<?php foreach ($countries as $c){?>
											<option value="<?php echo $c['country_name'];?>" <?php echo $c['country_name'] == $user[0]['country'] ? 'selected':'';?>><?php echo $c['country_name'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="col-md-4">
								<h4>USER ACCOUNT</h4><hr/>
								<div class="form-group">
									<label>Username <span>*</span></label>
									<input type="text" name="user_id" class="form-control" value="<?php echo $user[0]['user_id'];?>" readonly>
								</div>
								<div class="form-group">
									<label>Primary Email <span>*</span></label>
									<input type="text" name="email" class="form-control" value="<?php echo $user[0]['email'];?>" <?php echo in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role')) ? '':'readonly';?>>
								</div>
								<div class="form-group">
									<label>Secondary Email</label>
									<input type="text" name="email2" class="form-control" value="<?php echo $user[0]['email2'];?>" placeholder="Secondary Email Address">
								</div>
								<div class="form-group">
									<label>Short Biography</label>
									<textarea name="short_biography" class="form-control" placeholder="(E.g., department and rank)"><?php echo $user[0]['short_biography'];?></textarea>
								</div>
								<HR>
								<h4>AFFILIATION/INSTITUTION</h4>
								<hr/>
								<div class="form-group">
									<label>Scopus ID</label>
									<input type="text" name="scopus_id" class="form-control" value="<?php echo $user[0]['scopus_id'];?>" placeholder="Ex:55059996600">
								</div>
								<div class="form-group">
									<label>Primary Affiliation/Institution <span>*</span></label>
									<textarea name="affiliation" class="form-control" placeholder="Department, Institution, City and Country" required><?php echo $user[0]['affiliation'];?></textarea>
								</div>
								<div class="form-group">
									<label>Secondary Affiliation/Institution</label>
									<textarea name="affiliation2" class="form-control" placeholder="Department, Institution, City and Country"><?php echo $user[0]['affiliation2'];?></textarea>
								</div>								
								<div class="form-group">
									<input type="submit" name="submit" class="btn btn-primary" value="Update Profile">
								</div>
							</div>							
						</div>
					</div>
				</div>
			</form>
			</div>
		</section>
	<?php }else{?>


		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-body">
							<div class="col-md-3">
								<!-- <?php echo set_image($user[0]['profile_image']);?> -->
								<!--img src="<?php echo set_image($user[0]['profile_image']);?>" class="img-responsive" data-toggle="modal" data-target="#modalProfile" style="cursor:pointer; margin:auto"-->
								<hr/>
								<div style="text-align:center">
									<label>Registered</label><br/>
									<?php echo date('d/m/Y H:i', strtotime($user[0]['date_create']));?><br/>
									<label>Last Login</label><br/>
									<?php echo date('d/m/Y H:i', strtotime($user[0]['last_login']));?>
								</div><hr/>
								<div class="btn-group btn-block" style="text-align:center">
								  <a href="<?php echo site_url().'dashboard/edit/profile/'.md5($user[0]['user_id']);?>" type="button" class="btn btn-primary btn-block"><i class="fa fa-edit"></i> Edit Profile</a>
								</div>
							</div>
							<div class="col-md-5">
								<table class="table">
									<tr><td colspan="2" style="background:#EEE; font-size:1.2em">USER IDENTITY</td></tr>
									<tr>
										<th width="120">Salutation</th>
										<td>: <?php echo $user[0]['salutation'];?></td>
									</tr>
									<tr>
										<th>First Name</th>
										<td>: <?php echo $user[0]['first_name'];?></td>
									</tr>
									<tr>
										<th>Last Name</th>
										<td>: <?php echo $user[0]['last_name'];?></td>
									</tr>
									<tr>
										<th>Department</th>
										<td>: <?php echo $user[0]['section_title'];?></td>
									</tr>
									<tr>
										<th>Expertise</th>
										<td>: <?php echo $user[0]['expertise'];?></td>
									</tr>
									<tr>
										<th>Phone</th>
										<td><?php echo $user[0]['phone'] !== '' ? $user[0]['phone']:'---';?></td>
									</tr>
									<tr>
										<th>Fax</th>
										<td><?php echo $user[0]['fax'] !== '' ? $user[0]['fax']:'---';?></td>
									</tr>
									<tr>
										<th>Postal Address</th>
										<td><?php echo $user[0]['postal_address'] !== ''? $user[0]['postal_address']:'---';?></td>
									</tr>
									<tr>
										<th>Country</th>
										<td><?php echo $user[0]['country'] == ''? 'Indonesia':$user[0]['country'];?></td>
									</tr>
									<tr>
										<th>Short Biography</th>
										<td><?php echo $user[0]['short_biography'];?></td>
									</tr>
								</table>
							</div>
							
							<div class="col-md-4">
								<table class="table">
									<tr><td colspan="2" style="background:#EEE; font-size:1.2em">USER ACCOUNT</td></tr>
									<tr>
										<th>Username</th>
										<td><?php echo $user[0]['user_id'];?></td>
									</tr>
									<tr>
										<th>Primary Email</th>
										<td><?php echo $user[0]['email'];?></td>
									</tr>
									<tr>
										<th>Secondary Email</th>
										<td><?php echo $user[0]['email2'];?></td>
									</tr>
									<tr>
										<th>Role</th>
										<td>
											<?php 											
											foreach($user_role as $ur){ 
												echo "<i class='fa fa-arrow-circle-right'></i> ".$ur['role_name']."<br/>";
											} ?>
										</td>
									</tr>
									<tr>
										<th>Status</th>
										<td><?php echo $user[0]['status'] == 1 ? '<span class="badge label-success">Active</span>':'<span class="badge label-default">Inactive</span>';?></td>
									</tr>
								</table>

								<table class="table">
									<tr><td style="background:#EEE; font-size:1.2em">AFFILIATION/INSTITUTION</td></tr>
									<tr><th>Scopus ID</th></tr>
									<tr><td>
										<?php if($user[0]['scopus_id'] !== ""){?>
										<a href="https://www.scopus.com/authid/detail.uri?authorId=<?php echo $user[0]['scopus_id'];?>" target="_blank">https://www.scopus.com/authid/detail.uri?authorId=<?php echo $user[0]['scopus_id'];?></a>
										<?php }else{ echo ' - ';} ?>
									</td></tr>
									<tr><th>Primary Affiliation/Institution</th></tr>
									<tr><td><?php echo $user[0]['affiliation'];?></td></tr>
									<tr><th>Secondary Affiliation/Institution</th></tr>
									<tr><td><?php echo $user[0]['affiliation2'];?></td></tr>
								</table>
							</div>							
						</div>
					</div>
				</div>
			</form>
			</div>
		</section>


	<?php } ?>
</div>