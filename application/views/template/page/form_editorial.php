<div class="content-wrapper">
	<section class="content-header">
		<h1>Article <small>Quick Submit</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/submission';?>">Submission</a></li>
			<li class="active"><?php echo ucwords($title);?></li>
		</ol>
	</section>
	<section class="content">		
		<div class="row">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp;<?php echo $title ? $title : 'Create New Article';?></h3>
					</div>
					<div class="box-body">
						<div class="col-md-3">
							<div class="list-group">
								<a href="<?php echo $this->uri->segment(4) == null ? site_url().'dashboard/create/editorial' : site_url().'dashboard/edit/editorial/'.$this->uri->segment(4);?>" class="list-group-item <?php echo $this->uri->segment(3) == 'editorial'?'active':'';?>">
									<h5 class="list-group-item-heading">
										<?php echo $this->uri->segment(4) !== null ? $this->lib_view->check_input($this->uri->segment(4), "meta"):'';?> 
										Step 1
									</h5>
									<p class="list-group-item-text">Section, Title, and Abstract <i class="fa fa-angle-right pull-right"></i></p>
								</a>
								<a href="<?php echo site_url().'dashboard/create/suplement/'.$this->uri->segment(4);?>" class="list-group-item <?php echo $this->uri->segment(3) == 'suplement'?'active':'';?>">
									<h5 class="list-group-item-heading">
										<?php echo $this->uri->segment(4) !== null ? $this->lib_view->check_input($this->uri->segment(4), "file"):'';?>
										Step 2
									</h5>
									<p class="list-group-item-text">Upload Files <i class="fa fa-angle-right pull-right"></i></p>
								</a>
								<a href="<?php echo site_url().'dashboard/create/agreement/'.$this->uri->segment(4);?>" class="list-group-item <?php echo $this->uri->segment(3) == 'agreement'?'active':'';?>">
									<h5 class="list-group-item-heading">
										<?php echo $this->uri->segment(4) !== null ? $this->lib_view->check_input($this->uri->segment(4), "submit"):'';?>
										Step 3
									</h5>
									<p class="list-group-item-text">Review and Submit <i class="fa fa-angle-right pull-right"></i></p>
								</a>
							</div>
						</div>
						<div class="col-md-9" style="border-left:solid 1px #DDD">							

							<?php if($this->uri->segment(3) == 'editorial'){ ?>

								<h2>Step 1: Section, Title, Abstract, Keywords and References</h2>
								<div class="callout callout-default">Authors are asked to review the Information for Authors, and to adhere to these <a href="<?php echo site_url().'about/4/author-guidelines';?>" style="color:#337ab7" target="_blank">guidelines</a> when submitting manuscripts.</div>

								<form method="POST" action="<?php echo $this->uri->segment(4) == "" ? site_url().'dashboard/insert/submission' : site_url().'dashboard/update/editorial';?>">
									<input type="hidden" name="sub_id" value="<?php echo isset($sub[0]['sub_id']) ? $sub[0]['sub_id']:'';?>">
									<input type="hidden" name="issue_id" value="<?php echo $this->session->userdata('issue_id');?>">
									<div class="form-group">
										<label>Issue <span>*</span></label>
										
										<select name="issue_id" class="form-control select" id="issue" required>
											<option value="">- Please select an Issue -</option>
											<?php if(!empty($issue)){ foreach($issue as $i){?>
											<option value="<?php echo $i['issue_id'];?>" <?php echo $i['issue_id'] == (isset($sub[0]['issue_id']) ? $sub[0]['issue_id'] : '') ? 'selected':'';?>><?php echo 'Vol '.$i['volume'].', No '.$i['issue_number'].' ('.$i['year'].')';?></option>
											<?php }} ?>
										</select>
									
									</div>	
									<div class="form-group">
										<label>Section <span>*</span></label>
										<select class="form-control select" name="section_id" required>
											<option value="">- Select Section -</option>
											<?php if(!empty($section)){ foreach ($section as $sec){?>
												<option value="<?php echo $sec['section_id'];?>" <?php echo $sec['section_abv'] == 'E' ? 'selected':'';?>><?php echo $sec['section_title'];?></option>
											<?php }} ?>
										</select>
									</div>								
									<div class="form-group">
										<label>Title <span>*</span></label>
										<textarea name="sub_title" class="form-control" placeholder="Title" rows="3" required><?php echo isset($sub[0]['sub_title']) ? $sub[0]['sub_title']:'';?></textarea>
									</div>								
									<div class="form-group">
										<label>Abstract <span>*</span></label>
										<textarea name="abstract" class="form-control summernote" rows="10" placeholder="Abstract"><?php echo isset($sub[0]['abstract']) ? $sub[0]['abstract'] : '';?></textarea>
									</div>
									<div class="form-group">
										<label>Keywords <span>*</span></label><div class="note">separate each keyword with comma, e.g. "routing, network"</div>
										<input type="text" name="keywords" class="form-control" placeholder="Keywords" value="<?php echo isset($sub[0]['keywords']) ? $sub[0]['keywords']:'';?>">
									</div>								
									<div class="form-group">
										<label>References <span>*</span></label><div class="note">separate individual references with a blank line</div>
										<textarea name="sub_references" class="form-control summernote" rows="10" placeholder="Separate with blank line" required><?php echo isset($sub[0]['sub_references']) ? $sub[0]['sub_references'] : '';?></textarea>
									</div>
									<hr/>
									<div class="form-action pull-right">
										<input type="submit" name="submit" class="btn btn-default" value="Save">
										<button type="submit" name="submit" class="btn btn-warning submit">Save and Contrinue <i class="fa fa-arrow-circle-right"></i></button>
									</div>
								</form>

							<!-- UPLOAD FILES -->

							<?php }else if ($this->uri->segment(3) == 'suplement'){?>
								<h2>Step 5: File Upload</h2>
								<div class="callout callout-default">
									<p>Please upload all required files for your Manuscript Submission, plus Supporting Information and Review-Only material.</p>
									<p>Required Documents for Manuscript Submission <span class="badge alert-danger">Important!</span></p>
									<ul>
									    <li>Graphical Abstract <i class="small">(Only file with JPG, JPEG, PNG or GIF are accepted)</i> <span class="text-danger">*</span> Required</li>
									    <li>Manuscript File <i class="small">(Only file with DOC or DOCX are accepted)</i> <span class="text-danger">*</span> Required</li>
									    <li>Manuscript File - PDF <span class="text-danger">*</span> Required</li>
									    <li>All Graphics <i class="small">(Only file with JPG, JPEG, PNG or GIF are accepted)</i></li>
									</ul>
									<p>
									<b>Requirements for Revised Manuscripts</b><br/>
									Please upload <i>Response Letter</i> to be sent to related reviewer(s) in PDF format.<span class="text-danger">* </span>Required</p>
								</div>
								<hr/>
								<h4 class="heading"><i class="fa fa-paperclip"></i> Uploaded Files</h4>
								<table class="table table-striped">
									<tr>
										<th>Files</th>
										<th>Type</th>
										<th>Date</th>
										<th width="100">Action</th>
									</tr>
									<?php if(!empty($suplement)){ foreach ($suplement as $s){ if($s['type'] != 5){?>
									<tr>
										<td>
											<?php $f = explode('/', $s['file_url']) ;?>
											<div><a href="<?php echo site_url().$s['file_url'];?>"><?php echo $f[count($f)-1];?></a> </div>
											<div><?php echo $s['file_description'];?></div>
										</td>
										<td><?php echo manuscript_type($s['type']);?></td>
										<td><?php echo date('d M Y - H:i', strtotime($s['date_input']));?></td>
										<td>
											<a data-tooltip="tooltip" title="Delete file" href="#" data-toggle="modal" data-target="#modalDeleteFile" onclick="return prepare_delete_file('<?php echo $s['sf_id'];?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
										</td>
									</tr>										
									<?php }}}else{
										echo "<tr><td colspan='2' class='text-warning'><i class='fa fa-warning'></i> No files uploaded.</td></tr>";
									} ?>
								</table>
								<hr/>
								<form method="POST" action="<?php echo site_url().'dashboard/insert/suplement';?>" enctype="multipart/form-data">
									<input type="hidden" name="round" value="<?php echo $sub[0]['round'];?>">
									<h4 class="heading"><i class="fa fa-cloud-upload"></i> Upload Files</h4>
									<input type="hidden" name="sub_id" value="<?php echo $this->uri->segment(4);?>">
									<?php if (!empty($this->session->userdata('invalid'))){?>
									<div class="callout callout-warning">
										<?php echo $this->session->userdata('invalid');?>
									</div>
									<?php } ?>
									<div class="form-group">
										<label>File <span>*</span></label>
										<div class="input-group">
											<div class="input-group-btn">
												<input type="file" name="userfile" class="btn btn-default btn-sm" required>
											</div>
											<select name="type" class="form-control" style="height: 39px" required>
												<option value="">- Select Type File upload -</option>
												<?php if($sub[0]['round'] == 1){?>
													<option value="1">Manuscript File - DOC/DOCX *</option>
													<option value="2">Manuscript File - PDF *</option>
												<?php }else{?>
													<option value="1">Manuscript File - DOC/DOCX (for publication without highlights) *</option>
													<option value="2">Manuscript File - PDF (for review with highlights) *</option>
												<?php } ?>
												<option value="0">Graphical Abstract - Image Graphic *</option>
												<option value="3">Supplementary File - DOC/DOCX/PDF/JPG/PNG/TIFF</option>
												<?php if($sub[0]['round'] > 1){?>
													<option value="4">Response Letter *</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label>Description </label>
										<textarea name="file_description" class="form-control" placeholder="File description"></textarea>
									</div>
									<div class="form-action">
										<input type="reset" name="reset" class="btn btn-default" value="Cancel">
										<input type="submit" name="submit" class="btn btn-primary submit" value="Upload">
									</div>
								</form>
								<hr/>
								<div>
									<span class="pull-left">
										<a href="<?php echo site_url().'dashboard/edit/detail/'.$this->uri->segment(4);?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Previous Step</a>
									</span>
									<span class="pull-right">
										<a href="<?php echo current_url();?>" class="btn btn-default">Save</a>
										<a href="<?php echo site_url().'dashboard/create/agreement/'.$this->uri->segment(4);?>" class="btn btn-warning">Save and Continue <i class="fa fa-arrow-circle-right"></i></a>
									</span>
								</div>
							<!-- AUTHORS -->

							<?php }else if ($this->uri->segment(3) == 'author'){?>

								<h2>Step 2: Authors & Institutions</h2>
								<div class="callout callout-default">
									<p><b>Co-Authors:</b> You must provide contact information for all co-authors. Then use the Order dropdown list beside each author's name to match the order in which they are listed on the manuscript.</p>
									<p> <b>Submitting Agent: </b>If you are submitting this manuscript for someone else, you must enter the Contact Author's information. </p>
								</div>
								<h4 class="well"><i class="fa fa-mortar-board"></i> Add Author</h4>
								<hr/>
								<div class="form-group">
									<label>Find using Author's email address</label>
									<div class="input-group">
										<input type="search" class="form-control" name="search_author" placeholder="Find author using email address" id="authors">
										<input type="hidden" id="sub_id_author" value="<?php echo $this->uri->segment(4);?>">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-warning">Search</button>
										</span>
									</div>
								</div>
								<div class="callout callout-defaut search-msg text-danger" style="display: none"><i class="fa fa-warning"></i> Author not found.</div>
								<form class="selected-author" action="<?php echo site_url().'dashboard/insert/selected_author';?>" method="POST" style="display: none">
									<input type="hidden" name="sub_id" value="<?php echo $this->uri->segment(4);?>">
									<input type="hidden" name="page" value="<?php echo current_url();?>">
									<input type="hidden" name="user_id" id="user_id">
									<div class="form-group">
										<table class="table table-bordered table-striped">
											<tr>
												<th>Name</th>
												<th>Email</th>
												<th>Affiliation/Institution</th>
												<th></th>
											</tr>
											<tr>
												<td class="name"></td>
												<td class="email"></td>
												<td class="affiliation"></td>
												<td><input type="submit" class="btn btn-primary" value="Set as author"></td>
											</tr>
										</table>
									</div>
								</form>

								<h2 class="hrtext"><span> OR </span></h2>
								<form method="POST" action="<?php echo $action == 'edit' ? site_url().'dashboard/update/author' : site_url().'dashboard/insert/author';?>">
									<input type="hidden" name="sub_id" value="<?php echo $this->uri->segment(4);?>">
									<input type="hidden" name="sa_id" value="<?php echo $this->uri->segment(5);?>">
								
									<div class="row">
										<div class="col-md-7">
											<div class="form-group">
												<label>Salutation <span>*</span></label>
												<select name="salutation" class="form-control" required>
													<option value="">- Select Salutation -</option>
													<option value="Prof." <?php echo isset($ca[0]['salutation']) && $ca[0]['salutation'] == "Prof." ? 'selected':'';?>>Prof.</option>
													<option value="Dr." <?php echo isset($ca[0]['salutation']) && $ca[0]['salutation'] == "Dr." ? 'selected':'';?>>Dr.</option>
													<option value="Mr." <?php echo isset($ca[0]['salutation']) && $ca[0]['salutation'] == "Mr." ? 'selected':'';?>>Mr.</option>
													<option value="Mrs." <?php echo isset($ca[0]['salutation']) && $ca[0]['salutation'] == "Mrs." ? 'selected':'';?>>Mrs.</option>
													<option value="Ms." <?php echo isset($ca[0]['salutation']) && $ca[0]['salutation'] == "Ms." ? 'selected':'';?>>Ms.</option>
												</select>
											</div>
											<div class="form-group">
												<label>First Name <span>*</span></label>
												<input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php echo isset($ca[0]['first_name']) ? $ca[0]['first_name']:'';?>" required>
											</div>
											<div class="form-group">
												<label>Last Name <span>*</span></label>
												<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo isset($ca[0]['last_name']) ? $ca[0]['last_name']:'';?>" required>
											</div>
											<div class="form-group">
												<label>Email <span>*</span></label>
												<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo isset($ca[0]['email']) ? $ca[0]['email']:'';?>" required>
											</div>
											<div class="form-group">
												<label>Country <span>*</span></label>
												<select name="country" class="form-control select" required>
													<option value="">- Select Country</option>
													<?php if(!empty($countries)){ foreach ($countries as $c){?>														
														<option value="<?php echo $c['country_name'];?>" <?php echo isset($ca[0]['country']) && $ca[0]['country'] == $c['country_name'] ? 'selected':'';?> ><?php echo $c['country_name'];?></option>
													<?php }} ?>
												</select>
											</div>
										</div>

										<div class="col-md-5">
											<div class="form-group">
												<label>Affiliation/Institution <span>*</span></label>
												<textarea name="affiliation" class="form-control affiliation-form" placeholder="Affiliation / Institution" required><?php echo isset($ca[0]['affiliation']) ? $ca[0]['affiliation']:'';?></textarea>
											</div>											
											<div class="form-group">
												<label>Short Biography</label>
												<textarea name="short_biography" class="form-control" placeholder="Ex: Department and Rank"><?php echo isset($ca[0]['short_biography']) ? $ca[0]['short_biography']:'';?></textarea>
											</div>
											<hr/>
											<div class="form-action">												
												<button type="submit" name="submit" class="btn btn-primary submit"><i class='fa fa-plus-circle'></i> Add</button>
											</div>
										</div>
									</div>
								</form>
								<hr/>
								<h4 class="heading"><i class="fa fa-mortar-board"></i> Authors</h4><hr/>
								<div class="callout callout-success sort-message-success" style="display: none"></div>
								<div class="callout callout-danger sort-message-failed" style="display: none"></div>
								<table class="table table-striped">
									<thead>
										<tr>
											<th>No.</th>
											<th>Author</th>
											<th>Institution</th>
											<th>Sort</th>
											<th width="100"></th>
										</tr>
									</thead>
									<tbody>
									<?php if(!empty($authors)){ $no=0; foreach ($authors as $r){ $no++; ?>
										<tr>
											<td><?php echo $no;?></td>
											<td>
												<div><?php echo $r['salutation'].' '.$r['first_name'].' '.$r['last_name'];?></div>
												<div><?php echo $this->session->userdata('email') == $r['email'] ? '<i>(Corresponding Author)</i>':'';?></div>
												<div><a href="mailto:<?php echo $r['email'];?>"><?php echo $r['email'];?></a></div>
											</td>
											<td><?php echo $r['affiliation'];?></td>
											<td>
												<select name="sort" class="form-control sort" data-id="<?php echo $r['sa_id'];?>" data-page="<?php echo current_url();?>">
													<?php for($a=1; $a<=count($authors); $a++){?>
														<option value="<?php echo $a;?>" <?php echo $a == $r['sort'] ? 'selected':'';?>><?php echo $a;?></option>
													<?php } ?>
												</select>
											</td>
											<td>
												<span class="btn-group pull-right">
													<a data-tooltip="tooltip" title="Edit Author" class="btn btn-default btn-sm" href="<?php echo site_url().'dashboard/edit/author/'.$r['sub_id'].'/'.$r['sa_id'];?>"><i class="fa fa-edit"></i></a>
													<?php if($this->session->userdata('email') !== $r['email']){?>
													<a data-tooltip="tooltip" title="Delete Author" class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modalDeleteAuthor" onclick="return prepare_delete_author('<?php echo $r['sub_id'].'#'.$r['sa_id'];?>')"><i class="fa fa-trash"></i></a>
													<?php } ?>
												</span>
											</td>
										</tr>
									<?php }} ?>
									</tbody>
								</table>
								<hr/>
								<div>
									<span class="pull-left">
										<a href="<?php echo site_url().'dashboard/edit/submission/'.$this->uri->segment(4);?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Previous Step</a>
									</span>
									<span class="pull-right">
										<a href="<?php echo current_url();?>" class="btn btn-default">Save</a>
										<a href="<?php echo site_url().'dashboard/create/reviewer/'.$this->uri->segment(4);?>" class="btn btn-warning">Save and Continue <i class="fa fa-arrow-circle-right"></i></a>
									</span>
								</div>
								
							<!-- REVIEWER -->

							<?php }else if ($this->uri->segment(3) == 'reviewer'){?>

								<h2>Step 3: Reviewers & Editors</h2>
								<div class="callout callout-default">Please suggest 3 reviewers. They must at least have doctor title and their affiliation must be from country different from all of the authors.</div>
								<h4 class="well"><i class="fa fa-search-plus"></i> Add Reviewer</h4>
								<div class="form-group">
									<label>Find using reviewer's email address</label>
									<div class="input-group">
										<input type="search" class="form-control" name="search_author" placeholder="Find reviewer using email address" id="reviewers">
										<input type="hidden" id="sub_id_reviewer" value="<?php echo $this->uri->segment(4);?>">										
										<span class="input-group-btn">
											<button type="submit" class="btn btn-warning">Search</button>
										</span>
									</div>
								</div>
								
								<div class="callout callout-defaut search-msg text-danger" style="display: none"><i class="fa fa-warning"></i> Reviewer not found.</div>
								<form class="selected-reviewer" action="<?php echo site_url().'dashboard/insert/selected_reviewer';?>" method="POST" style="display: none">
									<input type="hidden" name="sub_id" value="<?php echo $this->uri->segment(4);?>">
									<input type="hidden" name="page" value="<?php echo current_url();?>">
									<input type="hidden" name="sr_id" id="sr_id">
									<div class="form-group">
										<table class="table table-bordered table-striped">
											<tr>
												<th>Name</th>
												<th>Email</th>
												<th>Affiliation/Institution</th>
												<th></th>
											</tr>
											<tr>
												<td class="name"></td>
												<td class="email"></td>
												<td class="affiliation"></td>
												<td><input type="submit" class="btn btn-primary" value="Set as reviewer"></td>
											</tr>
										</table>
									</div>
								</form>

								<form action="<?php echo site_url().'dashboard/insert/selected_reviewer';?>" method="POST">
									<input type="hidden" name="sub_id" value="<?php echo $this->uri->segment(4);?>">
									<input type="hidden" name="page" value="<?php echo current_url();?>">
								</form>

								<h2 class="hrtext"><span>OR</span></h2>
								<form method="POST" action="<?php echo $action == 'edit' ? site_url().'dashboard/update/reviewer' : site_url().'dashboard/insert/reviewer';?>">
									<input type="hidden" name="sub_id" value="<?php echo $this->uri->segment(4);?>">
									<input type="hidden" name="sr_id" value="<?php echo $this->uri->segment(5);?>">
									<div class="form-group">
										<label>Salutation <span>*</span></label>
										<select name="salutation" class="form-control" required>
											<option value="">- Select Salutation -</option>
											<option value="Prof." <?php echo isset($cr[0]['salutation']) && $cr[0]['salutation'] == "Prof." ? 'selected':'';?>>Prof.</option>
											<option value="Dr." <?php echo isset($cr[0]['salutation']) && $cr[0]['salutation'] == "Dr." ? 'selected':'';?>>Dr.</option>
											<option value="Mr." <?php echo isset($cr[0]['salutation']) && $cr[0]['salutation'] == "Mr." ? 'selected':'';?>>Mr.</option>
											<option value="Mrs." <?php echo isset($cr[0]['salutation']) && $cr[0]['salutation'] == "Mrs." ? 'selected':'';?>>Mrs.</option>
											<option value="Ms." <?php echo isset($cr[0]['salutation']) && $cr[0]['salutation'] == "Ms." ? 'selected':'';?>>Ms.</option>
										</select>
									</div>									
                  <div class="form-group"> <!-- ruki2 -->
                    <label>First Name <span>*</span></label>
                    <input type="text" name="first_name" class="form-control" placeholder="First name" value="<?php echo isset($cr[0]['first_name']) ? $cr[0]['first_name']:'';?>" required>
                  </div>
                  <div class="form-group"> <!-- ruki2 -->
                    <label>Last Name <span>*</span></label>
                    <input type="text" name="last_name" class="form-control" placeholder="Last name" value="<?php echo isset($cr[0]['last_name']) ? $cr[0]['last_name']:'';?>" required>
                  </div>
									<div class="form-group">
										<label>Emai <span>*</span></label>
										<input type="email" name="email" class="form-control" placeholder="email" value="<?php echo isset($cr[0]['email']) ? $cr[0]['email']:'';?>" required>
									</div>
									<div class="form-group">
										<label>Expertise <span>*</span></label>
										<input type="text" name="expertise" class="form-control" placeholder="Expertise" value="<?php echo isset($cr[0]['expertise']) ? $cr[0]['expertise']:'';?>" required>
									</div>
									<div class="form-group">
										<label>Affiliation/Institution <span>*</span></label>
										<input type="text" name="affiliation" class="form-control" placeholder="Affiliation" value="<?php echo isset($cr[0]['affiliation']) ? $cr[0]['affiliation']:'';?>" required>
									</div>									
									<hr/>
									<div class="form-action">										
										<input type="reset" name="reset" class="btn btn-default" value="Reset"> <!-- ruki2 -->
										<button type="submit" name="submit" class="btn btn-primary primary"><i class="fa fa-plus-circle"></i> Add</button>
									</div>									
								</form>
								<hr/>
								<h4 class="heading"><i class="fa fa-search"></i> Reviewers</h4><hr/>
								<table class="table table-striped">
									<thead>
										<tr>
											<th>No.</th>
											<th>Reviewer</th>
											<th>Expertise</th>
											<th>Affiliation/Institution</th>
											<th width="100"></th>
										</tr>
									</thead>
									<tbody>
									<?php if(!empty($reviewer)){ $no=0; foreach ($reviewer as $r){ $no++ ?>
										<tr>
											<td><?php echo $no;?></td>
											<td>
												<?php echo $r['salutation'].' '.$r['fullname'];?><br/>
												<a href="mailto:<?php echo $r['email'];?>"><?php echo $r['email'];?></a>
											</td>
											<td><?php echo $r['expertise'];?></td>
											<td><?php echo $r['affiliation'];?></td>
											<td>
												<span class="btn-group">
													<a data-tooltip="tooltip" title="Edit Reviewer" class="btn btn-default btn-sm" href="<?php echo site_url().'dashboard/edit/reviewer/'.$r['sub_id'].'/'.$r['sr_id'];?>"><i class="fa fa-edit"></i></a>
													<a data-tooltip="tooltip" data-toggle="modal" data-target="#modalDeleteReviewer" title="Delete Reviewer" class="btn btn-danger btn-sm" href="#" onclick="return prepare_delete_reviewer('<?php echo $r['sub_id'].'#'.$r['sr_id'];?>')"><i class="fa fa-trash"></i></a>
												</span>
											</td>
										</tr>
									<?php }} ?>
									</tbody>
								</table>
								<hr/>
								<div>
									<span class="pull-left">
										<a href="<?php echo site_url().'dashboard/edit/submission/'.$this->uri->segment(4);?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Previous Step</a>
									</span>
									<span class="pull-right">
										<a href="<?php echo current_url();?>" class="btn btn-default">Save</a>
										<a href="<?php echo site_url().'dashboard/edit/detail/'.$this->uri->segment(4);?>" class="btn btn-warning">Save and Continue <i class="fa fa-arrow-circle-right"></i></a>
									</span>
								</div>
								
							<!-- DETAIL -->

							<?php }else if ($this->uri->segment(3) == 'detail'){?>

								<h2>Step 4: Details & Comments</h2>
								<div class="callout callout-default">Enter your cover letter text into the "Cover Letter" box below. Answer any remaining questions appropriately. </div>
								<form action ="<?php echo site_url().'dashboard/update/submission_detail';?>" method="POST" enctype="multipart/form-data">
									<input type="hidden" name="round" value="<?php echo $sub[0]['round'];?>">
									<input type="hidden" name="page" value="<?php echo current_url();?>">
									<input type="hidden" name="sub_id" value="<?php echo $this->uri->segment(4);?>">
									<div class="form-group">
										<label>Cover Letter <span>*</span></label>
										<textarea name="cover_letter" class="form-control summernote" rows="10" placeholder="Cover letter"><?php echo isset($sub[0]['cover_letter'])? $sub[0]['cover_letter'] : '';?></textarea>
										<label>Attach File</label>
										<small>Allowed file: PDF. <= 10 MB</small>
										<input type="file" name="userfile" class="btn btn-default">
										<?php if(!empty($cover)){?>
											<table class="table">
											<tr>
												<th>Files</th>
												<th>Action</th>
											</tr>
											<?php foreach ($cover as $c){?>
												<td><a target="_blank" href="<?php echo site_url().$sub[0]['attach_cover'];?>"><i class="fa fa-paperclip"></i> Attachment File</a></td>
												<td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteFile" onclick="return prepare_delete_file('<?php echo $c['sf_id'];?>')"><i class="fa fa-trash"></i></a></td>
											<?php } ?>
											</table>
										<?php } ?>
									</div>
									<h3>Funding</h3>
									<div class="callout callout-default">
										Authors are required to report funding sources and grant/award numbers. Enter ALL sources of funding for ALL authors. Funders should be listed here AND in the manuscript to meet this requirement.
									</div>
									<div class="form-group">
										 <label>Is there funding to report for this submission?</label>
										 <table class="table">
										 <tr>
										 	<td width="10"><input type="radio" class="checkbox funder" name="is_funder" value="1" checked="checked"></td><td>Yes</td>
										 	<td width="10"><input type="radio" class="checkbox nofunder" name="is_funder" value="0" data-toggle="modal" data-target="#modalClearFunder"></td><td>No</td>
										 </tr>
										 </table>
										 <div class="list-funder">
											<table class="table table-striped">
											<tr>
												<th>Funder</th>
												<th>Grant/Award Number</th>
												<th>Action</th>
											</tr>
											<?php if(!empty($funders)){ foreach ($funders as $f){?>
											<tr>
												<td><?php echo $f['funder_name'].'<br/><small>'.$f['funder_desc'].'</small>';?></td>
												<td><?php echo number_format($f['award_number']);?></td>
												<td>
													<span class="btn-group">														
														<a href="#" data-target="#modalDeleteFunder" data-toggle="modal" onclick="return prepare_delete_funder('<?php echo $f['sfunder_id'];?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
													</span>
												</td>
											</tr>
											<?php }}else{?>
											<tr><td colspan="4">No funder entered</td></tr>
											<?php } ?>
											</table>
											<a href="#" data-toggle="modal" data-target="#modalFunder" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add Funder</a>
										 </div><br/>
									</div>									
									<div class="form-group">
										<label>Please confirm: </label>
										<table class="table table-strped">
											<tr>
												<th width="20"><input type="checkbox" class="checkbox" name="publish" value="1" <?php echo $sub[0]['not_publish'] == 1 ? 'checked = "checked"':'';?>></th>
												<td>* I confirm that the manuscript has been submitted solely to this journal and is not published, in press, or submitted elsewhere. </td>
											</tr>
											<tr>
												<th width="20"><input type="checkbox" class="checkbox" name="read" value="1" <?php echo $sub[0]['read_ethics'] == 1 ? 'checked = "checked"':'';?>></th>
												<td>* I acknowledge that you have read and understand the Ethical Guidelines. </td>
											</tr>
											<tr>
												<th width="20"><input type="checkbox" class="checkbox" name="agree_proofread" value="1" <?php echo $sub[0]['agree_proofread'] == 1 ? 'checked = "checked"':'';?>></th>
												<td>* I understand if this paper is accepted for publication, I will be responsible for the proofreading. </td>
											</tr>
										</table>
									</div>
									<hr/>
									<div>
										<span class="pull-left">
											<a href="<?php echo site_url().'dashboard/create/reviewer/'.$this->uri->segment(4);?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Previous Step</a>
										</span>
										<span class="pull-right">
											<input type="submit" name="submit" value="Save" class="btn btn-default">
											<button type="submit" name="submit" value="Save and Continue" class="btn btn-warning">Save and Continue <i class="fa fa-arrow-circle-right"></i></button>
										</span>
									</div>
								</form>

							<?php }else{?>
								
								<h2>Step 6: Review & Submit</h2>
								<div class="callout callout-default">Review the information below for correctness and make changes as needed. <b>Make sure that you enter the appropriate manuscript between doc/docx and pdf before completing your submission. Please click 'Journal Agreement' to complete your submission.</b> </div>

								<?php
									# checking requirement
									$sts = array();
									$is_submit = array();
									if($this->lib_view->check_input_status($sub[0]['sub_id'], 'meta') == 0){
										array_push($sts, "<b>Step 1: </b>Please check required data.");
										array_push($is_submit, 0);
									}
									if($this->lib_view->check_input_status($sub[0]['sub_id'], 'author') == 0){
										array_push($sts, "<b>Step 2: </b>Please input author's submission.");
										array_push($is_submit, 0);
									}
									if($this->lib_view->check_input_status($sub[0]['sub_id'], 'reviewer') == 0){
										array_push($sts, "<b>Step 3: </b>Please input reviewer at least 3 reviewer.");
										array_push($is_submit, 0);
									}
									if($this->lib_view->check_input_status($sub[0]['sub_id'], 'detail') == 0){
										array_push($sts, "<b>Step 4: </b>Please complete detail and check Confirmation.");
										array_push($is_submit, 0);
									}
									if($this->lib_view->check_input_status($sub[0]['sub_id'], 'file') == 0){
										array_push($sts, "<b>Step 5: </b>Please upload required files.");
										array_push($is_submit, 0);
									}
									
									if(!empty($sts)){?>
									<div class="callout callout-warning">
										<h4><i class="fa fa-warning"></i> Warning</h4>
										<ul>
											<?php for($a=0; $a<count($sts); $a++){
												echo "<li>".$sts[$a]."</li>";
											}?>
										</ul>
									</div>
								<?php }	?>

								<!-- start review data -->
								<h4>Step 1: Section, Title, and Abstract <a class="btn btn-default btn-sm pull-right" href="<?php echo site_url().'dashboard/edit/submission/'.$this->uri->segment(4);?>"><i class="fa fa-edit"></i></a></h4><hr/>
								<table class="table table-striped">
									<tr><th>Section</th><td><?php echo $sub[0]['section_title'];?></td></tr>
									<tr><th>Title</th><td><?php echo $sub[0]['sub_title'];?></td></tr>
									<tr><th>Abstract</th><td><?php echo $sub[0]['abstract'];?></td></tr>
									<tr><th>Keywords</th><td><?php echo $sub[0]['keywords'];?></td></tr>
									<tr><th>References</th><td><?php echo $sub[0]['sub_references'];?></td></tr>
								</table>
								
								<h4>Step 2: Author & Institution <a class="btn btn-default btn-sm pull-right" href="<?php echo site_url().'dashboard/create/author/'.$this->uri->segment(4);?>"><i class="fa fa-edit"></i></a></h4><hr/>
								<table class="table table-striped">
									<thead>
										<tr>
											<th>No.</th>
											<th>Author</th>
											<th>Institution</th>
											<th>Sort</th>
										</tr>
									</thead>
									<tbody>
									<?php if(!empty($authors)){ $no=0; foreach ($authors as $r){ $no++; ?>
										<tr>
											<td><?php echo $no;?></td>
											<td>
												<div><?php echo $r['first_name'].' '.$r['last_name'];?></div>
												<div><?php echo $this->session->userdata('email') == $r['email'] ? '<i>(Corresponding Author)</i>':'';?></div>
												<div><a href="mailto:<?php echo $r['email'];?>"><?php echo $r['email'];?></a></div>
											</td>
											<td><?php echo $r['affiliation'];?></td>
											<td><?php echo $r['sort'];?></td>											
										</tr>
									<?php }} ?>
									</tbody>
								</table>
								<h4>Step 3: Reviewers & Editors <a class="btn btn-default btn-sm pull-right" href="<?php echo site_url().'dashboard/create/reviewer/'.$this->uri->segment(4);?>"><i class="fa fa-edit"></i></a></h4><hr/>
								<table class="table table-striped">
									<thead>
										<tr>
											<th>No.</th>
											<th>Reviewer</th>
											<th>Expertise</th>
											<th>Affiliation/Institution</th>
										</tr>
									</thead>
									<tbody>
									<?php if(!empty($reviewer)){ $no=0; foreach ($reviewer as $r){ $no++ ?>
										<tr>
											<td><?php echo $no;?></td>
											<td>
												<?php echo $r['fullname'];?><br/>
												<a href="mailto:<?php echo $r['email'];?>"><?php echo $r['email'];?></a>
											</td>
											<td><?php echo $r['expertise'];?></td>
											<td><?php echo $r['affiliation'];?></td>
										</tr>
									<?php }} ?>
									</tbody>
								</table>

								<h4>Step 4: Detail & Confirmation <a class="btn btn-default btn-sm pull-right" href="<?php echo site_url().'dashboard/edit/detail/'.$this->uri->segment(4);?>"><i class="fa fa-edit"></i></a></h4><hr/>
								<table class="table table-striped">
									<tr><th>Cover Letter</th><td><?php echo $sub[0]['cover_letter'];?></td></tr>
									<tr><th>Funding</th><td><?php echo count($funders) > 0 ? '<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i>';?></td></tr>									
								</table>
								<?php if(count($funders) > 0){?>
								<h4>Funders</h4>
								<table class="table table-striped">
									<tr><th>Funder</th><th>Grant/Award Number</th></tr>
									<?php foreach ($funders as $fun){ ?>
									<tr><td><?php echo $fun['funder_name'].'<br/><small>'.$fun['funder_desc'].'</small>';?></td><td><?php echo $fun['award_number'];?></td></tr>
								<?php } ?>
								</table>
								<?php  } ?>
								
								<h4>Step 5: File Uploads <a class="btn btn-default btn-sm pull-right" href="<?php echo site_url().'dashboard/create/suplement/'.$this->uri->segment(4);?>"><i class="fa fa-edit"></i></a></h4><hr/>
								<table class="table table-striped">
									<tr>
										<th>Files</th>										
										<th>Type</th>										
										<th>Date</th>										
									</tr>
									<?php if(!empty($suplement)){ foreach ($suplement as $s){ if($s['type'] !== 5){?>
									<tr>
										<td>
											<?php $f = explode('/', $s['file_url']) ;?>
											<div><a href="<?php echo site_url().$s['file_url'];?>"><?php echo $f[count($f)-1];?></a> </div>
											<div><?php echo $s['file_description'];?></div>												
										</td>
										<td><?php echo manuscript_type($s['type']);?></td>
										<td><?php echo date('d M Y - H:i', strtotime($s['date_input']));?></td>										
									</tr>										
									<?php }}}else{
										echo "<tr><td colspan='2' class='text-warning'><i class='fa fa-warning'></i> No files uploaded.</td></tr>";
									} ?>
								</table>
								<hr/>
								<p>Make sure that you enter the appropriate manuscript between doc/docx and pdf</p>
								<div class="btn btn-primary" data-toggle="modal" data-target="#preview-manuscript">Preview Manuscript</div>
								<hr/>

									<h4 class="heading"><i class="fa fa-check-circle"></i> Journal Agreement</h4>									
									<?php if(isset($sub[0]['sub_status']) && ($sub[0]['sub_status'] != 0 && $sub[0]['sub_status'] != 7)){ ?>
										<div class="alert alert-default">
											<h4>Submitted</h4>
											<p>This article has been submitted at <?php echo date('d M Y - H:i', strtotime($sub[0]['date_submit']));?></p>
										</div>
									<?php }else{ ?>
										<div class="form-group">
											<div class="checkbox icheck">
												<label><input type="checkbox" class="agreement" name="agreement" value="1"> I aware and agree that :</label>
											</div>
											<ol>
												<li>Submission of an article is understood to imply that the article is original and is not being considered for publication elsewhere.</li>
												<li>Submission also implies that all authors have approved the paper for release and are in agreement with its content.</li>
												<li>The manuscript file complies with the given template and has been saved in Ms.Word format.</li>
												<li>All works cited has been mentioned in reference section.</li>
												<li>The manuscript will be checked for plagiarism using <a href="http://www.ithenticate.com" target="_blank">iThenticate</a></li>
												<li>Authors retain copyright and grant the journal right of first open-access publication.</li>
												<li>The information entered in this website will be used exclusively for the stated purposes of this journal and will not be made available for any other purpose or to any other party.</li>
											</ol>
										</div>
										<hr/>
										<div>
											<span class="pull-left">
												<a href="<?php echo site_url().'dashboard/create/suplement/'.$this->uri->segment(4);?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Previous Step</a>
											</span>
											<span class="pull-right">
												<?php if(!in_array(0, $is_submit)){?>
												<button type="submit" data-toggle="modal" onclick="return check_agreement()" data-target="#modalSubmit" class="btn btn-warning">Submit <i class="fa fa-arrow-circle-right"></i></button>
												<?php } ?>
											</span>
										</div>
									<?php } ?>							
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	</section>
</div>

<!-- modal submit -->
<div class="modal inmodal" id="modalSubmit" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-newspaper-o modal-icon"></i>
				<h4 class="modal-title">Submit Manuscript</h4>
				<div class="small"></div>
			</div>			
			<form method="POST" action="<?php echo site_url().'dashboard/insert/agreement';?>">
			<input type="hidden" name="sub_id" value="<?php echo $this->uri->segment(4);?>">			
			<div class="modal-body agreement-msg">
				Are you sure want to submit the manuscript?
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<button type="submit" name="submit" value="Submit" class="btn btn-primary agreement-btn">Yes </button>
			</div>
			</form>		
		</div>	
	</div>
</div>
