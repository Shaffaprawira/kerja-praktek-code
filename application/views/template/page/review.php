<div class="content-wrapper">
	<section class="content-header">
		<h1>Journal Review</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/submission';?>">Review</a></li>
			<li class="active"><?php echo strlen($title) > 50 ? ucwords(substr($title, 0 ,50)).'...': ucwords($title);?></li>
		</ol>
	</section>
	<section class="content">
		<input type="hidden" name="sub_id" value="<?php echo $sub[0]['sub_id'];?>">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp;Journal Review</h3>
					</div>
					<div class="box-body">
						<div class="<?php echo isset($review[0]) && $review[0]['review_result'] == NULL ? 'col-md-6':'col-md-12';?>" style="border-right: solid 1px #DDD">
						<?php if($this->uri->segment(4) == 'online'){ 
							$val = array(1 => 'Poor', 2 => 'Fair', 3 => 'Average', 4 => 'Above Average', 5 => 'Excellent');
							$point = array('Originality','Technical','Methodology','Readability','Practicability','Organization','Importance');
						?>
						<?php }else{?>

							<div class="form-group">
								<label>Manuscript Submission Date:</label>
								<p><?php echo date('d M Y - H:i', strtotime($sub[0]['date_submit']));?></p>
							</div>						
							<div class="form-group">
								<label>Title:</label>
								<p><?php echo $sub[0]['sub_title'];?></p>
							</div>						
							<div class="form-group">
								<label>Abstract:</label>
								<p><?php echo $sub[0]['abstract'];?></p>
							</div>
							
							<hr/>
							
<?php if(isset($verification)){ echo $verification; }else{ ?>

							<?php if (isset($review[0]) && $review[0]['review_result'] == NULL){ 
								$val = array(1 => 'Poor', 2 => 'Fair', 3 => 'Average', 4 => 'Above Average', 5 => 'Excellent');
								$point = array('Originality','Technical','Methodology','Readability','Practicability','Organization','Importance');
								?>
							
								<form action="<?php echo site_url().'dashboard/insert/review';?>" method="POST" enctype="multipart/form-data">
									<input type="hidden" name="review_id" value="<?php echo $review[0]['review_id'];?>">
									<input type="hidden" name="sub_id" value="<?php echo $sub[0]['sub_id'];?>">
									<input type="hidden" name="page" value="<?php echo current_url();?>">
									<input type="hidden" name="review_type" value="0">
									<input type="hidden" name="reviewer_email" value="<?php echo $this->session->userdata('email');?>">							
									<h3>Review Form</h3>
									<div class="form-group">
										<label>Comment for Introduction section <span>*</span></label>
										<textarea name="introduction_c" class="form-control " required><?php echo nl2br(strip_tags($review[0]['introduction_comment']));?></textarea>
									</div>
									<div class="form-group">
										<label>Comment for Methodology section <span>*</span></label>
										<textarea name="methodology_c" class="form-control " required><?php echo nl2br(strip_tags($review[0]['methodology_comment']));?></textarea>
									</div>
									<div class="form-group">
										<label>Comment for Results and Discussion section <span>*</span></label>
										<textarea name="result_c" class="form-control " required><?php echo nl2br(strip_tags($review[0]['result_comment']));?></textarea>
									</div>							
									<div class="form-group">
										<label>Comment for Bibliography/References section <span>*</span></label>
										<textarea name="references_c" class="form-control " required><?php echo nl2br(strip_tags($review[0]['references_comment']));?></textarea>
									</div>
									<div class="form-group">
										<label>Comment for other section (if any)</label>
										<textarea name="other_c" class="form-control "><?php echo nl2br(strip_tags($review[0]['other_comment']));?></textarea>
									</div>
									<?php for($a=0; $a< count($point); $a++){?>
									<div class="form-group" style="border-bottom: solid 1px #DDD;">
										<label><?php echo $point[$a];?> <span> *</span></label><br/>
										<div class="row">
											<?php for($x=1; $x<= count($val); $x++){?>									
											<div class="col-md-<?php echo $x > 3 ? '3':'2';?>">
												<label>
													<input type="radio" class="flat-red-disabled" name="<?php echo strtolower($point[$a]);?>" value="<?php echo $x;?>" id ="<?php echo $point[$a].'_'.$x;?>" required <?php echo $review[0][strtolower($point[$a])] == $x ? 'checked="checked"':'';?>>
													<span style="font-weight: normal; color:#222"><?php echo $val[$x];?></span>
												</label>
											</div>
											<?php } ?>
										</div>
									</div>

									<?php } ?>
									<div class="form-group">
										<label>Other Comment (if any)</label>
										<textarea name="additional_c" class="form-control "><?php echo nl2br(strip_tags($review[0]['additional_comment']));?></textarea>
									</div>
									<div class="form-group">
										<label>Attachment File (optional)</label> <small>Allowed file : PDF</small><br/>
										<?php if($this->session->flashdata('message') !== ""){;?>
											<span class="text-danger"><?php echo $this->session->flashdata('message');?></span>
										<?php } ?>
										<input type="file" name="userfile" class="btn btn-default">
									</div>
									
									<input type="hidden" name="round" value="<?php echo $sub[0]['round'];?>">
									<div class="form-group">
										<label>Suggested Decision <span>*</span></label>
										<select name="review_result" class="form-control" required <?php //echo $this->lib_view->check_enable_decision_review($sub[0]['sub_id'], $sub[0]['round']) ? '':'disabled';?>>
											<option value="">- Select Decision -</option>
											<option value="1" <?php echo $review[0]['review_result'] == 1 ? 'selected':'';?>>Accept</option>
											<option value="2" <?php echo $review[0]['review_result'] == 2 ? 'selected':'';?>>Revise</option>
											<option value="3" <?php echo $review[0]['review_result'] == 3 ? 'selected':'';?>>Reject</option>
										</select>
									</div>
<div class="form-group">
    <label>
        <input value="1" type="hidden" name="canInviteAgain" />
        <!-- input value="1" type="checkbox" name="canInviteAgain" checked> I am willing to review the revised version of this article if required.</label><br-->
    <label><input value="1" type="checkbox" name="canListAck"    > If this article is published, I allow my name to be listed as contributing reviewers, if editor decides to do so.</label>
</div>
									<!--div class="form-group">
										<button class="btn btn-primary" <?php //echo $this->lib_view->check_enable_decision_review($sub[0]['sub_id'], $sub[0]['round']) ? '':'disabled';?>><i class="fa fa-send"></i> Send Review to Editor</button> <!-- enable this when reviewer has not save any review/comments -->
									</div-->
									
									<div class="form-group box-footer">
										<input type="submit" class="btn btn-primary pull-right" value="Save">
										<input type="reset" name="reset" class="btn btn-default pull-left" value="Cancel">
									</div>
								</form>
								
								<!--h2>Review Action:</h2>
								<div class="form-group">
									<label>Online Review Form <span>*</span></label>
									<p>Please goto online review form to start review to activate <code>Review Decission</code> <a href="<?php echo site_url().'dashboard/review/'.$sub[0]['sub_id'].'/online';?>">Online Review Form</a></p>
								</div>
								
								<hr/-->
																
							<?php }else{ //if review result is not null (reviewer udah ngisi form) ?> 
								<div class="form-group">
									<h3>Reviews and Comments</h3>
									<p><?php echo review_result($review[0]['review_result']);?></p>
									<?php 
										$point = array("originality","technical","methodology","readability","practicability","organization","importance");
										$val = array("-", "poor","fair","average","above average","excellent");
									?>
									<table class="table">
									<?php foreach ($review as $rs) {?>
										<tr><td><b>Review completed at:</b><br/><?php echo date('d M Y - H:i', strtotime($rs['date_review']));?></td></tr>
										<!-- tr style="background: #FFFFDD"><th>Section I</th><td>: Comments per section of Manuscript</td></tr -->
										<tr><td><b>Comments for Introduction section:</b><br/> <?php echo nl2br(strip_tags($rs['introduction_comment']));?></td></tr>
										<tr><td><b>Comments for Methodology: </b><br/><?php echo nl2br(strip_tags($rs['methodology_comment']));?></td></tr>
										<tr><td><b>Comments for Results and Discussion: </b><br/><?php echo nl2br(strip_tags($rs['result_comment']));?></td></tr>
										<tr><td><b>Comments for References: </b><br/><?php echo nl2br(strip_tags($rs['references_comment']));?></td></tr>
										<tr><td><b>Comments for other section (if any): </b><br/><?php echo nl2br(strip_tags($rs['other_comment']));?></td></tr>
										<!-- tr style="background: #FFFFDD"><th>Section II</th><td>: Rate Quality (1-5)</td></tr -->
										<tr><td colspan="2">
											<table class="table table-bordered table-striped">
											<?php for($a=0; $a<count($point); $a++){?>
											<tr><td width="100"><?php echo ucwords($point[$a]);?></td><td><?php echo isset($rs[$point[$a]]) ? $rs[$point[$a]]."<i> (".$val[$rs[$point[$a]]].")</i>":'';?></td></tr>	
											<?php } ?>
											</table>
										</td></tr>										
										<tr><td><b>Additional Comment:</b><br/><?php echo nl2br(strip_tags($rs['additional_comment']));?></td></tr>
										<tr><td><b>Uploaded Attachment:</b><br/>
											<?php if($rs['review_url'] != ""){?>
											<a href="<?php echo site_url().$rs['review_url'];?>">Review Attachment</a>
											<?php }else{ echo "-"; } ?>
										</td></tr>
                                        <!--tr><td><b>Additional statements:</b><br/>
                                        	<?=$rs['canInviteAgain']==1?'<p>I am willing to review the revised version of this article if required.</p>':''?>
                                        	<?=$rs['canListAck']==1?'<p>If this article is published, I allow my name to be listed as contributing reviewers at the issue where this article is published.</p>':''?>
                                        </td></tr-->
									<?php } ?>
									</table>
								</div>
							<?php } ?>
						<?php }} ?>
						</div>

						<?php if (isset($review[0]) && $review[0]['review_result'] == NULL){ //jika udh ada review result, ga usah tampilkan artikel ?>
							<div class="col-md-6">
								<div class="form-group">
									<label>Manuscript</label><br/>
									<iframe src="<?php echo site_url().$pdf[0]['file_url'];?>" frameborder="0" height="500" width="100%"></iframe>
								</div>

								<div class="form-group">
									<label>Manuscript</label>
									<?php if(!empty($pdf)){?>
									<p>
										<a href="<?php echo base_url().$pdf[0]['file_url'];?>">
										<?php $filename = explode('/', $pdf[0]['file_url']);
										echo "<i class='glyphicon glyphicon-save-file'></i> ".$filename[count($filename)-1];
										?></a><br/>								
									</p>
									<?php } ?>
								</div>
								<div class="form-group">
									<?php if(!empty($letter)){?>
									<label>Response Letter</label>
									<p>
										<a href="<?php echo base_url().$letter[0]['file_url'];?>">
										<?php $filename = explode('/', $letter[0]['file_url']);
										echo "<i class='glyphicon glyphicon-save-file'></i> Response Letter";
										?></a><br/>								
									</p>
									<?php } ?>
								</div>
								
								<?php if(!empty($supplementaryFiles)){ ?>
									<div class="form-group">
										<label>Supplementary File(s)</label><br>
										<?php foreach($supplementaryFiles as $sf){ ?>
											<a href='<?=base_url().$sf['file_url']?>' target='_blank'>
												<?php $filename = explode('/', $sf['file_url']); echo "<i class='glyphicon glyphicon-save-file'></i> ".$filename[count($filename)-1]; ?>
											</a><br>
										<?php } ?>
									</div>
								<?php } ?>
								
								<?php if(!empty($graphicalAbstract)){ ?>
									<div class="form-group">
										<label>Graphical Abstract</label><br>
										<small>(will be used as thumbnail in the web page when this manuscript is published)</small><br>
										<a href='<?=base_url().$graphicalAbstract[0]['file_url']?>' target='_blank'>
											<i class='glyphicon glyphicon-save-file'></i> Image
										</a><br>
									</div>
								<?php } ?>
								
								<hr/>
								<!-- div class="form-group">
									<label>Editor in Charge:</label>
									<div class="list-group">
										<?php $editor = $this->lib_view->get_section_editor($sub[0]['section_id']); if(!empty($editor)){							
											foreach ($editor as $e){?>
											<div class="list-group-item"><?php echo $e['first_name'].' '.$e['last_name'];?></div>
										<?php } } ?>	
									</div>
								</div -->
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
