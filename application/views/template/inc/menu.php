	<aside class="main-sidebar">
		<section class="sidebar">
			<!--div class="user-panel">
				<div class="pull-left image">
					<img class="img-circle" src="<?php echo set_image($this->session->userdata('avatar'));?>" alt="">
				</div>
				<div class="pull-right info">
					<p><?php echo strlen($this->session->userdata('fname')) > 10 ? substr($this->session->userdata('fname'), 0, 10).'...' : $this->session->userdata('fname');?></p>
					<p></p><i class="fa fa-circle text-success"></i> <?php echo $this->session->userdata('status')[0];?><p></p>
				</div>
			</div-->
			
			<!-- search form (Optional) -->
			<!--form action="#" method="get" class="sidebar-form">
				<div class="input-group">
					<input type="text" name="q" class="form-control" placeholder="Search...">
					<span class="input-group-btn">
						<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
					</span>
				</div>
			</form-->
			
			<!-- Sidebar Menu -->
			<ul class="sidebar-menu">
				<!--li class="header">MAIN MENU</li-->
				<li class="<?php echo $this->uri->segment(2) == '' && $this->uri->segment(1) == 'dashboard'? 'active':'';?>"><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-home"></i> <span>Overview</span></a></li>
				
				<!-- AMINISTRATOR/SECRETARIAT MENU -->
				<?php if($this->session->userdata('user_id')=='SINGMBAHUREKSO'){ ?>
                    <li class="treeview <?php echo $this->uri->segment(1) == 'kpi' && $this->uri->segment(2) != 'timing' ? 'active':'';?>">
						<a href="#"><i class="fa fa-globe"></i> <span>Assets KPI</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?php echo $this->uri->segment(2)=='ed1'?'active':'';?>"><a href="<?= base_url('kpi/ed1')?>"><i class="fa fa-arrow-circle-right"></i> Paper Bank</a></li>
							<!--li class="<?php echo $this->uri->segment(2)=='timeline'  ?'active':'';?>"><a href="<?= base_url('kpi/timeline')  ?>"><i class="fa fa-arrow-circle-right"></i> Paper Trend Timeline</a></li-->
							
							<li class="<?php echo $this->uri->segment(2)=='accounts'  ?'active':'';?>"><a href="<?= base_url('kpi/accounts')  ?>"><i class="fa fa-arrow-circle-right"></i> Editor Data</a></li>
							<li class="<?php echo $this->uri->segment(2)=='kinerja'?'active':'';?>"><a href="<?= base_url('kpi/kinerja')?>"><i class="fa fa-arrow-circle-right"></i> Editor Workload</a></li>
							<li class="<?php echo $this->uri->segment(2)=='delay'?'active':'';?>"><a href="<?= base_url('kpi/delay')?>"><i class="fa fa-arrow-circle-right"></i> Editor Performance</a></li>
							<li class="<?php echo $this->uri->segment(2)=='cost'  ?'active':'';?>"><a href="<?= base_url('kpi/cost')  ?>"><i class="fa fa-arrow-circle-right"></i> Unit Cost</a></li>
						</ul>
					</li>
				<?php } ?>
				
				<?php if(in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role'))) {?>
					<li class="treeview <?php echo ($this->uri->segment(2) == 'timing'||$this->uri->segment(2) == 'announcement'||$this->uri->segment(2) == 'info'||$this->uri->segment(3) == 'announcement'|| $this->uri->segment(2) == 'section' || $this->uri->segment(3) == 'section' || $this->uri->segment(2) == 'people' || $this->uri->segment(3) == 'people' || $this->uri->segment(2) == 'about' || $this->uri->segment(3) == 'page') && ($this->uri->segment(2) != 'users') ? 'active':'';?>">
						<a href="#"><i class="fa fa-globe"></i> <span>Site Management</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="<?php echo base_url().'dashboard/announcement';?>"><i class="fa fa-arrow-circle-right"></i> Announcement</a></li>
							<li><a href="<?php echo base_url().'dashboard/info';?>"><i class="fa fa-arrow-circle-right"></i> Journal Info</a></li>
							<li><a href="<?php echo base_url().'dashboard/section';?>"><i class="fa fa-arrow-circle-right"></i> Journal Section</a></li>
							<li><a href="<?php echo base_url().'dashboard/Editions';?>"><i class="fa fa-arrow-circle-right"></i> Editions</a></li>
							<li><a href="<?php echo base_url().'dashboard/about';?>"><i class="fa fa-arrow-circle-right"></i> About the Journal</a></li>
							<li><a href="<?php echo base_url().'dashboard/people';?>"><i class="fa fa-arrow-circle-right"></i> Editorial Team</a></li>
<?php if($this->session->userdata('user_id')=='SINGMBAHUREKSO'){ ?>
                            <li class="<?php echo $this->uri->segment(2)=='timing'?'active':'';?>"><a href="<?php echo base_url().'kpi/timing';?>"><i class="fa fa-arrow-circle-right"></i> Auto-action Timer</a></li>
<?php } ?>
						</ul>
					</li>

					<li class="treeview <?php echo $this->uri->segment(2) == 'users' || $this->uri->segment(3) == 'user' || $this->uri->segment(3) == 'users' ? 'active':'';?>">
						<a href="#"><i class="fa fa-mortar-board"></i> <span>User Management</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="<?php echo base_url().'dashboard/users';?>"><i class="fa fa-arrow-circle-right"></i> Enrolled Users</a></li>
							<li><a href="<?php echo base_url().'dashboard/create/user';?>"><i class="fa fa-arrow-circle-right"></i> Register New User</a></li>
						</ul>
					</li>
					
					<li class="treeview <?php echo $this->uri->segment(2) == 'submission' || (in_array($this->uri->segment(3), array('submission','suplement','author','reviewer','agreement')) && $this->uri->segment(2) == 'submission') || ($this->uri->segment(2) == 'detail' && $this->uri->segment(3) == 'submission') ? 'active':'';?>">
						<a href="#"><i class="fa fa-newspaper-o"></i> <span>Submissions</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">							
							<li class="<?php echo $this->uri->segment(5) == 2 ? 'active':'';?>">          <a data-toggle="tooltip" data-placement="right" title="All articles are required to be checked for format compliance with the Author’s Guideline or IJTech template. Secretariat will check the citation-reference style, figure, tables, spacing, and indication of plagiarism of the article(s). Principally, all articles passed through this step are ready to proceed to the blind-review process." href="<?php echo base_url().'dashboard/submission/secretariat/status/2/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Screening by secret <small class="label pull-right bg-blue"><?php echo $this->lib_view->count_submission_status(2);?></small></a></li>
							<li class="<?php echo $this->uri->segment(5) == 1 ? 'active':'';?>">          <a data-toggle="tooltip" data-placement="right" title="All articles are subjected to preliminary check by Editor in Charge (EiC). EiC will conduct rapid assessment and decide whether the article is eligible for further review process or decline the submission. If the article is passed to the next process, EiC will recommend a list of prospective suitable reviewers by entering the reviewers’ data (name, email, and affiliation) in the notes box. These recommended reviewers will be assigned by Secretariat at the next process (Step 3. Reviewer Assignment)." href="<?php echo base_url().'dashboard/submission/secretariat/status/1/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Screening by eic <small class="label pull-right label-info"><?php echo $this->lib_view->count_submission_status(1);?></small></a></li>
							<li class="<?php echo $this->uri->segment(5) == 3 ? 'active':'';?>">          <a data-toggle="tooltip" data-placement="right" title="All articles will be submitted to the prospective reviewers. Secretariat will assign the reviewers based on the recommendation from Editor in Charge both from the listed reviewers in Step 1. Screening by Editor in Charge and or from the IJTech reviewers database." href="<?php echo base_url().'dashboard/submission/secretariat/status/3/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Review Assignment <small class="label pull-right bg-yellow"><?php echo $this->lib_view->count_submission_status(3);?></small></a></li>
							<li class="<?php echo $this->uri->segment(5) == 4 ? 'active':'';?>">          <a data-toggle="tooltip" data-placement="right" title="All articles are being reviewed by the invited reviewers. The review process will approximately take two weeks to two months. Reminder will be sent regularly to the reviewers who have not confirmed their acceptance to the invitation to review or have not submitted the review comments. Secretariat will assign new reviewers, if the invited reviewers reject the invitation to conduct review." href="<?php echo base_url().'dashboard/submission/secretariat/status/4/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Review Process <small class="label pull-right bg-green"><?php echo $this->lib_view->count_submission_status(4);?></small></a></li>
							<li class="<?php echo $this->uri->segment(5) == 5 ? 'active':'';?>">          <a data-toggle="tooltip" data-placement="right" title="All authors of the reviewed articles will receive reviewer’s comments. Editor in Charge or Secretariat need to give the decision for the article based on the reviewer's comments." href="<?php echo base_url().'dashboard/submission/secretariat/status/5/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Review Received <small class="label pull-right bg-yellow"><?php echo $this->lib_view->count_submission_status(5);?></small></a></li>							
							<li class="<?php echo $this->uri->segment(5) == 7 ? 'active':'';?>">          <a data-toggle="tooltip" data-placement="right" title="All articles are undergoing revision process by the authors, either revision in response to the secretariat comments during the initial screening or in response to the reviewer’s comments." href="<?php echo base_url().'dashboard/submission/secretariat/status/7/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Revision Process <small class="label pull-right bg-yellow"><?php echo $this->lib_view->count_submission_status(7);?></small></a></li>
							<li class="<?php echo $this->uri->segment(5) == 8 ? 'active':'';?>">          <a data-toggle="tooltip" data-placement="right" title="All articles are accepted to be published in IJTech. The accepted article will proceed to the line editing process and author(s) should confirm regarding who will conduct the line editing (Author can choose to conduct their own line editing through the recommended agents, or ask IJTech to conduct the line editing)." href="<?php echo base_url().'dashboard/submission/secretariat/status/8/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Accepted <small class="label pull-right bg-green"><?php echo $this->lib_view->count_submission_status(8);?></small></a></li>
							<li class="<?php echo $this->uri->segment(5) == 12 ? 'active':'';?>">         <a data-toggle="tooltip" data-placement="right" title="All articles have been confirmed by the author and are awaiting the results of the line editing." href="<?php echo base_url().'dashboard/submission/secretariat/status/12/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Inline Editing <small class="label pull-right label-info"><?php echo $this->lib_view->count_submission_status(12);?></small></a></li>
							<li class="<?php echo $this->uri->segment(5) == 11 ? 'active':'';?>">         <a data-toggle="tooltip" data-placement="right" title="All articles are ready to be published in IJTech. The secretariat will ensure that all the published articles have been approved by all authors by sending the final proof reading for authors’ approval and the copyright form to be completed and signed by the authors." href="<?php echo base_url().'dashboard/submission/secretariat/status/11/page/1';?>"><i class="fa fa-arrow-circle-right"></i> In Press <small class="label pull-right bg-blue"><?php echo $this->lib_view->count_submission_status(11);?></small></a></li>
							<li class="<?php echo $this->uri->segment(5) == 'completed' ? 'active':'';?>"><a data-toggle="tooltip" data-placement="right" title="This step is a dashboard to see the published, withdrawn, and rejected articles." href="<?php echo base_url().'dashboard/submission/secretariat/status/completed/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Archive <small class="label pull-right bg-red"><?php echo $this->lib_view->count_submission_status('completed');?></small></a></li>
						</ul>
					</li>
					
					<li class="treeview <?php echo $this->uri->segment(2) == 'issue'|| $this->uri->segment(3) == 'issue' && $this->uri->segment(2) != 'submission' ? 'active':'';?>">
						<a href="#"><i class="fa fa-book"></i> <span>Issue Management</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="<?php echo base_url().'dashboard/issue';?>"><i class="fa fa-arrow-circle-right"></i> All Issue</a></li>
							<li><a href="<?php echo base_url().'dashboard/create/issue';?>"><i class="fa fa-arrow-circle-right"></i> Create Issue</a></li>
						</ul>
					</li>
					
					<li class="<?php echo $this->uri->segment(2) == 'generate' && $this->uri->segment(3) == 'crossref'? 'active':'';?>"><a href="<?php echo base_url().'dashboard/generate/crossref';?>"><i class="fa fa-file-code-o"></i> <span>Generate XML</span></a></li>

					<!--li class="<?php echo $this->uri->segment(2) == 'generate' && $this->uri->segment(3) == 'doaj'? 'active':'';?>"><a href="<?php echo base_url().'dashboard/generate/doaj';?>"><i class="fa fa-upload"></i> <span>Generate DOAJ</span></a></li-->

					<li class="<?php echo $this->uri->segment(2) == 'migrate' && $this->uri->segment(1) == 'dashboard'? 'active':'';?>"><a href="<?php echo base_url().'dashboard/migrate';?>"><i class="fa fa-upload"></i> <span>Migrate Journal</span></a></li>

					<li class="treeview <?php echo in_array($this->uri->segment(2), array('export')) ? 'active':'';?>">
						<a href="#"><i class="fa fa-desktop"></i> <span>Export</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?php echo $this->uri->segment(2) == '' ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/export';?>"><i class="fa fa-arrow-circle-right"></i> Manuscript </a></li>							
							<li class="<?php echo $this->uri->segment(2) == 'reviewer' ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/export/reviewer';?>"><i class="fa fa-arrow-circle-right"></i> Reviewer </a></li>							
						</ul>
					</li>
					
					<li class="treeview <?php echo in_array($this->uri->segment(2), array('backup','reminder')) ? 'active':'';?>">
						<a href="#"><i class="fa fa-cogs"></i> <span>Admintools</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?php echo $this->uri->segment(2) == 'backup' ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/backup';?>"><i class="fa fa-arrow-circle-right"></i> Backup Database </a></li>							
							<li class="<?php echo $this->uri->segment(2) == 'reminder' ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/reminder';?>"><i class="fa fa-arrow-circle-right"></i> Schedule Reminder </a></li>							
							<li><a onclick="return confirm('Broadcast will be started. You sure?')" href="<?php echo base_url().'dashboard/broadcastAPCNotice';?>"><i class="fa fa-arrow-circle-right"></i> Inform APC Policy </a></li>							
						</ul>
					</li>

				<!-- EDITOR -->
				<?php }else if(in_array(3, $this->session->userdata('role'))){ ?>
						<li class="treeview <?php echo $this->uri->segment(2) == 'submission' || in_array($this->uri->segment(3), array('submission','suplement','author','reviewer','agreement')) ? 'active':'';?>">
							<a href="#"><i class="fa fa-newspaper-o"></i> <span>Editor</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">								
								
								<li class="<?php echo $this->uri->segment(5) == 1 ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/submission/editor/status/1/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Screening by eic <small class="label pull-right label-info"><?php echo $this->lib_view->count_submission_status(1);?></small></a></li>
								<li class="<?php echo $this->uri->segment(5) == 2 ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/submission/editor/status/2/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Screening by secret <small class="label pull-right bg-blue"><?php echo $this->lib_view->count_submission_status(2);?></small></a></li>

								<li class="<?php echo $this->uri->segment(5) == 3 ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/submission/editor/status/3/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Review Assignment <small class="label pull-right bg-blue"><?php echo $this->lib_view->count_submission_status(3);?></small></a></li>
								<li class="<?php echo $this->uri->segment(5) == 4 ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/submission/editor/status/4/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Review Process <small class="label pull-right bg-blue"><?php echo $this->lib_view->count_submission_status(4);?></small></a></li>
								<li class="<?php echo $this->uri->segment(5) == 5 ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/submission/editor/status/5/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Review Received <small class="label pull-right bg-blue"><?php echo $this->lib_view->count_submission_status(5);?></small></a></li>
								<li class="<?php echo $this->uri->segment(5) == 7 ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/submission/editor/status/7/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Revision Process <small class="label pull-right bg-orange"><?php echo $this->lib_view->count_submission_status(7);?></small></a></li>
								<li class="<?php echo $this->uri->segment(5) == 8 ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/submission/editor/status/8/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Accepted <small class="label pull-right bg-green"><?php echo $this->lib_view->count_submission_status(8);?></small></a></li>
								<li class="<?php echo $this->uri->segment(5) == 'completed' ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/submission/editor/status/completed/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Archive <small class="label pull-right bg-blue"><?php echo $this->lib_view->count_submission_status('completed');?></small></a></li>					
							</ul>
						</li>
						<li class="<?php echo $this->uri->segment(3) == 'editorial' ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/create/editorial';?>"><i class="fa fa-book"></i> <span>Create Editorial</span></a></li>
        
        <!-- AUTHOR / REVIEWER -->
				<?php }else{?>
					<?php if(in_array(5, $this->session->userdata('role'))){?>
						<li class="treeview <?php echo $this->uri->segment(2) == 'submission' || in_array($this->uri->segment(3), array('submission','suplement','author','reviewer','agreement','detail')) ? 'active':'';?>">
							<a href="#"><i class="fa fa-newspaper-o"></i> <span>Author</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li class="<?php echo $this->uri->segment(5) == 'active'?'active':'';?>"><a href="<?php echo base_url().'dashboard/submission/author/status/active';?>"><i class="fa fa-arrow-circle-right"></i> Active</a></li>
								<li class="<?php echo $this->uri->segment(5) == 'archive'?'active':'';?>"><a href="<?php echo base_url().'dashboard/submission/author/status/archive';?>"><i class="fa fa-arrow-circle-right"></i> Archive</a></li>
								<li class="<?php echo in_array($this->uri->segment(2), array('create','edit')) ? 'active':'';?>"><a href="<?php echo base_url().'dashboard/create/submission';?>"><i class="fa fa-arrow-circle-right"></i> New Submission</a></li>
							</ul>
						</li>
					<?php } ?>

					<?php if(in_array(4, $this->session->userdata('role'))){ $section = $this->session->userdata('editor_section'); ?>
						<li class="treeview <?php echo $this->uri->segment(2) == 'submission' || in_array($this->uri->segment(3), array('submission','suplement','author','reviewer','agreement')) ? 'active':'';?>">
							<a href="#"><i class="fa fa-newspaper-o"></i> <span>Section Editor</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">								
								<li class="<?php echo $this->uri->segment(5) == 1 ? 'active':'';?>">
									<a href="<?php echo base_url().'dashboard/submission/editor/status/1/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Screening by eic 
										<small class="label pull-right label-info"><?php echo $this->lib_view->count_submission_section($section, 1);?></small>
									</a>
								</li>
								<li class="<?php echo $this->uri->segment(5) == 2 ? 'active':'';?>">
									<a href="<?php echo base_url().'dashboard/submission/editor/status/2/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Screening by secret 
										<small class="label pull-right bg-blue"><?php echo $this->lib_view->count_submission_section($section, 2);?></small>
									</a>
								</li>
								<li class="<?php echo $this->uri->segment(5) == 3 ? 'active':'';?>">
									<a href="<?php echo base_url().'dashboard/submission/editor/status/3/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Review Assignment
										<small class="label pull-right label-warning"><?php echo $this->lib_view->count_submission_section($section, 3);?></small>
									</a>
								</li>
								<li class="<?php echo $this->uri->segment(5) == 4 ? 'active':'';?>">
									<a href="<?php echo base_url().'dashboard/submission/editor/status/4/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Review Process
										<small class="label pull-right bg-green"><?php echo $this->lib_view->count_submission_section($section, 4);?></small>
									</a>
								</li>
								<li class="<?php echo $this->uri->segment(5) == 5 ? 'active':'';?>">
									<a href="<?php echo base_url().'dashboard/submission/editor/status/5/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Review Received
										<small class="label pull-right bg-orange"><?php echo $this->lib_view->count_submission_section($section, 5);?></small>
									</a>
								</li>
								<li class="<?php echo $this->uri->segment(5) == 7 ? 'active':'';?>">
									<a href="<?php echo base_url().'dashboard/submission/editor/status/7/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Revision Process
										<small class="label pull-right label-warning"><?php echo $this->lib_view->count_submission_section($section, 7);?></small>
									</a>
								</li>
								<li class="<?php echo $this->uri->segment(5) == 'completed' ? 'active':'';?>">
									<a href="<?php echo base_url().'dashboard/submission/editor/status/completed/page/1';?>"><i class="fa fa-arrow-circle-right"></i> Archive
										<small class="label pull-right bg-red"><?php echo $this->lib_view->count_submission_section($section, 'completed');?></small>
									</a>
								</li>					
							</ul>
						</li>
					<?php } ?>

					<?php if(in_array(6, $this->session->userdata('role'))){?>
						<li class="treeview <?php echo $this->uri->segment(2) == 'review' ? 'active':'';?>">
							<a href="#"><i class="fa fa-search"></i> <span>Review Assignment</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li class="<?php echo $this->uri->segment(3) == 'active' || $this->uri->segment(4) !== '' ?'active':'';?>"><a href="<?php echo base_url().'dashboard/review/active';?>"><i class="fa fa-arrow-circle-right"></i> Not done yet</a></li>
								<li class="<?php echo $this->uri->segment(3) == 'archive'?'active':'';?>"><a href="<?php echo base_url().'dashboard/review/archive';?>"><i class="fa fa-arrow-circle-right"></i> Done</a></li>
							</ul>
						</li>
					<?php } ?>								
				<?php } ?>
			</ul>
			<?php if(in_array(5, $this->session->userdata('role'))){?>
			<hr/>
			<div class="link">
				<ul>
					<!-- <li><a style="color:#337ab7" href="<?php echo site_url().'about/4/author-guidelines';?>" target="_blank">How to submit Manuscript</a></li>
					<li><a style="color:#337ab7" href="<?php echo site_url().'about/10/policy';?>" target="_blank">Information for Reviewer</a></li>
					<li><a style="color:#337ab7" href="<?php echo site_url().'about/4/author-guidelines';?>" target="_blank">Ethical Guidelines & Plagiarism Screening</a></li>
					<li><a style="color:#337ab7" href="<?php echo site_url().'about/4/author-guidelines';?>" target="_blank">Copyright/Journal Publishing Agreement</a></li>
					<li><a style="color:#337ab7" href="<?php echo site_url().'about/4/author-guidelines';?>" target="_blank">Permission & Credit Lines</a></li>
					<li><a style="color:#337ab7" href="<?php echo site_url().'about/6/open-access-policy';?>" target="_blank">Open Access Policy</a></li> -->
					<li><a style="color:#337ab7" href="<?php echo site_url().'about/4/author-guidelines';?>" target="_blank">Author Guidelines</a></li>	
					<li><a style="color:#337ab7" href="<?php echo site_url().'about/5/focus-and-scope';?>" target="_blank">Focus and Scope</a></li>
					<li><a style="color:#337ab7" href="<?php echo site_url().'about/3/online-submission';?>" target="_blank">Online Submissions</a></li>
					<li><a style="color:#337ab7" href="<?php echo site_url().'about/11/publication-policy';?>" target="_blank">Publication Policy</a></li>
					<li><a style="color:#337ab7" href="<?php echo site_url().'about/10/policy';?>" target="_blank">Publication Ethics and Policy</a></li>
				</ul>
			</div>
			<?php } ?>
			
        </section>
	</aside>
	<div style="display:none">debuginfo: <?php if(isset($debuginfo)){ echo $debuginfo; } ?></div>