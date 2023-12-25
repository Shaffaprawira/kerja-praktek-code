		<div class="navbar" style="background-color: #10253f; margin:0px; margin-top:-50px; margin-bottom:-2px; border:none;border-radius:0px">
			<div class="container">
				<div class="row" style="">
					<div class="col-md-8">
						<a href="<?php echo site_url();?>"><img src="<?php echo site_url().'assets/front/img/logo_lama.png';?>" class="img-responsive"></a>
					</div>
					<div class="col-md-4">
						<br/><br/>
						<form action="<?php echo site_url().'search';?>" method="GET"> <!-- ruki0 -->
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-btn">
										<a class="btn btn-default dropdown-toggle choice" data-toggle="dropdown" href="#" aria-expanded="false">
									      title <span class="caret"></span>
									    </a>
									    <ul class="dropdown-menu" style="z-index:100000">
											<li class="filter" data-value="title"><a href="#title">Title</a></li>
											<li class="filter" data-value="author"><a href="#author">Author</a></li>
											<li class="filter" data-value="issue"><a href="#issue">Issue</a></li>
											<li class="filter" data-value="keywords"><a href="#keyword">Keywords</a></li>
									    </ul>  
									</span>
									<input type="hidden" name="by" id="by" value="all">
									<input type="search" name="q" class="form-control" placeholder="Search article">
									<span class="input-group-btn">
										<input type="submit" value="Search" class="btn btn-primary">
									</span>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<nav class="navbar navbar-inverse navbar-static-top" style="border:none;border-radius:0px">
			<div class="container" align="center">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<span class="nav pull-left" style="color:#FFF; font-size:0.7em; text-align:left;padding:5px">
						<b>Current Issue :</b><br/><a style="color:#FFF" href="<?php echo site_url().'issue/'.$this->session->userdata('ci')['issue_id'];?>"><?php echo $this->session->userdata('ci')['issue'];?></a>
					</span>
					<ul class="nav navbar-nav pull-right">
						<!--li class="<?php echo $this->uri->segment(1) ? '':'active';?>"><a href="<?php echo base_url();?>"><i class="fa fa-home"></i> Home</a></li-->
						<li class="dropdown <?php echo $this->uri->segment(1) == 'article' ? 'active':'';?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">Browse <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url().'archives';?>">By Issue</a></li>
								<!--li><a href="<?php echo site_url().'article/sortby/author';?>">By Author</a></li-->
								<li><a href="<?php echo site_url().'home/article_sortby/title';?>">By Title</a></li>
							</ul>
						</li>

						<li class="<?php echo $this->uri->segment(1) == 'announcement'? 'active':'';?>"><a href="<?php echo base_url().'announcement';?>">Announcement</a></li>
						<li class="<?php echo ($this->uri->segment(1) == 'about' && $this->uri->segment(2) == '13' ) ? 'active':'';?>"><a href="<?php echo base_url().'about/13/article-processing-charge';?>" title="Article Processing Charge">APC</a></li>
						<li class="dropdown <?php echo ($this->uri->segment(1) == 'about' && ($this->uri->segment(2) != '3' &&  $this->uri->segment(2) != '13')) ? 'active':'';?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">About <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url().'about/1/about-the-journal';?>">About</a></li>
								<li class="group">Journal</li>
								<li><a href="<?php echo site_url().'about/2/journal-contact';?>">Contact</a></li>
								<li><a href="<?php echo site_url().'people';?>">Editorial Board</a></li>
								<li><a href="<?php echo site_url().'about/7/secretariat';?>">Secretariat</a></li>
								<li class="group">Policies</li>
								<li><a href="<?php echo site_url().'about/5/focus-and-scope';?>">Focus and Scope</a></li>
								<li><a href="<?php echo site_url().'about/6/open-access-policy';?>">Open Access Policy</a></li>
								<li><a href="<?php echo site_url().'about/11/publication-policy';?>">Publication Policy</a></li>
								<li><a href="<?php echo site_url().'about/10/policy';?>">Publication Ethics and Policy</a></li>
								<li class="group">Submissions</li>
								<li><a href="<?php echo site_url().'about/3/online-submission';?>">Online Submissions</a></li>
								<li><a href="<?php echo site_url().'about/4/author-guidelines';?>">Author Guidelines</a></li>
								<li><a href="<?php echo site_url().'about/8/privacy-statement';?>">Privacy Statement</a></li>
								<li><a href="<?php echo site_url().'about/13/article-processing-charge';?>">Article Processing Charge</a></li>
								<li class="group">Others</li>
								<li><a href="<?php echo site_url().'about/9/sponsorship';?>">Publisher and Sponsorship</a></li>
							</ul>
						</li>
            <li class="dropdown <?php if($this->uri->segment(1) == 'issue' || $this->uri->segment(1) == 'archives' || $this->uri->segment(2)=='inpress' ){echo 'active';} ?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">Issues <span class="caret"></span></a>
							<ul class="dropdown-menu">
<?php if($this->session->userdata('user_id')=='SINGMBAHUREKSO'){ ?>
							    <li><a href="<?php echo site_url().'home/inpress';?>">Inpress</a></li>
<?php } ?>
								<li><a href="<?php echo site_url().'issue';?>">Latest Issue</a></li>
								<li><a href="<?php echo site_url().'archives';?>">All Issues</a></li>
              </ul>
            </li>
<?php if($this->session->userdata('user_id')=='SINGMBAHUREKSO'){ ?>
    <li class="<?php echo $this->uri->segment(1) == 'home' && $this->uri->segment(2) == 'forthcoming' ? 'active':'';?>" ><a href="<?php echo base_url().'home/forthcoming';?>">Forthcoming</a></li>
<?php } ?>
            
						<!--li class="<?php echo $this->uri->segment(1) == 'current'? 'active':'';?>"><a href="<?php echo base_url().'issue';?>">Current Issue</a></li>
						<li class="<?php echo $this->uri->segment(1) == 'archives'? 'active':'';?>"><a href="<?php echo base_url().'archives';?>">Archives</a></li-->
						<li class="<?php if($this->uri->segment(1) == 'about' && $this->uri->segments[2] == '3' ){ echo 'active';} ?>"><a href="<?php echo base_url().'about/3/online-submission';?>">Submission</a></li>
						<li class="<?php echo $this->uri->segment(1) == 'login' ? 'active':'';?>" ><a href="<?php echo base_url().'login';?>"><!--i class="fa fa-lock"></i-->Login</a></li>
					</ul>
				</div>
			</div>
			<div style="display:none;height:0;width:0;float:left"><pre>
			    <?php
			        //print_r($this->uri);
			        echo "=".$this->uri->segments[2]."|".$this->uri->segment(2).")";
			    ?></pre>
			</div>
		</nav>
