<!-- i need get screen width -->
<script type="text/javascript">
	var x = window.screen.width;
	var y = window.screen.height;	
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1><?php echo $task == "migrate" ? 'Migrate Journal':'In Press Journal';?></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/submission';?>">Submission</a></li>
			<li class="active"><?php echo strlen($title) > 50 ? ucwords(substr($title, 0 ,50)).'...': ucwords($title);?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
		
				<?php if($task !== "migrate"){?>

				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp; In Press Journal <?php echo $sub[0]['round'] > 1 ? '<span class="badge alert-danger">R'.($sub[0]['round']-1).'</span>':'';?></h3>
					</div>
					<div class="box-body">
						<div class="col-md-8">
							<div class="callout callout-info">
								<h4><i class="fa fa-info-circle"></i> Publishing Manuscript</h4>
								<p>Rearrangement of submission manuscript to web journal format.<br/>Use <i>DOC/DOCX</i> or <i>PDF</i> Manuscript to complete Journal section form below.</p>
							</div>
							<hr/>
							<form method="POST" action="<?php echo site_url().'dashboard/insert/journal';?>" enctype="multipart/form-data" id="form-journal">
								<input type="hidden" name="sub_id" value="<?php echo $sub[0]['sub_id'];?>">
								<input type="hidden" name="step" value="<?php echo $step;?>">
								<input type="hidden" name="page" value="<?php echo current_url();?>">
								
								<?php if($step == 'article'){?>
								<div class="form-group">
									<label>Issue: <span>*</span></label>
									<select name="issue_id" class="form-control" id="issue" required>
										<option value="">- Please select an Issue -</option>
										<?php if(!empty($issue)){ foreach($issue as $i){?>
										<option value="<?php echo $i['issue_id'];?>" <?php echo $i['issue_id'] == (isset($sub[0]['issue_id']) ? $sub[0]['issue_id'] : '') ? 'selected':'';?>><?php echo 'Vol '.$i['volume'].', No '.$i['issue_number'].' ('.$i['year'].')';?></option>
										<?php }} ?>
									</select>
								</div>

								<div class="form-group">
									<label>Title:</label>
									<textarea name="title" class="form-control titles"><?php echo $sub[0]['sub_title'];?></textarea>
								</div>
								<div class="form-group">
									<label>Abstract:</label>
									<textarea name="abstract" class="form-control summernote"><?php echo $sub[0]['abstract'];?></textarea>
								</div>
								<div class="form-group">
									<label>Keywords:</label><div class="note">Please separates words with a comma or semicolon</div>
									<input type="text" name="keywords" class="form-control" value="<?php echo $sub[0]['keywords'];?>">			
								</div>
											
								<?php } ?>

								<?php if($step == 'introduction'){?>
								<div class="form-group">
									<label>Introduction:</label>
									<textarea name="introduction" class="form-control summernote"><?php echo isset($sub[0]['introduction']) ? $sub[0]['introduction']:'';?></textarea>
								</div>
								<?php } ?>
								
								<?php if($step == 'experimental'){?>
								<div class="form-group">
									<label>Experimental Method:</label>
									<textarea name="experimental_method" class="form-control summernote"><?php echo isset($sub[0]['experimental_method']) ? $sub[0]['experimental_method']:'';?></textarea>
								</div>
								<?php } ?>
								
								<?php if($step == 'result'){?>
								<div class="form-group">
									<label>Results and Discussion:</label>
									<textarea name="result" class="form-control summernote"><?php echo isset($sub[0]['result']) ? $sub[0]['result']:'';?></textarea>
								</div>
								<?php } ?>
								
								<?php if($step == 'conclusion'){?>
								<div class="form-group">
									<label>Conclusion:</label>
									<textarea name="conclusion" class="form-control summernote"><?php echo isset($sub[0]['conclusion']) ? $sub[0]['conclusion']:'';?></textarea>
								</div>
								<?php } ?>

								<?php if($step == 'acknowledgement'){?>
								<div class="form-group">
									<label>Acknowledgement:</label>
									<textarea name="acknowledgement" class="form-control summernote"><?php echo isset($sub[0]['acknowledgement']) ? $sub[0]['acknowledgement']:'';?></textarea>
								</div>
								<?php } ?>
								
								<?php if($step == 'references'){?>
								<div class="form-group">
									<label>References:</label>
									<textarea name="references" class="form-control summernote"><?php echo isset($sub[0]['references']) ? $sub[0]['references']:$sub[0]['sub_references'];?></textarea>
								</div>
								<?php } ?>
								
								<?php if($step == 'file'){?>
								<?php if($sub[0]['pdf_file'] != "" || $sub[0]['pdf_file'] != NULL){?>
									<iframe src="<?php echo site_url().$sub[0]['pdf_file'];?>" frameborder="0" style="width:100%; height:600px"></iframe>
								<?php }else{?>
								<div class="callout callout-default">
									<h4>Preview File</h4>
									<p>No file uploaded. Please upload final manuscript, it will be shown here.</p>
								</div>
								<?php } ?>
								<hr/>
								<div class="form-group">
									<label>Final Manuscript File (PDF): <span>*</span></label>
									<div class="note">Please upload final manuscript (completed manuscript ready to publish)</div>
									<input type="file" name="userfile" class="btn btn-default btn-block fileupload" <?php echo $sub[0]['pdf_file'] == NULL ? 'required':'';?>>
									<input type="hidden" name="filename" value="<?php echo ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1):'').'-'.$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];?>">
									<div class="form-group">
										<label>Pages: <span>*</span></label>
										<input type="text" name="pages" id="pages" class="form-control" value="<?php echo $sub[0]['pages'];?>" placeholder="Ex: 107-115" required>
									</div>
									<div class="form-group">
										<label>Cite this article as: <span>*</span></label>
										<textarea name="cite" class="form-control title" id="cite" required><?php echo $sub[0]['cite'] == ''? $this->lib_view->default_citation($sub[0]['sub_id']): $sub[0]['cite'];?></textarea>
									</div>
								</div>
								<?php } ?>

								<?php if($step == 'publish'){?>
									<div class="callout callout-default">
										<i class="fa fa-lightbulb-o"></i> Make sure all section has been filled. Please register the article into DOI System
									</div>
									<div class="form-group">
										<label>DOI (Digital Object Identifier System): </label>
										<div class="note">Go to DOI page <a href="https://www.doi.org" target="_blank">https://www.doi.org</a></div>
										<input type="url" name="doi_url" class="form-control" value="<?php echo $sub[0]['doi_url'];?>" placeholder="Ex: https://doi.org/xx.xxxxx/ijtech.v7i6.xxxx" required>
									</div>

								<?php } ?>
								
								<hr/>

								<div class="form-action">
									<?php if($step !== 'article'){?>
									<a href="<?php echo isset($back) ? $back:'#';?>" class="btn btn-default pull-left"><i class="fa fa-arrow-circle-left"></i> Back</a>
									<?php } ?>
									<span class="pull-right">
										<?php if($step == "publish"){?>
											<input type="submit" name="submit" class="btn btn-success" onclick="return check_fill()" value="Publish">
										<?php }else{?>
											<input type="submit" name="submit" class="btn btn-default" value="Save">
											<button type="submit" name="submit" value="savecontinue" class="btn btn-primary">Save & Contine <i class="fa fa-arrow-circle-right"></i> </button>
										<?php } ?>
									</span>
								</div>
							</form>
								
						</div>
						<div class="col-md-4 sidebar fixed">

							<div class="list-group">
								<div class="list-group-item active">Journal Section</div>
								<div class="list-group-item <?php echo $step == 'article' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/process/'.$sub[0]['sub_id'].'/article';?>">Article</a></div>
								<div class="list-group-item <?php echo $step == 'introduction' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/process/'.$sub[0]['sub_id'].'/introduction';?>">Introduction Section</a></div>
								<div class="list-group-item <?php echo $step == 'experimental' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/process/'.$sub[0]['sub_id'].'/experimental';?>">Experimental Section</a></div>
								<div class="list-group-item <?php echo $step == 'result' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/process/'.$sub[0]['sub_id'].'/result';?>">Results and Discussion Section</a></div>
								<div class="list-group-item <?php echo $step == 'conclusion' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/process/'.$sub[0]['sub_id'].'/conclusion';?>">Conclusion Section</a></div>
								<div class="list-group-item <?php echo $step == 'acknowledgement' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/process/'.$sub[0]['sub_id'].'/acknowledgement';?>">Acknowledgement Section</a></div>
								<div class="list-group-item <?php echo $step == 'references' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/process/'.$sub[0]['sub_id'].'/references';?>">References Section</a></div>
								<div class="list-group-item <?php echo $step == 'file' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/process/'.$sub[0]['sub_id'].'/file';?>">Upload Final Manuscript</a></div>
								<div class="list-group-item <?php echo $step == 'publish' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/process/'.$sub[0]['sub_id'].'/publish';?>">Publish Manuscript</a></div>
							</div>

							<hr/>
							<div class="form-group">
								<label>Submitted Date:</label>
								<p><?php echo $sub[0]['date_submit'] !== '0000-00-00 00:00:00' ? date('d M Y - H:i', strtotime($sub[0]['date_submit'])) : '---';?></p>
							</div>
							
							<div class="form-group">								
								<?php for($x=1; $x <= $sub[0]['round']; $x++){?>
									<?php if(!empty($doc[$x])){?>
									<label>Manuscript <?php echo $doc[$x][0]['round'] > 1 ? '(R'.($doc[$x][0]['round']-1).')' :'';?></label>
									<p>
										<a href="<?php echo base_url().$doc[$x][0]['file_url'];?>" target="_blank">
										<?php $filename = explode('/', $doc[$x][0]['file_url']);
										echo "<i class='glyphicon glyphicon-save-file'></i> Manuscript DOC/DOCX";
										?></a><br/>
									</p>
									<?php } ?>

									<?php if(!empty($pdf[$x])){?>
									<p>
										<a href="#" onclick="window.open('<?php echo base_url().$pdf[$x][0]['file_url'];?>', 'Manuscript PDF', 'width=600, height=800'); return false;">
										<?php $filename = explode('/', $pdf[$x][0]['file_url']);
										echo "<i class='glyphicon glyphicon-save-file'></i> Manuscript PDF";
										?></a><br/>
									</p>
									<?php } ?>

									<?php if(!empty($preview[$x])){?>
									<p>
										<a href="#" onclick="window.open('<?php echo base_url().$preview[$x][0]['file_url'];?>', 'Graphical Abstract', 'width=400, height=200, left='+(x-400)/2+', top='+(y-200)/2); return false;">
										<?php $filename = explode('/', $preview[$x][0]['file_url']);
										echo "<i class='glyphicon glyphicon-save-file'></i> Graphical Abstract - Images";
										?></a><br/>
									</p>
									<?php } ?>
									
									<p>
										<a href="#" onclick="window.open('<?php echo base_url().'dashboard/cover_letter/'.$sub[0]['sub_id'].'/'.$x;?>', 'Cover Letter', 'width=600, height=800'); return false;">
										<i class='glyphicon glyphicon-save-file'></i> Cover Letter
										</a><br/>										
									</p>
									
									<?php if($sub[0]['round'] > 1){?>
										<?php if(!empty($letter[$x])){?>
										<p>
											<a href="#" onclick="window.open('<?php echo base_url().$letter[$x][0]['file_url'];?>', 'Response Letter', 'width=600, height=800'); return false;">
											<?php $filename = explode('/', $letter[$x][0]['file_url']);
											echo "<i class='glyphicon glyphicon-save-file'></i> Response Letter";
											?></a><br/>
										</p>
										<?php } ?>
									<?php } ?>
									
									<?php if(!empty($images[$x])){ for($a=0; $a < count($images[$x]); $a++){?>
									<p>
										<a href="#" onclick="window.open('<?php echo base_url().$images[$x][$a]['file_url'];?>', 'Supplementary File', 'width=600, height=700, left='+(x-600)/2+', top='+(y-700)/2); return false;">
										<?php $filename = explode('/', $images[$x][$a]['file_url']);
										echo "<i class='glyphicon glyphicon-save-file'></i> Supplementary File (".($a+1).")";
										?></a><br/>
									</p>
									<?php }} ?>
								<?php } ?>
								<hr/>
								<div class="btn btn-primary" data-target="#modalStatus" data-toggle="modal"><i class="fa fa-clock-o"></i> Manuscript History</div>
							</div>						
						</div>
					</div>
				</div>

				<!-- Migrate journal -->
				<?php }else{?>


				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp; Migrate Journal</h3>
					</div>
					<div class="box-body">
						<div class="col-md-8">
							<div class="callout callout-info">
								<h4><i class="fa fa-info-circle"></i> Publishing Manuscript</h4>
								<p>Rearrangement of submission manuscript to web journal format.<br/>Use <i>DOC/DOCX</i> or <i>PDF</i> Manuscript to complete Journal section form below.</p>
							</div>
							<hr/>
							<form method="POST" action="<?php echo site_url().'dashboard/insert/migrate';?>" enctype="multipart/form-data" id="form-journal">
								<input type="hidden" name="sub_id" value="<?php echo isset($sub[0]['sub_id'])? $sub[0]['sub_id']:'';?>">
								<input type="hidden" name="step" value="<?php echo $step;?>">
								<input type="hidden" name="page" value="<?php echo current_url();?>">
								
								<?php if($step == 'article'){?>
								<div class="form-group">
									<label>Issue: <span>*</span></label>
									<select name="issue_id" class="form-control" id="issue" required>
										<option value="">- Please select an Issue -</option>
										<?php if(!empty($issue)){ foreach($issue as $i){?>
										<option value="<?php echo $i['issue_id'];?>" <?php echo $i['issue_id'] == (isset($sub[0]['issue_id']) ? $sub[0]['issue_id'] : '') ? 'selected':'';?>><?php echo 'Vol '.$i['volume'].', No '.$i['issue_number'].' ('.$i['year'].')';?></option>
										<?php }} ?>
									</select>
								</div>
								
								<div class="form-group">
									<label>Section: <span>*</span></label>
									<select name="section_id" class="form-control" id="section" required>
										<option value="">- Please select Section -</option>
										<?php if(!empty($section)){ foreach($section as $i){?>
										<option value="<?php echo $i['section_id'];?>" <?php echo $i['section_id'] == (isset($sub[0]['section_id']) ? $sub[0]['section_id'] : '') ? 'selected':'';?>><?php echo $i['section_title'];?></option>
										<?php }} ?>
									</select>
								</div>

								<div class="form-group">
									<label>Title:</label>
									<textarea name="title" class="form-control titles"><?php echo isset($sub[0]['title']) ? $sub[0]['title']:'';?></textarea>
								</div>
								<div class="form-group">
									<label>Abstract:</label>
									<textarea name="abstract" class="form-control summernote"><?php echo isset($sub[0]['abstract']) ? $sub[0]['abstract']:'';?></textarea>
								</div>
								<div class="form-group">
									<label>Keywords:</label><div class="note">Please separates words with a comma or semicolon</div>
									<input type="text" name="keywords" class="form-control" value="<?php echo isset($sub[0]['keywords'])? $sub[0]['keywords']:'';?>">
								</div>
											
								<?php } ?>

								<?php if($step == 'introduction'){?>
								<div class="form-group">
									<label>Introduction:</label>
									<textarea name="introduction" class="form-control summernote"><?php echo isset($sub[0]['introduction']) ? $sub[0]['introduction']:'';?></textarea>
								</div>
								<?php } ?>
								
								<?php if($step == 'experimental'){?>
								<div class="form-group">
									<label>Experimental Method:</label>
									<textarea name="experimental_method" class="form-control summernote"><?php echo isset($sub[0]['experimental_method']) ? $sub[0]['experimental_method']:'';?></textarea>
								</div>
								<?php } ?>
								
								<?php if($step == 'result'){?>
								<div class="form-group">
									<label>Results and Discussion:</label>
									<textarea name="result" class="form-control summernote"><?php echo isset($sub[0]['result']) ? $sub[0]['result']:'';?></textarea>
								</div>
								<?php } ?>
								
								<?php if($step == 'conclusion'){?>
								<div class="form-group">
									<label>Conclusion:</label>
									<textarea name="conclusion" class="form-control summernote"><?php echo isset($sub[0]['conclusion']) ? $sub[0]['conclusion']:'';?></textarea>
								</div>
								<?php } ?>

								<?php if($step == 'acknowledgement'){?>
								<div class="form-group">
									<label>Acknowledgement:</label>
									<textarea name="acknowledgement" class="form-control summernote"><?php echo isset($sub[0]['acknowledgement']) ? $sub[0]['acknowledgement']:'';?></textarea>
								</div>
								<?php } ?>
								
								<?php if($step == 'references'){?>
								<div class="form-group">
									<label>References:</label>
									<textarea name="references" class="form-control summernote"><?php echo isset($sub[0]['references']) ? $sub[0]['references']:$sub[0]['sub_references'];?></textarea>
								</div>
								<?php } ?>

								<?php if($step == 'suplement'){?>

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
									
									<h4 class="heading"><i class="fa fa-cloud-upload"></i> Upload Files</h4>
									<?php $invalid = $this->session->userdata('invalid'); if (!empty($invalid)){?>
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
												<option value="0">Graphical Abstract - Image Graphic *</option>
												<option value="3">Supplementary File - DOC/DOCX/PDF/JPG/PNG/TIFF</option>
											
											</select>
										</div>
									</div>										

								<?php } ?>

								<?php if($step == 'authors'){?>
									<!-- Authors -->

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
														<a data-tooltip="tooltip" title="Edit Author" class="btn btn-default btn-sm" href="<?php echo site_url().'dashboard/migrate/'.$r['sub_id'].'/authors/'.$r['sa_id'];?>"><i class="fa fa-edit"></i></a>
														<?php if($this->session->userdata('email') !== $r['email']){?>
														<a data-tooltip="tooltip" title="Delete Author" class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modalDeleteAuthor" onclick="return prepare_delete_author('<?php echo $r['sub_id'].'#'.$r['sa_id'];?>')"><i class="fa fa-trash"></i></a>
														<?php } ?>
													</span>
												</td>
											</tr>
										<?php }}else{?>
											<tr><td colspan="5" class="note">No Author(s)</td></tr>
										<?php } ?>
										</tbody>
									</table>
									<h4 class="heading"><i class="fa fa-plus-circle"></i> Add Author</h4><hr/>
									<div class="form-group">
										<label>Salutation <span>*</span></label>
										<select name="salutation" class="form-control">
											<option value="">- Select Salutation -</option>
											<option value="Prof." <?php echo isset($ca[0]['salutation']) && $ca[0]['salutation'] == "Prof." ? 'selected':'';?>>Prof.</option>
											<option value="Dr." <?php echo isset($ca[0]['salutation']) && $ca[0]['salutation'] == "Dr." ? 'selected':'';?>>Dr.</option>
											<option value="Mr." <?php echo isset($ca[0]['salutation']) && $ca[0]['salutation'] == "Mr." ? 'selected':'';?>>Mr.</option>
											<option value="Mrs." <?php echo isset($ca[0]['salutation']) && $ca[0]['salutation'] == "Mrs." ? 'selected':'';?>>Mrs.</option>
											<option value="Ms." <?php echo isset($ca[0]['salutation']) && $ca[0]['salutation'] == "Ms." ? 'selected':'';?>>Ms.</option>
										</select>
									</div>
									<input type="hidden" name="sa_id" value="<?php echo $this->uri->segment(5);?>">
									<div class="form-group">
										<label>First Name <span>*</span></label>
										<input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php echo isset($ca[0]['first_name']) ? $ca[0]['first_name']:'';?>" required>
									</div>
									<div class="form-group">
										<label>Last Name </label>
										<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo isset($ca[0]['last_name']) ? $ca[0]['last_name']:'';?>">
									</div>
									<div class="form-group">
										<label>Email</label>
										<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo isset($ca[0]['email']) ? $ca[0]['email']:'';?>">
									</div>
									<div class="form-group">
										<label>Affiliation/Institution</label>
										<textarea name="affiliation" class="form-control affiliation-form" placeholder="Affiliation / Institution"><?php echo isset($ca[0]['affiliation']) ? $ca[0]['affiliation']:'';?></textarea>
									</div>
									<div class="form-group">
										<label>Country</label>
										<select name="country" class="form-control select">
											<option value="">- Select Country</option>
											<?php if(!empty($countries)){ foreach ($countries as $c){?>														
												<option value="<?php echo $c['country_name'];?>" <?php echo isset($ca[0]['country']) && $ca[0]['country'] == $c['country_name'] ? 'selected':'';?> ><?php echo $c['country_name'];?></option>
											<?php }} ?>
										</select>
									</div>

								<?php } ?>
								
								<?php if($step == 'file'){?>
								<?php if($sub[0]['pdf_file'] != "" || $sub[0]['pdf_file'] != NULL){?>
									<iframe src="<?php echo site_url().$sub[0]['pdf_file'];?>" frameborder="0" style="width:100%; height:600px"></iframe>
								<?php }else{?>
								<div class="callout callout-default">
									<h4>Preview File</h4>
									<p>No file uploaded. Please upload final manuscript, it will be shown here.</p>
								</div>
								<?php } ?>
								<hr/>
								<div class="form-group">
									<label>Final Manuscript File (PDF): <span>*</span></label>
									<div class="note">Please upload final manuscript (completed manuscript ready to publish)</div>
									<input type="file" name="userfile" class="btn btn-default btn-block fileupload" <?php echo $sub[0]['pdf_file'] == NULL ? 'required':'';?>>
									<input type="hidden" name="filename" value="<?php echo ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];?>">
									<div class="form-group">
										<label>Pages: <span>*</span></label>
										<input type="text" name="pages" id="pages" class="form-control" value="<?php echo $sub[0]['pages'];?>" placeholder="Ex: 107-115" required>
									</div>
									<div class="form-group">
										<label>Cite this article as: <span>*</span></label>
										<textarea name="cite" class="form-control title" id="cite" required><?php echo $sub[0]['cite'] == ''? $this->lib_view->default_citation($sub[0]['sub_id']): $sub[0]['cite'];?></textarea>
									</div>
								</div>
								<?php } ?>

								<?php if($step == 'publish'){?>
									<div class="callout callout-default">
										<i class="fa fa-lightbulb-o"></i> Make sure all section has been filled. Please register the article into DOI System
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>Date Submit: </label>
												<div class="note">Select date / year submitted manuscript</div>
												<div class="input-group">
													<input type="text" name="date_submit" class="form-control datepicker" value="<?php echo $sub[0]['date_submit']!='0000-00-00 00:00:00' ? date('Y-m-d', strtotime($sub[0]['date_submit'])) : date('Y-m-d');?>" required>
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Date Accept: </label>
												<div class="note">Select date / year accepted manuscript</div>
												<div class="input-group">
													<input type="text" name="date_accept" class="form-control datepicker" value="<?php echo $sub[0]['date_accept']!='0000-00-00 00:00:00' ? date('Y-m-d', strtotime($sub[0]['date_accept'])) : date('Y-m-d');?>" required>
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Date Publish: </label>
												<div class="note">Select date / year published manuscript</div>
												<div class="input-group">
													<input type="text" name="date_publish" class="form-control datepicker" value="<?php echo $sub[0]['date_publish']!='0000-00-00 00:00:00' ? date('Y-m-d', strtotime($sub[0]['date_publish'])) : date('Y-m-d');?>" required>
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label>DOI (Digital Object Identifier System): </label>
										<div class="note">Go to DOI page <a href="https://www.doi.org" target="_blank">https://www.doi.org</a></div>
										<input type="url" name="doi_url" class="form-control" value="<?php echo $sub[0]['doi_url'];?>" placeholder="Ex: https://doi.org/xx.xxxxx/ijtech.v7i6.xxxx" required>
									</div>

								<?php } ?>
								
								<hr/>

								<div class="form-action">
									<?php if($step !== 'article'){?>
									<a href="<?php echo isset($back) ? $back:'#';?>" class="btn btn-default pull-left"><i class="fa fa-arrow-circle-left"></i> Back</a>
									<?php } ?>
									<span class="pull-right">
										<?php if($step == "publish"){?>
											<input type="submit" name="submit" class="btn btn-success" onclick="return check_fill()" value="Publish">
										<?php }else{?>
											<input type="submit" name="submit" class="btn btn-default" value="Save">
											<button type="submit" name="submit" value="savecontinue" class="btn btn-primary">Save & Contine <i class="fa fa-arrow-circle-right"></i> </button>
										<?php } ?>
									</span>
								</div>
							</form>
								
						</div>

						<div class="col-md-4 sidebar fixed">

							<div class="list-group">
								<div class="list-group-item active">Journal Section</div>
								<div class="list-group-item <?php echo $step == 'article' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/migrate/'.(isset($sub[0]['sub_id']) ? $sub[0]['sub_id'].'/article':'');?>">Article</a></div>
								<div class="list-group-item <?php echo $step == 'introduction' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/migrate/'.(isset($sub[0]['sub_id']) ? $sub[0]['sub_id'].'/introduction':'');?>">Introduction Section</a></div>
								<div class="list-group-item <?php echo $step == 'experimental' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/migrate/'.(isset($sub[0]['sub_id']) ? $sub[0]['sub_id'].'/experimental':'');?>">Experimental Section</a></div>
								<div class="list-group-item <?php echo $step == 'result' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/migrate/'.(isset($sub[0]['sub_id']) ? $sub[0]['sub_id'].'/result':'');?>">Results and Discussion Section</a></div>
								<div class="list-group-item <?php echo $step == 'conclusion' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/migrate/'.(isset($sub[0]['sub_id']) ? $sub[0]['sub_id'].'/conclusion':'');?>">Conclusion Section</a></div>
								<div class="list-group-item <?php echo $step == 'acknowledgement' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/migrate/'.(isset($sub[0]['sub_id']) ? $sub[0]['sub_id'].'/acknowledgement':'');?>">Acknowledgement Section</a></div>
								<div class="list-group-item <?php echo $step == 'references' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/migrate/'.(isset($sub[0]['sub_id']) ? $sub[0]['sub_id'].'/references':'');?>">References Section</a></div>
								<div class="list-group-item <?php echo $step == 'authors' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/migrate/'.(isset($sub[0]['sub_id']) ? $sub[0]['sub_id'].'/authors':'');?>">Author(s)</a></div>
								<div class="list-group-item <?php echo $step == 'suplement' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/migrate/'.(isset($sub[0]['sub_id']) ? $sub[0]['sub_id'].'/suplement':'');?>">Upload Suplement File</a></div>
								<div class="list-group-item <?php echo $step == 'file' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/migrate/'.(isset($sub[0]['sub_id']) ? $sub[0]['sub_id'].'/file':'');?>">Upload Final Manuscript</a></div>
								<div class="list-group-item <?php echo $step == 'publish' ? 'black':'';?>"><a href="<?php echo site_url().'dashboard/migrate/'.(isset($sub[0]['sub_id']) ? $sub[0]['sub_id'].'/publish':'');?>">Publish Manuscript</a></div>
							</div>
				
						</div>
					</div>
				</div>

				<?php } ?>
			</div>
		</div>
		
	</section>
</div>

<!-- modal status -->
<div class="modal inmodal" id="modalStatus" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-clock-o modal-icon icon"></i>
				<h4 class="modal-title set-header">Manuscript History</h4>
				<div class="set-header-label">Manuscript Process history.</div>
			</div>
			<div class="modal-body">
				<?php isset($sub[0]['sub_id']) ? $this->lib_view->log_submission_status($sub[0]['sub_id']):'';?>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Close" class="btn btn-white" data-dismiss="modal">
			</div>		
		</div>	
	</div>
</div>

<!-- modal delete author -->
<div class="modal inmodal" id="modalDeleteAuthor" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-trash modal-icon"></i>
				<h4 class="modal-title">Delete Author</h4>
				<div class="small"></div>
			</div>			
			<form id="deleteAuthor" method="POST" action="#">
				<div class="modal-body agreement-msg">
					Are you sure want to delete this author?
				</div>
				<div class="modal-footer">
					<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
					<button type="submit" name="submit" value="Submit" class="btn btn-danger">Yes </button>
				</div>
			</form>
		</div>	
	</div>
</div>

<!-- modal delete file -->
<div class="modal inmodal" id="modalDeleteFile" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-trash modal-icon"></i>
				<h4 class="modal-title">Delete File</h4>
				<div class="small"></div>
			</div>			
			<form method="POST" action="<?php echo site_url().'dashboard/delete/suplement';?>">	
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<input type="hidden" name="sf_id" id="sf_id">
				<input type="hidden" name="sub_id" value="<?php echo $this->uri->segment(4);?>">			
				<div class="modal-body agreement-msg">
					Are you sure want to delete this file?
				</div>
				<div class="modal-footer">
					<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
					<button type="submit" name="submit" value="Submit" class="btn btn-danger">Yes </button>
				</div>
			</form>
		</div>	
	</div>
</div>