<!-- i need get screen width for good -->
<script type="text/javascript">
	var x = window.screen.width;
	var y = window.screen.height;	
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Detail Submission</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/submission';?>">Submission</a></li>
			<li class="active"><?php echo strlen($title) > 50 ? ucwords(substr($title, 0 ,50)).'...': ucwords($title);?></li>
		</ol>
	</section>
	<section class="content usetooltip"> 
		<div class="row">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp; Detail Submission <?php echo $sub[0]['round'] > 1 ? '<span class="badge alert-danger">R'.($sub[0]['round']-1).'</span>':'';?></h3>
					</div>
					<div class="box-body">
						<div class="col-md-7">
							<div class="form-group">
								<label>Author(s):</label>
								<p><?php echo $this->lib_view->author_submission_full($sub[0]['sub_id']);?></p>
							</div>
							<div class="form-group">
								<label>Title:</label>
								<p><?php echo $sub[0]['sub_title'];?></p>
							</div>
							<?php if($sub[0]['article_type']!=''){ ?>
                            <div class="form-group">
                            	<label>Article type:</label>
                            	<?php
                            	    $edition = $this->db->query("select title from editions where id = ".$sub[0]['edition'])->row()->title;
                            	?>
                            	<p><?php echo $sub[0]['article_type'];?> Article - <?=$edition?></p>
                            </div>
                            <?php } ?>
							<div class="form-group">
								<label>Abstract:</label>
								<p><?php echo $sub[0]['abstract'];?></p>
							</div>
							<div class="form-group">
								<label>Keywords:</label>
								<p><?php echo $sub[0]['keywords'];?></p>
							</div>
							<div class="btn btn-default btn-references btn-block"><i class="fa fa-file-text-o"></i> Show References</div><br/>
							<div class="form-group references" style="display: none">
								<label>References:</label>
								<p><?php echo $sub[0]['sub_references'];?></p>
							</div>

							<?php if (in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role')) || in_array(3, $this->session->userdata('role')) || in_array(4, $this->session->userdata('role'))){?>
								<div class="form-group">
									<label>Editor in Charge :</label>
									<div class="list-group">
									<?php 
										$editor = $this->lib_view->get_section_editor($sub[0]['section_id']);
										if(!empty($editor)){
											foreach ($editor as $e){												
												if($this->session->userdata('email') == $e['email'])
													echo "- ".$e['salutation'].' '.$e['first_name'].' '.$e['last_name'];
												else 												
													echo '- <a href="mailto:'.$e['email'].'">'.$e['salutation'].' '.$e['first_name'].' '.$e['last_name'].'</a>';
												echo "<br/>";
											}
										}
									?>	
									</div>
								</div>

								<?php if (in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role')) || in_array(3, $this->session->userdata('role')) || in_array(4, $this->session->userdata('role'))){
								
									# checing wharever submission status == 2 and never given decission type 1 (Decision after screeing)
									# ===================================================================================================
									$check_enable_screening = $this->lib_view->check_enable_screening($sub[0]['sub_id']);
									if(in_array($sub[0]['sub_status'], array(1,2)) && $check_enable_screening){ ?>	
									<hr/>
									<pre style="display:none" code="c4tfa7"> <?php print_r($last_screening); ?> </pre>
									<?php if($sub[0]['sub_status'] == 1){ ?>

										<h3 class="heading">Screening by Editor in Charge</h3>
										<small></small>						
										<form action="<?php echo site_url().'dashboard/update/screening';?>" method="POST" enctype="multipart/form-data">
											<input type="hidden" name="sub_id" value="<?php echo $sub[0]['sub_id'];?>">
											<input type="hidden" name="round" value="<?php echo $sub[0]['round'];?>">
											<input type="hidden" name="author" value="<?php echo $sub[0]['user_id'];?>">
											<input type="hidden" name="page" value="<?php echo current_url();?>">
											<div class="form-group">
												<label>Screening decision</label> <!-- Ruki 20nov2018 merubah field ini agar tidak required lagi -->
												<select name="status" class="form-control decision_eic">
													<option value="">- Select Decision -</option>
													<option value="1">Accepted : Proceed to Secretariat</option>
													<option value="2">Revise : Send back to Author</option>
													<option value="3">Reject : Declined Submission</option>
												</select>
											</div>

											<div class="form-group">
												<label> <input type="checkbox" name="c_section" id="c_section"> Move this submission to section:</label>
												<select name="section_id" class="form-control" id="s_section" disabled>
													<?php if(!empty($section)){ foreach ($section as $s) {?>
														<option value="<?php echo $s['section_id'];?>" <?php echo $sub[0]['section_id'] == $s['section_id'] ? 'selected':'';?>><?php echo $s['section_title'];?></option>
													<?php }} ?>
												</select>
											</div>
											
											<div class="form-group" id="notes_for_secretariat" style="display: none">
												<label>Notes for Secretariat (not shown to author)</label>
												<div class="note">Please enter message/note for secretariat about this submission.</div>
												<textarea class="form-control" name="notes_for_secretariat" rows="3" placeholder="Notes for secretariat"></textarea>
											</div>

											<div class="form-group" id="decision_eic" style="display:none">
												<label>Reason(s) for revision/rejection (will be shown to the author)</label><br/>
												<label><input type="checkbox" name="r1" value="Poor english"> Poor English </label><br/>
												<label><input type="checkbox" name="r2" value="High Similarity/Plagiarism Rate"> High Similarity/Plagiarism Rate  </label><br/>
												<label><input type="checkbox" name="r3" value="Unsuitable Format"> Unsuitable Format </label><br/>
												<label><input type="checkbox" name="r4" value="Unreadable text, figure, or table"> Unreadable text, figure, or table </label><br/>
												<label><input type="checkbox" name="r5" value="Unsuitable theme"> Unsuitable theme </label><br/>
												<label><input type="checkbox" name="r6" value="Out of date reference"> Out of date reference </label><br/>
												<label><input type="checkbox" name="r7" value="Lack of significant contribution or novelty"> Lack of significant contribution or novelty </label><br/> <?php //ruki ?>
												<div style="padding-left:15px">
												<label style="font-style:italic; font-weight:normal">Other reasons if any. If more than one, please separate them using semicolon (;):</label>
												<textarea name="other" class="form-control" placeholder="Other reason"></textarea>
												</div>
												<label>Revision duration (in days)</label>
												<div class="note">For default revision days (<?php echo DAY_REVISE_SCREENING;?> days after this notify was sent to the author(s))</div>
												<input type="number" name="revise_days" min="1" max="30" class="form-control" placeholder="Please revise manuscript in this days">
												
												<!--br/>
												<label>Attachment</label>
												<div class="note">Please select pdf file format to attach file</div>
												<input type="file" name="userfile" class="btn btn-default"-->
											</div>										
											<div class="form-action">
												<input type="submit" name="submit" class="btn btn-primary" value="Save">
											</div>											
										</form>										
									
									
									<?php 
									// }else if($sub[0]['sub_status'] == 2 && (!empty($last_screening) && $last_screening[0]['eic'] == 0)){
									}else if($sub[0]['sub_status'] == 2 && (!empty($last_screening) )){
									?>
										
										
										<h3 class="heading">Initial Screening <small>(Secretariat)</small></h3><small>Tasks: check plagiarism, theme, formatting, readability, ensure no author info</small>									
										<form action="<?php echo site_url().'dashboard/update/screening';?>" method="POST" enctype="multipart/form-data">
											<input type="hidden" name="screening_id" value="<?php echo $last_screening[0]['screening_id'];?>">
											<input type="hidden" name="from_eic" value="1">
											
											<input type="hidden" name="sub_id" value="<?php echo $sub[0]['sub_id'];?>">
											<input type="hidden" name="round" value="<?php echo $sub[0]['round'];?>">
											<input type="hidden" name="author" value="<?php echo $sub[0]['user_id'];?>">
											<input type="hidden" name="page" value="<?php echo current_url();?>">
											<div class="form-group">
												<label>Similarity Rate (%)</label>
												<input type="number" name="similarity_rate" step="any" min="0" max="100" placeholder="Please enter Similarity rate" class="form-control">
											</div>											
											<div class="form-group">
												<label>Decision <span>*</span></label>
												<select name="status" class="form-control decision" required>
													<option value="">- Select Decision -</option>
													<option value="1">Accepted : Proceed to review process</option>
													<option value="2">Revise : Send back to Author</option>
													<option value="3">Reject : Declined Submission</option>
												</select>
											</div>
											<div class="form-group">
												<label>Section  </label> <input type="checkbox" name="c_section" id="c_section"> Change Section
												<select name="section_id" class="form-control" id="s_section" disabled>
													<?php if(!empty($section)){ foreach ($section as $s) {?>
														<option value="<?php echo $s['section_id'];?>" <?php echo $sub[0]['section_id'] == $s['section_id'] ? 'selected':'';?>><?php echo $s['section_title'];?></option>
													<?php }} ?>
												</select>
											</div>
											<div class="form-group" id="decision" style="display:none">
												<label>Reason(s)</label><br/>
												<label><input type="checkbox" name="r1" value="Poor english"> Poor English </label><br/>
												<label><input type="checkbox" name="r2" value="High Similarity/Plagiarism Rate"> High Similarity/Plagiarism Rate  </label><br/>
												<label><input type="checkbox" name="r3" value="Unsuitable Format"> Unsuitable Format </label><br/>
												<label><input type="checkbox" name="r4" value="Unreadable text, figure, or table"> Unreadable text, figure, or table </label><br/>
												<label><input type="checkbox" name="r5" value="Unsuitable theme"> Unsuitable theme </label><br/>
												<label><input type="checkbox" name="r6" value="Out of date reference"> Out of date reference </label><br/>
												<label style="font-style:italic; font-weight:normal">Other reasons if any. If more than one, please separate them using semicolon (;):</label>
												<textarea name="other" class="form-control" placeholder="Other reason"></textarea><hr/>
												<label>Revision in days</label>
												<div class="note">For default revision days (<?php echo DAY_REVISE_SCREENING;?> days after this notify was sent to the author(s))</div>
												<input type="number" name="revise_days" min="1" max="30" class="form-control" placeholder="Please revise manuscript in this days">
												<br/>
												<label>Attachment</label>
												<div class="note">Please select pdf file format to attach file</div>
												<input type="file" name="userfile" class="btn btn-default">
											</div>										
											<div class="form-action">
												<input type="submit" name="submit" class="btn btn-primary" value="Save">
											</div>
										</form>

									<?php } ?>
									<?php } ?>
								<?php } //if role=1|2|3|4 ?>

								<!-- editor section suggested reviewer list -->
								<?php $tmp = $this->session->userdata('editor_section'); //workaround for older PHP version by ruki24aug2018
                if(
                    // !empty($tmp) || 
                    // (	$this->lib_view->show_suggest_reviewer($sub[0]['sub_id']) == 0 &&
											// (	in_array(1, $this->session->userdata('role')) 
												// || in_array(2, $this->session->userdata('role')) 
												// && $sub[0]['sub_status'] < 2
											// )
										// )
										!in_array(5, $this->session->userdata('role')) &&
										!in_array(6, $this->session->userdata('role')) &&
										($sub[0]['sub_status'] <= 2 ||
										$sub[0]['sub_status'] >= 7)
									){
										?>
								<hr/>
								<div class="form-group" style="overflow:scroll">
									<h4>Reviewers Suggestion from Author</h4>
									<table class="table table-striped">
										<tr>
											<th>No.</th>
											<th>Reviewer</th>										
											<th>Expertise</th>
										</tr>
										<?php $reviewer = $this->lib_view->get_reviewers($sub[0]['sub_id']);
										if(!empty($reviewer)){ $no=0; foreach ($reviewer as $r){
											if($r['user_id'] != $sub[0]['user_id']){continue;}
											$no++ ?>
											<tr>
												<td><?php echo $no;?>.</td>
												<td>
													<?php echo $r['salutation'].' '.$r['fullname'];?><br/>
													<i><?php echo $r['email'];?></i>
													<div><?php echo $r['affiliation'];?></div>
                          <?php if($r['user_id'] == $sub[0]['user_id']){echo '<div class="badge label-error">suggested by author</div>';} //ruki ?>
												</td>
												<td><?php echo $r['expertise'];?></td>
											</tr>
										<?php }} ?>
									</table>
								</div>
								<?php } ?>
								
								<!-- Appoinment Reviewers -->
								<?php if (($this->lib_view->show_suggest_reviewer($sub[0]['sub_id']) > 0) && ($sub[0]['sub_status'] > 2 && $sub[0]['sub_status'] < 7)) {?>
									<hr/>
									<div class="form-group" style="overflow:auto">
										<h3>Reviewers</h3> <!-- ruki -->
										<table class="table table-striped">
											<tr>
												<th>No.</th>
												<th>Reviewer</th>										
												<th>Expertise</th>
												<th width="100">Status in this review round</th>
											</tr>
											<?php $reviewer = $this->lib_view->get_reviewers($sub[0]['sub_id']);
												if(!empty($reviewer)){ $no=0; foreach ($reviewer as $r){ $no++ ?>
												<tr>
													<td><?php echo $no;?>.</td>
													<td>
														<?php echo $r['salutation'].' '.$r['fullname'];?><br/>
														<a href="mailto:<?php echo $r['email'];?>"><?php echo $r['email'];?></a>
														<div><small><?php echo $r['affiliation'];?></small></div>
                            <?php if($r['user_id'] == $sub[0]['user_id']){echo '<div class="badge label-error" title="Suggested by author. Cannot be removed, for inventory.">suggested by author</div>';}
                            else{
                                $eicName = $this->db->query("select concat(first_name,' ',last_name) x from users where user_id =  '".$r['user_id']."' limit 1")->row();
                                echo '<div class="badge bg-teal '.$r['user_id'].'">added by '.$eicName->x.'</div>';
                            } //ruki2 ?>
													</td>
													<td><?php echo $r['expertise'];?></td>
													<td>
														<?php if ($r['status'] == 0){ //blm diinvite 
															//if(!is_null($r['date_input'])){
																echo '<small title="listed at"><i class="fa fa-user-plus"></i> '.date('d M Y - H:i', strtotime($r['date_input'])).'<br></small>';
															//}
														?>
														<span class="btn-group">
															<a data-tooltip="tooltip" title="Send email invitation" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalReviewer" href="#" 
																onclick="
																	<?php if($r['user_id'] == $sub[0]['user_id']){ //if this is suggested by author ?>
																		add_reviewer('<?php echo $r['fullname'].' '.$r['email'];?>',
																			'<?php echo $r['fullname'].' ('.$r['email'].')<br>'.trim(preg_replace('/\s\s+/', ' ', $r['affiliation'])).'<br>Expertise: '.trim(preg_replace('/\s\s+/', ' ', $r['expertise']));?>');
																		return set_reviewer('<?php echo $r['sub_id'].'#'.$r['sr_id'].'#'.'2';?>');
																	<?php }else{ ?>
																		return set_reviewer('<?php echo $r['sub_id'].'#'.$r['sr_id'].'#'.'21';?>');
																	<?php } ?>
																">
																<i class="fa fa-envelope"></i>
															</a>
															<?php if($r['user_id'] != $sub[0]['user_id']){ //if not suggested by author ?>
                              <a data-tooltip="tooltip" title="Remove from this list" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modalReviewer" href="#" 
																onclick="return set_reviewer('<?php echo $r['sub_id'].'#'.$r['sr_id'].'#'.'4';?>')">
																<i class="fa fa-trash"></i>
															</a>
															<?php } ?>
														</span>
														<?php }else{ //sudah diinvite: 1=bersedia 2=waitingConfirmation 3=refused 4=removed
															if(!is_null($r['date_invite'])){
																echo '<small title="invite time"><i class="fa fa-envelope"></i> '.date('d M Y - H:i', strtotime($r['date_invite'])).'<br></small>';
															}
															if(!is_null($r['date_respond'])){
																echo '<small title="reply time"><i class="fa fa-reply"></i> '.date('d M Y - H:i', strtotime($r['date_respond'])).'<br></small>';
															}
							  echo '<div style="display:none">'.$r['status'].'</div>';
                              if($r['status']==1){ //bersedia
                                $reviewItem = $this->cms->get_review_item($r['sub_id'], $sub[0]['round'], $r['email']); // $reviewItem = $this->ci->cms->get_review_item($r['sub_id'], 1, $r['email']);
                                if(isset($reviewItem[0])){
                                    if($reviewItem[0]['date_review'] !== NULL){ //sudah mereview
                                      echo '<small title="done at"><i class="fa fa-check-square"></i> '.date('d M Y - H:i',strtotime($reviewItem[0]['date_review'])).'<br></small>';
                                      echo reviewer_decision_label(5);
                                    }else{ //blm mereview
                                      echo reviewer_decision_label(1);
                                    }
                                }else{ //sudah setuju tapi blm ada entry nya di round ini:
                                    // $tmp = $this->db->query("select count(*) c from submission_review where sub_id = ".$r['sub_id']." and reviewer_email = '".$r['email']."' and date_review is not null ")->row()->c;
									$tmp = $this->db->query("select count(*) c from submission_review where sub_id = ".$r['sub_id']." and reviewer_email = '".$r['email']."' and round = ".$sub[0]['round']." and date_review is not null ")->row()->c;
                                    if($tmp==0){
                                        $tmp2 = $this->db->query("select round from submission_review where reviewer_email = '".$r['email']."' and sub_id = ".$r['sub_id']." and review_result = 1 order by round desc limit 1;")->row();
										if(isset($tmp2->round)){
											echo '<div class="badge label-success">Done. Accept<br>at round '.($tmp2->round - 1).'</div>';
										}else{
											echo '<div class="badge label-warning">Not willing to do review<br>in this round</div>';
										}
                                    }else{
																			$tmp = $this->db->query("select count(*) c from submission_review where sub_id = ".$r['sub_id']." and reviewer_email = '".$r['email']."' and round = ". ($sub[0]['round']-1)." and date_review is not null ")->row()->c;
																			if($tmp==0){
                                        echo '<div class="badge label-warning">Agree to do review but<br>did not give review since round 1</div>';
																			}else{
                                        echo '<div class="badge label-warning">Agree to do review but<br>did not give review in one of<br>the previous rounds</div>';
																			}
                                    }
                                }
                              }else{
/*
reviewer_decision_label:
0 : Waiting Editor Decision
1 : Agree to do review
2 : Invited<br>Waiting Confirmation
3 : Refuse to review
4 : Expired
5 : Done
*/
                                echo reviewer_decision_label($r['status']); //2=waitingConfirmation 3=refused 4=removed
                                if($r['status']==6){
                                    echo '<br><small><a href="'.base_url('dashboard/unexpirerev/'.$r['sub_id'].'/'.$r['email']).'">Activate again</a></small>';
                                }
                                if($r['status']==7){
                                    echo '<br><small><a href="'.base_url('dashboard/unexpirerevtask/'.$r['sub_id'].'/'.$r['email']).'">Activate again</a></small>';
                                }
if($r['status']==2){ 
//fitur ini masih direncanakan
?> 
<!--br><a data-tooltip="tooltip" title="Cancel Invitation" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modalReviewer" href="#" onclick="return set_reviewer('<?php echo $r['sub_id'].'#'.$r['sr_id'].'#'.'4';?>')"><i class="fa fa-trash"></i></a-->
<?php }
                              }
														} ?>
													</td>
												</tr>
											<?php }} ?>
										</table>
										<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalReviewer" onclick="return set_reviewer('<?php echo $r['sub_id'].'#'.$r['sr_id'].'#'.'20';?>')">Add a candidate* reviewer</a> <!-- ruki -->
                    <br><span><small>*) A candidate reviewer will become a <em>real</em> reviewer after he/she accept the invitation to review this paper.</small></span>
									</div>
								<?php } ?>
							<?php } //if role=1|2|3|4 ?>

							<!-- publish button -->						
							<!-- <?php 
								if(in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role'))){
									if($sub[0]['sub_status'] == 8){?>
										<div class="btn btn-success btn-block" data-toggle="modal" data-target="#modalPublish"><i class="fa fa-book"></i> Publish Manuscript</div>
									<?php } ?>
							<?php } ?> -->

							<!-- button author revise if submission status = 7 -->
							<?php 
							if(in_array(5, $this->session->userdata('role')) && !in_array($sub[0]['sub_status'], array(8,9,10,99))){ //8:accepted 9:archived(published) 10:arcived(rejected)  11:inPress 12:lineEditing 99:withdraw 
								$check_enable_confirm_revise = $this->lib_view->check_enable_confirm_revise($sub[0]['sub_id']);								
								if ($check_enable_confirm_revise){?>
    								The last decision suggested this manuscript to be revised.
    								<br>Please refer to the email for detailed issues that needs to be revised.
    								<br>Click the button below to submit a revision for this manuscript.
    								<br>
    								<br>
    								<a href="#" data-toggle="modal" data-target="#revise-agreement" class="btn btn-info" onclick="return revise_agreement('<?php echo $sub[0]['sub_id'].'#'.$sub[0]['round'];?>')">Click here to submit a revision</a>
							    <?php }else{
								    if($sub[0]['sub_status'] == 7){?>
        								The last decision suggested this manuscript to be revised.
        								<br>Please refer to the email for detailed issues that needs to be revised.
        								<br>Click the button below to submit a revision for this manuscript.
        								<br>
        								<br>
								        <a href="<?php echo site_url().'dashboard/edit/submission/'.$sub[0]['sub_id'];?>" class="btn btn-info"><i class="fa fa-edit"></i> Submit a revision</a>
							        <?php }
							    }
							} ?>
						</div>

						<!-- Sidebar  -->
						<div class="col-md-5 sidebar-content">

							<div class="panel">
								<div class="box-header" style="border-top:solid 1px #DDD; background-color: #EEE">
									<h5 class="box-titles"><i class="fa fa-info-circle"></i> Manuscript Activity</h5>
                  
                  <?php if($sub[0]['sub_status'] > 5 || in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role')) || in_array(3, $this->session->userdata('role')) || in_array(4, $this->session->userdata('role')) ){ //ruki8aug2018 ?>
									<div class="box-tools pull-right">
										<div class="btn-group">
										    <a class="btn btn-default btn-sm" href="#" onclick="return show_review('<?php echo $sub[0]['sub_id'].'#'.$sub[0]['round'];?>')" data-toggle="modal" data-target="#modalReviewHistory"><i class="fa fa-clock-o"></i> Review History</a>
										    
											<!--button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
												<i class="fa fa-chevron-circle-down"></i></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="return show_review('<?php echo $sub[0]['sub_id'].'#'.$sub[0]['round'];?>')" data-toggle="modal" data-target="#modalReviewHistory"><i class="fa fa-clock-o"></i> Review History</a></li>
											</ul-->
											
										</div>										
									</div>
                  <?php } ?>
                  
								</div>
								<div class="box-body" style="overflow:scroll">

									<div class="form-group">
										<label>Submitted Date:</label>
										<p><?php echo $sub[0]['date_submit'] == '0000-00-00 00:00:00' ? '-----': ($this->lib_view->first_submit_date($sub[0]['sub_id']) ? date('d M Y - H:i', strtotime($this->lib_view->first_submit_date($sub[0]['sub_id']))) : 'Data migration');?></p>
									</div>

									<div class="form-group">
										<label>Submitted By:</label>
										<p><?php echo $this->lib_view->get_user_submit($sub[0]['user_id']);?></p>
									</div>
							
									<div class="form-group">								
										<?php for($x=1; $x <= $sub[0]['round']; $x++){?>
											<div class="row">
												<div class="col-md-10">

												<?php
													$maxFileRound>1
												?>
													<label>Files<?php 
													//echo $doc[$x][0]['round'] > 1 ? ' after Review Round '.($doc[$x][0]['round']-1).' (R'.($doc[$x][0]['round']-1).'):' :':';
													echo $maxFileRound[$x] > 1 ? ' after Review Round '.($maxFileRound[$x]-1).' (R'.($maxFileRound[$x]-1).'):' :':';
													
													?></label><br>
													
													
													<?php 
													if(!empty($doc[$x])){?>
<form action="<?php echo base_url().'download/'.$sub[0]['sub_id']; ?>" method="post" target="_blank">
  <button style="padding:0" type="submit" name="f" value="<?php echo $doc[$x][0]['file_url']; ?>" class="btn-link"><i class='glyphicon glyphicon-save-file'></i> Manuscript DOC/DOCX</button><br>
</form>
													<?php } ?>

													<?php if(!empty($pdf[$x])){?>
<form action="<?php echo base_url().'download/'.$sub[0]['sub_id']; ?>" method="post" target="_blank">
  <button style="padding:0" type="submit" name="f" value="<?php echo $pdf[$x][0]['file_url']; ?>" class="btn-link"><i class='glyphicon glyphicon-save-file'></i> Manuscript PDF</button><br>
</form>
													<?php } ?>

													<?php if(!empty($preview[$x])){?>
<form action="<?php echo base_url().'download/'.$sub[0]['sub_id']; ?>" method="post" target="_blank">
  <button style="padding:0" ="submit" name="f" value="<?php echo $preview[$x][0]['file_url']; ?>" class="btn-link"><i class='glyphicon glyphicon-save-file'></i> Graphical Abstract - Images</button><br>
</form>
													<?php } ?>

														<a href="#" onclick="window.open('<?php echo base_url().'dashboard/cover_letter/'.$sub[0]['sub_id'].'/'.$x;?>', 'Cover Letter', 'width=600, height=800'); return false;">
														<i class='glyphicon glyphicon-save-file'></i> Cover Letter
														</a><br/>										

													<?php if($sub[0]['round'] > 1){?>
														<?php if(!empty($letter[$x])){?>
<form action="<?php echo base_url().'download/'.$sub[0]['sub_id']; ?>" method="post" target="_blank">
  <button style="padding:0" ="submit" name="f" value="<?php echo $letter[$x][0]['file_url']; ?>" class="btn-link"><i class='glyphicon glyphicon-save-file'></i> Response Letter</button><br>
</form>
														<?php } ?>
													<?php } ?>
													
													<?php if(!empty($images[$x])){ for($a=0; $a < count($images[$x]); $a++){?>
<form action="<?php echo base_url().'download/'.$sub[0]['sub_id']; ?>" method="post" target="_blank">
  <button style="padding:0" ="submit" name="f" value="<?php echo $images[$x][$a]['file_url']; ?>" class="btn-link"><i class='glyphicon glyphicon-save-file'></i> Supplementary File <?php echo "(".($a+1).")"; ?></button><br>
</form>
													<?php }} ?>
												</div>
												<div class="col-md-2">
													<!-- <button class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target="#view_review_result" data-tooltip="tooltip" title="Notes from reviewer(s)" onclick="return view_review_result('<?php echo $x.'#'.$sub[0]['sub_id'];?>')"><i class="fa fa-search"></i></button> -->
												</div>
											</div>
										<?php } ?>
									</div>							
							
									<hr/>
									<div class="form-group">
										
										<?php if(in_array(5, $this->session->userdata('role'))){?>
										    <label>Current status:</label>
										    <br><?php $this->lib_view->log_submission_status($sub[0]['sub_id'], $sub[0]['round']);?>
										<?php }else{?>
										    <label>Status history:</label>
										    <?php $this->lib_view->log_submission_status($sub[0]['sub_id'], $sub[0]['round']);?>
										<?php } 
                                            if(file_exists('uploads/submission/screening/'.$sub[0]['sub_id'].'.pdf')){
								              echo '<br><br><label>Similarity check result:</label><br><a href="'.base_url('uploads/submission/screening/'.$sub[0]['sub_id'].'.pdf').'" target="_blank">Download</a>';
								            }
										?>
									</div>
									<?php 
									$screenings = $this->lib_view->submission_screening($sub[0]['sub_id']);
									
									if (!empty($screenings)){?>
									    <?php if(in_array(5, $this->session->userdata('role'))){?>
									        <label>History:</label>
									    <?php }else{ ?>
									        <label>Detailed History:</label>
									    <?php } ?>
									<table class="table table-striped">
										<?php if(in_array(5, $this->session->userdata('role')) || in_array(6, $this->session->userdata('role'))){ ?> 
										<?php $no=0; foreach ($screenings as $sc){ $no++; 
											//if($sc['type'] > 0){ //ruki 16jun2021: ini saya disable. entah kenapa ada ini, yg mengakibatkan author tidak bisa lihat reason_back bila resultnya revise.
												$r = $sc['round'] > 1 ? '(R'.($sc['round']-1).')':'';
										?>
										<tr>
											<td>
												<!--label><a href="<?php echo site_url().'dashboard/messages/'.$sc['screening_id'];?>" data-toggle="modal" data-target="#screening-mail" onclick=""><?php echo $sc['type'] == 0 ? 'Initial Screening':'Decision '.$r;?></a></label><br/-->
												<label>
												    <?php 
												    //todo: bedakan screening by secre dan eic
												    $by = ' by Editor';
												    $isSC = $this->db->query("select count(*) x from users u join roleuser r on r.user_id = u.user_id where r.role_id = 2 and u.user_id = ? ",[$sc['user_id']])->row()->x;
												    if($isSC){
												        $by = ' by Secretariat';
												    }
												    echo $sc['type'] == 0 ? 'Initial Screening'.$by:'Decision '.$r;
												    ?>
											    </label><br/>
												Started : <?php echo date('d M Y - H:i', strtotime($sc['date_input']));?><br/>
												<?php if($sc['type'] == 0 && is_numeric($sc['similarity_rate'])){?>
												Similarity Rate : <?php echo $sc['similarity_rate'].'%';?><br/>
												<?php } ?>
												Decision : <?php echo decision_status($sc['status'], ($sc['type'] == 0 ? ($sc['eic'] == 1 ? 1 : 0) : 2));?><br/>

												<?php if(!in_array(5, $this->session->userdata('role')) && !in_array(6, $this->session->userdata('role'))){?>
														Decided by : <?php echo $this->lib_view->get_user_submit($sc['user_id']);?><br/>
												<?php } ?>
												
												Notes : <?php echo $sc['reason_back'] == '' ? '-': $sc['reason_back'];?><br/>
											</td>
										</tr>
										<?php  //}
										} ?>
										<?php }else{?>
											<?php $no=0; foreach ($screenings as $sc){ $no++; 
												$r = $sc['round'] > 1 ? '(R'.($sc['round']-1).')':'';
												?>
											<tr>
												<td>
<?php
//if ( in_array(1, $this->session->userdata('role')) ){
	$rolesPelaku = $this->db->query("select role_id from roleuser where user_id = ?",[$sc['user_id']])->result_array();
	$rolesPelaku = array_column($rolesPelaku,'role_id');
	$j = "";
	if( (in_array(3,$rolesPelaku)||in_array(4,$rolesPelaku))){ //EiC
		if( $sc['type']==0 ){
			$j .= "Screening Decision from EiC: ";
			if( $sc['status']==1 ){
				$j .= "Passed. Proceed to screening by Secretariat.";
			}elseif( $sc['status']==2 ){
				$j .= "Revision Required."; //Proceed to screening by Secretariat kah? atau langsung dikirim decision ke author?
			}elseif( $sc['status']==3 ){
				$j .= "Rejected."; //Proceed to screening by Secretariat kah? atau langsung dikirim decision ke author?
			}
		}elseif( $sc['type']==1 ){
			$j .= "Peer Review Round ".$sc['round']." Decision from EiC: ";
			if( $sc['status']==1 ){
				$j .= "Accepted."; //Proceed to inline editing atau Proceed to secretariat?
			}elseif( $sc['status']==2 ){
				$j .= "Revision Required."; //Proceed to secretariat kah? atau langsung dikirim decision ke author?
			}elseif( $sc['status']==3 ){
				$j .= "Rejected."; //Proceed to secretariat kah? atau langsung dikirim decision ke author?
			}
		}
	}elseif( (in_array(1,$rolesPelaku)||in_array(2,$rolesPelaku)) ){ //Sekre
		if( $sc['type']==0 ){
			$j .= "Screening Decision from Secretariat: ";
			if( $sc['status']==1 ){
				$j .= "Passed. Proceed to peer review.";
			}elseif( $sc['status']==2 ){
				$j .= "Revision Required. Sent back to author.";
			}elseif( $sc['status']==3 ){
				$j .= "Rejected.";
			}
		}elseif( $sc['type']==1 ){
			$j .= "Peer Review Round ".$sc['round']." Decision from Secretariat: ";
			if( $sc['status']==1 ){
				$j .= "Accepted. Proceed to inline editing.";
			}elseif( $sc['status']==2 ){
				$j .= "Revision Required. Sent back to author.";
			}elseif( $sc['status']==3 ){
				$j .= "Rejected.";
			}
		}
		//similarity rate
	}else{ //author
		if( $sc['type']==0 ){
			$j .= "Manuscript resubmitted by author. ";
			if( $sc['status']==1 ){
				$j .= "Now waiting for initial screening";
			}elseif( $sc['status']==2 ){
				$j .= "Revision Required. Sent back to author.";
			}elseif( $sc['status']==3 ){
				$j .= "Rejected.";
			}
		}elseif( $sc['type']==1 ){
		    $rnd = $sc['round']>1 ? "(Round ".$sc['round']-1 .")" : "";
			$j .= "Peer Review Decision $rnd from Secretariat: ";
			if( $sc['status']==1 ){
				$j .= "Accepted. Proceed to inline editing.";
			}elseif( $sc['status']==2 ){
				$j .= "Revision Required. Sent back to author.";
			}elseif( $sc['status']==3 ){
				$j .= "Rejected.";
			}
		}
	}
	echo date('d M Y - H:i', strtotime($sc['date_input']))."<br><b>$j</b><br>by ".$this->lib_view->get_user_submit($sc['user_id'])."<br>";
	echo is_null($sc['similarity_rate']) ? "" : "Similarity rate: ".$sc['similarity_rate'].'%<br>';
	echo $sc['reason_back'] == '' ? '': "Notes: ".$sc['reason_back']."<br>";
	if( (in_array(3,$rolesPelaku)||in_array(4,$rolesPelaku))){ //EiC
	    echo $sc['notes_from_eic'] == '' ? 'Notes from EiC to Secretariat: -': 'Notes from EiC to Secretariat: '.$sc['notes_from_eic']."<br/>";
	}
//}
/*
													<label><a href="<?php echo site_url().'dashboard/messages/'.$sc['screening_id'];?>" data-toggle="modal" data-target="#screening-mail" onclick=""><?php echo $sc['type'] == 0 ? 'Initial Screening':'Decision '.$r;?></a></label><br/>
													Date : <?php echo date('d M Y - H:i', strtotime($sc['date_input']));?><br/>
													<?php if($sc['type'] == 0){?>
													Similarity Rate : <?php echo $sc['similarity_rate'].'%';?><br/>
													<?php } ?>
													Decision : <?php echo decision_status($sc['status'], ($sc['type'] == 0 ? ($sc['eic'] == 1 ? 1 : 0) : 2));?><br/>
													
													<?php if(!in_array(5, $this->session->userdata('role')) && !in_array(6, $this->session->userdata('role'))){?>
														Decided by : <?php echo $this->lib_view->get_user_submit($sc['user_id']);?><br/>
													<?php } // ini yg muncul di sisi sekretariat ?>

													Notes : <?php echo $sc['reason_back'] == '' ? '-': $sc['reason_back'];?><br/>
													Notes from EiC to Secretariat : <?php echo $sc['notes_from_eic'] == '' ? '-': $sc['notes_from_eic'];?><br/>
*/
?>
												</td>
											</tr>
										<?php }} ?>
									</table>
									<?php } ?>

									<?php if( $sub[0]['sub_status'] == 8 && (in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role')))){ 
									  $lastAcceptDate = $this->db->query("select date_log from submission_log_status where sub_id = ? and sub_status = 8 order by date_log desc limit 1",[$sub[0]['sub_id']])->row();
									  $c_ = "";
									  $t_ = "";
									  if( isset($lastAcceptDate->date_log) && !is_null($lastAcceptDate->date_log)){
									      $c_ = " disabled ";
									      $t_ = "<br><i>(Done at ".$lastAcceptDate->date_log.")</i>";
									  }
									?>
										<div class="btn btn-primary btn-block <?=$c_?>" data-toggle="modal" data-target="#notifyAuthor">Send Acceptance Notification<?=$t_?></div>
									<?php } ?>

									<?php if($sub[0]['date_withdraw'] != NULL && $sub[0]['date_withdraw'] != '0000-00-00 00:00:00'){ ?>
										<div class="form-group" style="border-top: solid 1px #DDD; padding-top: 20px">											
											<label>Withdraw</label><br/>
											<div>
												Date : <?php echo date('d M Y - H:i', strtotime($sub[0]['date_withdraw']));?><br/>
												Reason : <?php echo !empty($sub[0]['withdraw_reason']) ? $sub[0]['withdraw_reason'] : '-----';?>
											</div>
										</div>
									<?php } ?>


									<!-- review result -->
									<?php if( ( (count($review_result) > 0 || $sub[0]['round']>1) && $sub[0]['sub_status'] >= 4 && $sub[0]['sub_status'] <= 7) && (!in_array(5, $this->session->userdata('role')) && !in_array(6, $this->session->userdata('role')))){?>
										<div class="btn btn-default btn-block" data-toggle="modal" data-target="#modalReviewResult">See Reviewers' Comments</div>
										<div class="btn btn-primary btn-block" data-toggle="modal" data-target="#decision">Give Decision</div>
									
									<?php } ?>
<div style="display:none"><?=count($review_result)?></div>
									<!-- review result -->
									<?php if($sub[0]['sub_status'] > 0 && $sub[0]['sub_status'] < 3 && !empty($letter[$sub[0]['round']]) && !in_array(5, $this->session->userdata('role')) && !in_array(6, $this->session->userdata('role'))){?>								
										<div class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalSendLetter">Proceed to Peer Review</div>
									<?php } ?>
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>

		
	</section>
</div>

<!-- modal publish -->
<div class="modal inmodal" id="modalPublish" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-book modal-icon icon"></i>
				<h4 class="modal-title set-header">Publish Manuscript</h4>
				<div class="set-header-label">Rearrangement of submission manuscript to web journal format.</div>
			</div>
			<form name="formpublish" action="<?php echo base_url().'dashboard/insert/publish ';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="sub_id" id="sub_id_publish">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<div class="msg">					
					<div class="form-group">
						<label>Manuscript Title :</label>
						<p id="manuscript_title"></p>
					</div>				
				</div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="OK" class="btn btn-success action">
			</div>
			</form>
		</div>	
	</div>
</div>

<!-- modal response letter -->
<div class="modal inmodal" id="modalSendLetter" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-envelope modal-icon icon"></i>
				<h4 class="modal-title set-header">Send Response Letter</h4>
				<div class="set-header-label">Send manuscript and response letter to related reviewer(s)</div>
			</div>
			<form name="formreviewer" action="<?php echo base_url().'dashboard/insert/send_response_letter ';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="sub_id" value="<?php echo $sub[0]['sub_id'];?>">
				<input type="hidden" name="round" value="<?php echo $sub[0]['round']; //ruki 2021-02-16 added "+1", but 2021-03-04 removed it ?>"> 
				<input type="hidden" name="author" value="<?php echo $sub[0]['user_id'];?>">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<div class="msg">					
					<table class="table table-striped">
						<tr>
							<th>Files</th>							
							<th>Date</th>
						</tr>
						<?php if(!empty($suplement)){ foreach ($suplement as $s){ 
								if(in_array($s['type'], array(4,2))){
							?>
						<tr>
							<td>
								<div><a href="<?php echo site_url().$s['file_url'];?>"><?php echo manuscript_type($s['type']);?></a> </div>
								<div><?php echo $s['file_description'];?></div>												
							</td>							
							<td><?php echo date('d M Y - H:i', strtotime($s['date_input']));?></td>										
						</tr>										
						<?php }}}else{
							echo "<tr><td colspan='3' class='text-warning'><i class='fa fa-warning'></i> No files uploaded.</td></tr>";
						} ?>
					</table>					
				</div>
				<div class="form-group">
					<label>Select Reviewer <small>(Optional)</small></label>
					<div class="note">Let it be empty to send response letter to all reviewers</div>
					<select name="sr_id[]" class="form-control select" style="width:100%" multiple>
						<?php 
							$_rev = $this->lib_view->get_reviewers($sub[0]['sub_id'], 1);
							if(!empty($_rev)){ foreach ($_rev as $r) { ?>
								<option value="<?php echo $r['sr_id'];?>"><?php echo $r['salutation'].' '.$r['fullname'];?></option>
						<?php }} ?>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="Send" class="btn btn-info action">
			</div>
			</form>
		</div>	
	</div>
</div>

<!-- modal set reviewer -->
<div class="modal inmodal" id="modalReviewer" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" style="min-width:70%;max-width:100%;">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-search modal-icon icon"></i>
				<h4 class="modal-title set-header">Floating Window</h4>
				<div class="set-header-label">Send manuscript and response letter to related reviewer(s)</div>
			</div>
			<div class="modal-body">
				<div class="reviewer-container" style="background: #fff;padding: 9px 15px;display: inline-block;border-radius: 5px;border: 1px solid #ddd;border-left: 7px solid #ccc;"></div>
				<div class="reviewer-container-check" style="color:red"></div>

				<div class="form-group search_reviewer">
					<div class="input-group">
						<input type="search" class="form-control reviewer_search_field" name="search_author" placeholder="Search existing reviewers by name, email, or expertise">
						<input type="hidden" id="sub_id_reviewer" value="<?php echo $this->uri->segment(4);?>">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-warning">Search</button>
						</span>
					</div>
				</div>
				<div class="result-reviwer"></div>
				
				<form id="formreviewer" name="formreviewer" action="<?php echo base_url().'dashboard/update/reviewer_status';?>" method="POST">
					<input type="hidden" name="sub_id" id="item_id">
					<input type="hidden" name="sr_id" id="reviewer">
					<input type="hidden" name="status" id="status">
					<div class="msg"></div>
					<div class="modal-footer">
						<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
						<input type="submit" name="move" value="Send Email" class="btn btn-info action">
					</div>
				</form>
				
				<form method="POST" id="form_manually_add_new_reviewer" action="<?php echo site_url().'dashboard/insert/reviewer';?>" style="display:none">
					<span style="color:red"><br>Not any above? Let's create new account and invite a new reviewer.</span>
					<input type="hidden" name="page" value="<?php echo current_url();?>">
					<input type="hidden" name="sub_id" value="<?php echo $this->uri->segment(4);?>">					
					<div class="form-group">
						<label>Salutation <span>*</span></label>
						<select name="salutation" class="form-control" required>
							<option value="">- Select Salutation -</option>
							<option value="Prof.">Prof.</option>
							<option value="Dr.">Dr.</option>
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
						<label>Email <span>*</span></label>
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
					<div class="modal-footer">					
						<input type="reset" name="reset" class="btn btn-default" value="Cancel" data-dismiss="modal">
						<button type="submit" name="submit" class="btn btn-primary primary"><i class="fa fa-plus-circle"></i> Create New Reviewer</button>
					</div>									
				</form>
				
			</div>
		</div>	
	</div>
</div>

<!-- modal set reviewer -->
<div class="modal inmodal" id="modalReviewResult" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-search modal-icon icon"></i>
				<h4 class="modal-title set-header">Reviewer Comments</h4>
				<div class="set-header-label">on The Last Peer Review Round</div>
			</div>		
			<div class="modal-body">
				<div class="row">
					<?php if(!empty($review_result)){ foreach($review_result as $rs){?>
					<?php
						$point = array("originality","technical","methodology","readability","practicability","organization","importance");
						$val = array("-", "poor","fair","average","above average","excellent");
					?>
					<div class="col-md-6">
						<table class="">
							<tr><td>Reviewer name</td><td><?php echo $this->lib_view->gen_name_reviewer($rs['sub_id'], $rs['reviewer_email']);?></td></tr>
							<tr><td>Email</td><td><?php echo $rs['reviewer_email'];?></td></tr>
							<tr><td>Date Review</td><td><?php echo date('d M Y - H:i', strtotime($rs['date_review']));?></td></tr>
							<tr><td valign="top">Introduction</td><td>: <?php echo strip_tags($rs['introduction_comment']);?></td></tr>
							<tr><td valign="top">Methodology</td><td>: <?php echo strip_tags($rs['methodology_comment']);?></td></tr>
							<tr><td valign="top">Results and Discussion</td><td>: <?php echo strip_tags($rs['result_comment']);?></td></tr>
							<tr><td valign="top">References</td><td>: <?php echo strip_tags($rs['references_comment']);?></td></tr>
							<tr><td valign="top">Other</td><td>: <?php echo strip_tags($rs['other_comment']);?></td></tr>
							<tr><td colspan="2">
								<table class="table table-bordered table-striped">
								<?php for($a=0; $a<count($point); $a++){?>
								<tr><td width="100"><?php echo ucwords($point[$a]);?></td><td><?php echo isset($rs[$point[$a]]) ? $rs[$point[$a]]."<i> (".$val[$rs[$point[$a]]].")</i>":'';?></td></tr>	
								<?php } ?>
								</table>
							</td></tr>
							
							<tr><td>Other Comment:</td><td><?php echo $rs['additional_comment'];?></td></tr>
							<tr><td>Attachment File:<br/>
								<?php if($rs['review_url'] != ""){?>
								<a href="<?php echo site_url().$rs['review_url'];?>">Review Attachment</a>
								<?php }else{ echo "-"; } ?>
							</td></tr>
							<tr><td>Reviewer suggestion:</td><td><?php echo review_result($rs['review_result']);?></td></tr>
						</table>
					</div>
					<?php }}else{ ?>
						<div class="callout callout-info">
							<i class="fa fa-info-circle"></i> Waiting review from suggested reviewer.
						</div>
					<?php } ?>
					
				</div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Close" class="btn btn-white" data-dismiss="modal">				
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal" id="view_review_result" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-edit modal-icon icon"></i>
				<h4 class="modal-title set-header">Review Result</h4>
				<div class="set-header-label">Notes from reviewer(s).</div>
			</div>		
			<div class="modal-body">
				<!-- Review Result  -->
				<div class="row" id="reviewResultData"></div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Close" class="btn btn-white" data-dismiss="modal">				
			</div>			
		</div>	
	</div>
</div>

<!-- send acceptance notification / Ruki25feb2019-->
<div class="modal inmodal" id="notifyAuthor" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-edit modal-icon icon"></i>
				<h4 class="modal-title set-header">Send Notification</h4>
			</div>		
			<form action="<?php echo site_url().'dashboard/update/editor_decision';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="sub_id" value="<?php echo $sub[0]['sub_id'];?>">
				<input type="hidden" name="round" value="<?php echo $sub[0]['round'];?>">
				<input type="hidden" name="author" value="<?php echo $sub[0]['user_id'];?>">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<div class="form-group" style="display:none">
					<label>Decision <span>*</span></label>
					<select name="status" class="form-control decision-modal" required>
						<option value="1" selected>Accept</option>
					</select>
				</div>
				<div class="form-group" id="decision-modal-s" style="display:none">
					<label>Notes</label><br/>
					<textarea name="other" class="form-control" placeholder="Put your notes here."></textarea>
				</div>
				<div class="form-group">
					<label><input type="checkbox" name="isNotifyAuthor" value="1" checked />
					Email decision to author</label><br>  <!-- ruki 27nov2018: karena kalau utk special issue/edition, layout editing akan ditangani IJTech, jadi user tidak perlu milih (sementara template email yg dikirim ada pilihannya). jadi utk special issue, sekretariat harus kirim email manual -->
					<label><input type="checkbox" name="isNotifyInvolvedReviewers" value="1" checked />
					Notify involved reviewers (Warning: only if the decision is Accept or Reject)</label>
				</div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Close" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="Send" class="btn btn-info action">
			</div>			
			</form>
		</div>	
	</div>
</div>

<!-- modal decision -->
<div class="modal inmodal" id="decision" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-edit modal-icon icon"></i>
				<h4 class="modal-title set-header">Decision for review round <?=$sub[0]['round'];?></h4>
				
				<div class="set-header-label" style="color:red">Danger: Becareful because maybe a decision for this review round is already sent!</div>
			</div>		
			<form action="<?php echo site_url().'dashboard/update/editor_decision';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="sub_id" value="<?php echo $sub[0]['sub_id'];?>">
				<input type="hidden" name="round" value="<?php echo $sub[0]['round'];?>">
				<input type="hidden" name="author" value="<?php echo $sub[0]['user_id'];?>">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<div class="form-group">
					<label>Decision <span>*</span></label>
					<select name="status" class="form-control decision-modal" required>
						<option value="">- Select Decision -</option>
						<option value="1">Accept</option>
						<option value="2">Revise</option>
						<option value="3">Reject</option>
					</select>
				</div>
				<div class="form-group" id="decision-modal-s">
					<label>Notes</label><br/>
					<textarea name="other" class="form-control" placeholder="Please put your notes here."></textarea>
				</div>
				<div class="form-group" id="revise_days" style="display: none">
					<!-- reviso -->
					<label>Time for revision (days)</label>
					<div class="note">Let this empty for unlimited revision time.</div>
					<input type="number" name="revise_days" min="1" max="30" class="form-control" placeholder="Time given to author to revise the manuscript (days)">
				</div>
<?php if (in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role'))){ ?>
				<div class="form-group">
					<label><input type="checkbox" name="isNotifyAuthor" value="1" checked />
					Email decision to author</label><br>  <!-- ruki 27nov2018: karena kalau utk special issue/edition, layout editing akan ditangani IJTech, jadi user tidak perlu milih (sementara template email yg dikirim ada pilihannya). jadi utk special issue, sekretariat harus kirim email manual -->
					<label><input type="checkbox" name="isNotifyInvolvedReviewers" value="1" checked />
					Notify involved reviewers (Warning: only if the decision is Accept or Reject)</label>
				</div>
<?php } ?>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Close" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="Save Decision" class="btn btn-info action">
			</div>			
			</form>
		</div>	
	</div>
</div>

<!-- modal set reviewer -->
<!--div class="modal inmodal" id="modalNewReviewer" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-md" style="width:90%">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-zoomin modal-icon icon"></i>
				<h4 class="modal-title set-header">Add a candidate reviewer</h4>
				<div class="set-header-label">Don't forget to send invitation after clicking "Add" below.</div> 
			</div>			
			<div class="modal-body">				
				<div class="form-group">
					<label>Find existing reviewer</label>
					<div class="input-group">
						<input type="search" class="form-control reviewer_search_field" name="search_author" placeholder="Type name, email or expertise">
						<input type="hidden" id="sub_id_reviewer" value="<?php echo $this->uri->segment(4);?>">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-warning">Search</button>
						</span>
					</div>
				</div>
				<div class="result-reviwer">
				</div>
				<h2 class="hrtext"><span>OR</span></h2>
			</div>			
			</form>
		</div>	
	</div>
</div-->

<!-- modal revise agreement -->
<div class="modal inmodal" id="revise-agreement" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-question-circle modal-icon"></i>
				<h4 class="modal-title">Confirmation</h4>
				<div>Agree to revise manuscript?</div>
			</div>
			<form name="revise_agreement-form" action="<?php echo base_url().'dashboard/update/revise_agreement';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="sub_id" id="sub_item_id">
				<input type="hidden" name="round" id="round">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<div class="msg">If you want to revise your manuscript, please click <b>Yes</b>.<br/>
				Otherwise, click <b>No</b> to discontinue the submission process and withdraw the manuscript.</div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" class="btn btn-default pull-left" value="Cancel" data-dismiss="modal">
				<input type="submit" name="action" value="No" class="btn btn-danger">
				<input type="submit" name="action" value="Yes" class="btn btn-success action">
			</div>
			</form>
		</div>	
	</div>
</div>

<!-- modal revise agreement -->
<div class="modal inmodal" id="screening-mail" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-body">
				
			</div>
					
		</div>	
	</div>
</div>


<!-- modal revise agreement -->
<div class="modal inmodal" id="modalReviewHistory" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" style="min-width:70%;max-width:100%;">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-clock-o modal-icon"></i>
				<h4 class="modal-title">Review History</h4>
				<!--div>Review manuscript.</div-->
			</div>
			<div class="modal-body" id="contentReviewHistory">
				
			</div>
		</div>	
	</div>
</div>