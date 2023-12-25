<?php
$currentURL = current_url();
$params     = $_SERVER['QUERY_STRING'];
$fullURL = $currentURL . '?' . $params; 
?>

<div class="content-wrapper">
	<section class="content-header">
		<h1>Online <small>Submission</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/submission';?>"> Submission</a></li>
			<li class="active">All Submission</li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp; Submission <?php echo $sts !== null ? '<small><i>Status: '.submission_status($sts).'</small></i>':'';?></h3>
				<div class="box-tools pull-right">
					<?php if (in_array(5, $this->session->userdata('role'))){?>
						<a class="btn btn-primary btn-sm" href="<?php echo base_url().'dashboard/create/submission';?>" data-tooltip="tooltip" title="Submit new article"><i class="fa fa-plus-circle"></i></a>
					<?php }
          if (in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role')) || in_array(3, $this->session->userdata('role')) || in_array(4, $this->session->userdata('role'))){ //ruki: if admin, secre, editor, or sec editor ?>
						<a class="btn btn-danger btn-sm" href="https://ijtech.eng.ui.ac.id/public/PanduanEiCmeRejectArticle.pdf" target="_blank"><i class="fa fa-warning"></i> Guideline for rejecting paper</a> &nbsp; 
						<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalStepInfo"  data-tooltip="tooltip" title="Info about each step in article processing"><i class="fa fa-info-circle"></i> Article steps info</a>
          <?php } ?>
				</div> 
			</div>
			<div class="box-body" style="overflow:scroll">
				<?php $no = $offset; ?>
        
        
				<div class="row" style="background-color: #f4f4f4;padding-top: 10px;margin:5px; border:solid 1px #EEE">
					<div class="col-md-6">
						<div class="form-group">
							<label>Total : </label> <span><?php echo isset($total) ? $total : 0;?> Records</span>
							<p><?php echo 'Showing '.($no+1).' to '.($no+$perpage).' entries';?></p>
						</div>
					</div>
					<?php
						$_url = explode('/page/', current_url());
						$url = $_url[0].'/page/1';
					?>
					<div class="col-md-6">
						<form method="GET" action="<?php echo $url;?>">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon" data-tooltip="tooltip" data-title="You can search by manuscript's title, author's firstname or lastname. For searching the manuscript's number ID, please add prefix ID, Ex: id:123"><i class="fa fa-question"></i></span>
									<input type="search" name="q" class="form-control" placeholder="Type keyword and press enter" value="<?php echo isset($keyword) ? $keyword :'';?>">
									<span class="input-group-addon"><i class="fa fa-search"></i></span>
								</div>
							</div>
						</form>
					</div>
				</div>

				<table  class="table table-striped table-hover data-tables">
				<thead>
					<th>No.</th>
					<th title="The latest submission date (note that article may have been resubmitted after being sent back in initial screening). Red means it is older than 100 days." >Date <span class="badge badge-secondary" style="cursor:help"><small class="fa fa-info"></small></span></th>
					<th>Manuscript ID</th>
					<th>Authors</th>
					<th>Title</th>
					<?php if($this->uri->segment(3) == 'issue'){?>
						<th width="100">Pages</th>					
					<?php } ?>
					<th>Status</th>
					<th width="150">Action</th>
				</thead>
				<tbody>
				<?php  
					if(!empty($submission)){ 						
						foreach($submission as $a){ $no++; 
						if(isset($a['abv'])){
						    $journal_id = ($a['round'] > 1 ? '<span class="label alert-danger">R'.($a['round']-1).'</span>-':'').$a['abv'].'/'.$a['section_abv'].'-'.$a['sub_id'];
						    $journal_id_clean = ($a['round'] > 1 ? 'R'.($a['round']-1).'-':'').$a['abv'].'/'.$a['section_abv'].'-'.$a['sub_id'];
						}else{
						    $journal_id = ($a['round'] > 1 ? '<span class="label alert-danger">R'.($a['round']-1).'</span>-':'').'/'.$a['section_abv'].'-'.$a['sub_id'];
						    $journal_id_clean = ($a['round'] > 1 ? 'R'.($a['round']-1).'-':'').'/'.$a['section_abv'].'-'.$a['sub_id'];
						}
						
				?>
				<tr style="<?php echo $a['sub_status'] == 7 && in_array(5, $this->session->userdata('role')) ? 'background: #FFFFDD':'';?>">
					<td><?php echo $no;?></td>
					<td width="150"
						<?php
							if(!is_null($a['date_submit']) && $a['date_submit'] != '0000-00-00 00:00:00'){
							    //echo ' data-a="a" ';
								if(strtotime($a['date_submit']) < strtotime('-100 days')){
									echo ' style="color:red" ';
								}
							}
							//echo ' data-test="'.date('Y-m-d', strtotime($a['date_submit'])).' '.date('Y-m-d',strtotime('-100 days')).'" ';;
						?>
					><?php 
					    //echo $a['date_submit'] == '0000-00-00 00:00:00' ? 'Draft': ($this->lib_view->first_submit_date($a['sub_id']) ? date('d M Y - H:i', strtotime($this->lib_view->first_submit_date($a['sub_id']))):'Data migration');
					    echo ($a['date_submit'] == '0000-00-00 00:00:00' or is_null($a['date_submit']) or $a['date_submit']=='' or $a['date_submit']==null or $a['date_submit']<'2000-01-01 00:00:00') ? 'Draft': ($this->lib_view->first_submit_date($a['sub_id']) ? date('d M Y - H:i', strtotime($a['date_submit'])):'Data migration');
					?></td>
					<td width="150"><?php echo $journal_id;?></td>
					<td><?php echo $this->lib_view->author_submission($a['sub_id']);?></td>
					<?php if($a['sub_status'] == 9 && (in_array(2, $this->session->userdata('role')))) {?>
					<td><a href="<?php echo site_url().'dashboard/detail/journal/'.$a['sub_id'];?>"><?php echo $a['sub_title'];?></td>
					<?php }else{?>
					<td><a href="<?php echo site_url().'dashboard/detail/submission/'.$a['sub_id'];?>"><?php echo $a['sub_title'];?></td>
					<?php } ?>

					<?php if($this->uri->segment(3) == 'issue'){?>
					<td><?php echo $a['pages'];?></td>
					<?php } ?>

					<td>
						<?php
							if (in_array(5, $this->session->userdata('role'))){ //author
								echo $this->lib_view->log_submission_status($a['sub_id'], $a['round']);
							}else{
								if($a['sub_status'] == 7){
									echo $this->lib_view->check_revise($a['sub_id']);
								}else{
									echo submission_status($a['sub_status'], $a['round']);
									echo $a['sub_status'] == 10 ? ' (Rejected)':'';
								}
							}
						?>
					</td>
					<td width="100">
						<span class="btn-group">
							<?php if($a['sub_status'] != 0){?>								
								<a href="<?php echo site_url().'dashboard/detail/submission/'.$a['sub_id'];?>" class="btn btn-sm btn-default" data-tooltip="tooltip" title="Detail Submission"><i class="fa fa-search-plus"></i></a>
							<?php } ?>

							<?php if(in_array(5, $this->session->userdata('role')) && ($a['sub_status'] == 0 || $a['sub_status'] == 7)){ //incomplete | need revision (from either IS or PR)
								$screening = $this->lib_view->submission_screening($a['sub_id'], $a['round']);
								if(!empty($screening) && $screening[count($screening)-1]['author_respond'] == 0){ ?>
									<a href="#" class="btn btn-sm btn-info" data-tooltip="tooltip" title="Revise Submission" data-toggle="modal" data-target="#revise-agreement" onclick="return revise_agreement('<?php echo $a['sub_id'].'#'.$a['round'];?>')"><i class="fa fa-edit"></i></a>
								<?php }else{?>
								    <?php if($a['sub_status'] == 7){ ?>
									    <a href="<?php echo site_url().'dashboard/edit/submission/'.$a['sub_id'];?>" class="btn btn-sm btn-info" data-tooltip="tooltip" title="Revise Submission"><i class="fa fa-edit"></i></a>
									<?php }else{ ?>
									    <a href="<?php echo site_url().'dashboard/edit/submission/'.$a['sub_id'];?>" class="btn btn-sm btn-warning" data-tooltip="tooltip" title="Edit Submission"><i class="fa fa-edit"></i></a>
									<?php } ?>
								<?php } ?>
							<?php } ?>
							
							<?php if($a['sub_status'] == 0){?>
								<a class="btn btn-sm btn-danger" href="#" data-tooltip="tooltip" title="Delete Submission" data-toggle="modal" data-target="#modalDelete" onclick="return delete_submission('<?php echo $a['sub_id'];?>')"><i class="fa fa-trash"></i></a>
							<?php } ?>

							<?php if(in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role'))) {?>
								
								<?php if($a['sub_status'] == 8 || $a['sub_status'] == 12){?>
									
									<a class="btn btn-sm btn-success" href="#" data-tooltip="tooltip" title="Publish Manuscript" data-toggle="modal" data-target="#modalPublish" onclick="return prepare_publish('<?php echo $a['sub_id'];?>')"><i class="fa fa-sign-out"></i></a>
								
								<?php } ?>
								

								<?php if($a['sub_status'] == 11 || $a['sub_status'] == 9){?>
									<a class="btn btn-sm btn-success" href="<?php echo site_url().'dashboard/'.( (isset($a['read_ethics']) && ($a['read_ethics'] == 0) && (isset($a['not_publish']) && ($a['not_publish'] == 0)) ? 'migrate':'process')).'/'.$a['sub_id'];?>" data-tooltip="tooltip" title="Continue Process Manuscript"><i class="fa fa-sign-out"></i></a>
								<?php } ?>
							<?php } ?>
							
							<?php if(in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role')) ){ ?>
								<?php if ($a['sub_status'] != 99){?>
									<a href="#" data-tooltip="tooltip" data-toggle="modal" data-target="#modalWithDraw" title="Withdraw Manuscript" class="btn btn-sm btn-warning" onclick="return withdraw('<?php echo $a['sub_id'].'#'.strtolower(substr(str_replace(array('"',"'"),'',$a['sub_title']),0,30)).'...#'.$journal_id_clean;?>')"><i class="fa fa-exclamation-circle"></i></a>
								<?php } ?>

								<a class="btn btn-sm btn-danger" href="#" data-tooltip="tooltip" title="Delete Submission" data-toggle="modal" data-target="#modalDelete" onclick="return delete_submission('<?php echo $a['sub_id'];?>')"><i class="fa fa-trash"></i></a>
								<?php if ($a['sub_status'] == 9 ){ //atau status = 11 kah? ?>
									<a class="btn btn-sm btn-primary" href="#" data-tooltip="tooltip" title="Erratum/Corrigendum" data-toggle="modal" data-target="#modalErratum" onclick="return erratum('<?php echo $a['sub_id'];?>')">E</a> <!-- Ruki16feb2019 -->
								<?php } ?>
							<?php } ?>
							
						</span>
					</td>
				</tr>
				<?php }}else{?>
				<tr><td colspan="7">No data available in table</td>
				<?php } ?>
				</tbody>
				</table>
				<?php echo $paging;?>
			</div>
		</div>
	</section>
</div>


<!-- modal delete -->
<div class="modal inmodal" id="modalDelete" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-trash modal-icon"></i>
				<h4 class="modal-title">Delete Submission</h4>
				<div>Remove submission from list.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/delete/submission';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<input type="hidden" name="sub_id" id="item_id">
				<div class="msg"></div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="Remove" class="btn btn-danger action">
			</div>
			</form>
		</div>	
	</div>
</div>

<!-- modal withdraw -->
<div class="modal inmodal" id="modalWithDraw" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-exclamation-circle modal-icon"></i>
				<h4 class="modal-title">Withdraw Submission</h4>
				<div class="wdmid"></div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/update/submission_withdraw';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<input type="hidden" name="sub_id" id="wdsub_id">
				<div class="wdmsg"></div>
				<div class="form-group">
					<label>Tell us the reason <i class="fa fa-question-circle"></i></label>
					<textarea name="reason" class="form-control" rows="3" placeholder="Reason withdraw manuscript"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="Confirm" class="btn btn-danger action">
			</div>
			</form>
		</div>	
	</div>
</div>

<!-- modal Erratum - Ruki16feb2019 -->
<div class="modal inmodal" id="modalErratum" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-exclamation-circle modal-icon"></i>
				<h4 class="modal-title">Add/Remove Erratum/Corrigendum</h4>
				<div class="wdmid"></div>
			</div>
			<form name="formErratum" action="<?php echo base_url().'dashboard/update/submission_erratum';?>" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
				<input type="hidden" name="page" value="<?php echo $fullURL;?>">
				<input type="hidden" name="sub_id" id="ersub_id">
				Click <b>Save</b> to add or modify existing erratum/corrigendum (if any).<br>
				Click <b>Clear</b> to remove existing erratum/corrigendum (if any).<br>
				Publication date of the erratum/corrigendum will be updated each time you click <b>Save</b><br>
				<a id="ersub_link" href="#" target="_blank">See if this article has erratum/corrigendum</a>.<br><br>
				<div class="form-group">
					<label>Add/Replace File (PDF)</label>
					<input type="file" name="userfile" class="btn btn-default btn-block fileupload">
				</div>
				<div class="form-group">
					<label>Type</label>
					<select name="type">
						<option value="Erratum">Erratum</option>
						<option value="Corrigendum">Corrigendum</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<input type="submit" name="clear" value="Clear" class="btn btn-white action">
				<input type="submit" name="save" value="Save" class="btn btn-success action">
			</div>
			</form>
		</div>	
	</div>
</div>

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
				Otherwise, please click <b>No</b> and this manuscript will be withdrawn.</div>
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

<!-- modal status -->
<div class="modal inmodal" id="modalStatus" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-check-circle modal-icon"></i>
				<h4 class="modal-title">Status User</h4>
				<div>Active or inactive user status.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/update/user_status';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="user_id" id="user_id_status">
				<input type="hidden" name="status" id="status">
				<div class="msg"></div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="Change" class="btn btn-warning action">
			</div>
			</form>
		</div>	
	</div>
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

<!-- modal publish -->
<div class="modal inmodal" id="modalInline" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-edit modal-icon icon"></i>
				<h4 class="modal-title set-header">Inline Editing</h4>
				<div class="set-header-label">Send confirmation about inline editing process.</div>
			</div>
			<form name="formpublish" action="<?php echo base_url().'dashboard/update/inline_editing ';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="sub_id" id="sub_id_inline">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<div class="msg">					
					<div class="form-group">
						<label>Manuscript Title :</label>
						<p id="manuscript_title_inline"></p>
						<p class="callout callout-default"><i class="fa fa-info-circle"></i> Send confirmation about inline editing process to corresponding author?</p>
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

<!-- modal info article processing steps (ruki) -->
<div class="modal inmodal" id="modalStepInfo" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<h4 class="modal-title"><i class="fa fa-info-circle"></i> Steps in article processing</h4>
				<!--div>All published articles must have completed all of these steps:</div-->
			</div>
			<div class="modal-body">
        <!--table cellspacing="1">
          <tr><td valign="top">1</td><td valign="top"><span class="badge label-info">Screening by eic</span></td><td>All articles in this steps is....</td></tr>
          <tr><td valign="top">2</td><td valign="top"><span class="badge bg-blue">Screening by secret</span></td><td>All articles in this steps is hono coroko doto sowolo podo joyonyo mogo botongo</td></tr>
          <tr><td valign="top">3</td><td valign="top"><span class="badge bg-yellow">Review Assignment</span></td><td>All articles in this steps is hono coroko doto sowolo podo joyonyo mogo botongo</td></tr>
          <tr><td valign="top">4</td><td valign="top"><span class="badge bg-green">Review Process</span></td><td>All articles in this steps is hono coroko doto sowolo podo joyonyo mogo botongo</td></tr>
          <tr><td valign="top">5</td><td valign="top"><span class="badge bg-yellow">Reviewe Received</span></td><td>All articles in this steps is hono coroko doto sowolo podo joyonyo mogo botongo</td></tr>
          <tr><td valign="top">6</td><td valign="top"><span class="badge bg-yellow">Revision Process</span></td><td>All articles in this steps is hono coroko doto sowolo podo joyonyo mogo botongo</td></tr>
          <tr><td valign="top">7</td><td valign="top"><span class="badge bg-green">Accepted</span></td><td>All articles in this steps is hono coroko doto sowolo podo joyonyo mogo botongo</td></tr>
          <tr><td valign="top">8</td><td valign="top"><span class="badge label-info">Inline Editing</span></td><td>All articles in this steps is hono coroko doto sowolo podo joyonyo mogo botongo</td></tr>
          <tr><td valign="top">9</td><td valign="top"><span class="badge bg-blue">In Press</span></td><td>All articles in this steps is hono coroko doto sowolo podo joyonyo mogo botongo</td></tr>
          <tr><td valign="top">10</td><td valign="top"><span class="badge bg-red">Archive</span></td><td>All articles in this steps is hono coroko doto sowolo podo joyonyo mogo botongo</td></tr>
        </table-->
        <ol>
          <li><span class="badge label-info">Screening by eic</span> : All articles are subjected to preliminary check by Editor in Charge (EiC). EiC will conduct rapid assessment and decide whether the article is eligible for further review process or decline the submission. If the article is passed to the next process, EiC will recommend a list of prospective suitable reviewers by entering the reviewers’ data (name, email, and affiliation) in the notes box. These recommended reviewers will be assigned by Secretariat at the next process (Step 3. Reviewer Assignment).</li>
          <li><span class="badge bg-blue">Screening by secret</span> : All articles are required to be checked for format compliance with the Author’s Guideline or IJTech template. Secretariat will check the citation-reference style, figure, tables, spacing, and indication of plagiarism of the article(s). Principally, all articles passed through this step are ready to proceed to the blind-review process.</li>
          <li><span class="badge bg-yellow">Review Assignment</span> : All articles will be submitted to the prospective reviewers. Secretariat will assign the reviewers based on the recommendation from Editor in Charge both from the listed reviewers in Step 1. Screening by Editor in Charge and or from the IJTech reviewers database.</li>
          <li><span class="badge bg-green">Review Process</span> : All articles are being reviewed by the invited reviewers. The review process will approximately take two weeks to two months. Reminder will be sent regularly to the reviewers who have not confirmed their acceptance to the invitation to review or have not submitted the review comments. Secretariat will assign new reviewers, if the invited reviewers reject the invitation to conduct review.</li>
          <li><span class="badge bg-yellow">Reviewe Received</span> : All authors of the reviewed articles will receive reviewer’s comments. Editor in Charge or Secretariat need to give the decision for the article based on the reviewer's comments.</li>
          <li><span class="badge bg-yellow">Revision Process</span> : All articles are undergoing revision process by the authors, either revision in response to the secretariat comments during the initial screening or in response to the reviewer’s comments.</li>
          <li><span class="badge bg-green">Accepted</span> : All articles are accepted to be published in IJTech. The accepted article will proceed to the line editing process and author(s) should confirm regarding who will conduct the line editing (Author can choose to conduct their own line editing through the recommended agents, or ask IJTech to conduct the line editing).</li>
          <li><span class="badge label-info">Line Editing</span> : All articles have been confirmed by the author and are awaiting the results of the line editing.</li>
          <li><span class="badge bg-blue">In Press</span> : All articles are ready to be published in IJTech. The secretariat will ensure that all the published articles have been approved by all authors by sending the final proof reading for authors’ approval and the copyright form to be completed and signed by the authors.</li>
          <li><span class="badge bg-red">Archive</span> : This step is a dashboard to see the published, withdrawn, and rejected articles.</li>
        </ol>
			</div>
		</div>	
	</div>
</div>