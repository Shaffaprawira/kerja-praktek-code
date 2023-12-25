<style>
	.sidebar .panel-heading{ border-radius: 0px; }
</style>
<?php if($this->uri->segment(1) == "article" && $this->uri->segment(2) == "view"){ ?>
	
	<div class="col-md-4">
		<div class="list-group">
			<div class="list-group-item"><a href="<?php echo site_url().'download/article/'.$articles[0]['sub_id'];?>" target="_blank" class="btn btn-danger" style="width:100%">Download PDF <span class=""> <i class="fa fa-download"></i></span></a></div>
			
			<!--div class="list-group-item">
				<div class="dropdown">
					<button class="btn btn-default btn-block dropdown-toggle" type="button" data-toggle="dropdown">How to Cite
					<span class=""><i class="fa fa-edit"></i></span></button>
					<ul class="list-group dropdown-menu btn-block">
						<li class="list-group-item">
							<?php echo $articles[0]['cite'] ? str_replace('..', '.', $articles[0]['cite']) : str_replace('..', '.', $this->lib_view->default_citation($articles[0]['sub_id']));?>
						</li>
					</ul>
				</div>
			</div-->

			<div class="list-group-item">
				<?php $c_title = str_replace(' ', '+', $articles[0]['title']) ?>
				<a target="_blank" type="button" class="btn btn-info" style="width:100%" href="<?php echo 'https://scholar.google.com/scholar?q='.$c_title; ?>">Who cite this paper
				<span class=""><i class="fa fa-user"></i></span>
				</a>
			</div>
      
			<div class="list-group-item">
				<div class="dropdown">
					<button class="btn btn-primary btn-block dropdown-toggle" type="button" data-toggle="dropdown">Share Article 
					<span class=""><i class="fa fa-share-alt"></i></span></button>
					<ul class="list-group dropdown-menu btn-block">
						<li class="list-group-item">
							<a href="mailto:?subject=<?php echo $articles[0]['title'];?>"><i class="fa fa-envelope-o"></i> Email</a>
						</li>
						<li class="list-group-item">
							<a onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo current_url(); ?>','facebook-share-dialog','width=626,height=436'); return false;" href="javascript:void(0);">
								<span class="fa fa-facebook"></span> Facebook</a>
						</li>
						<li class="list-group-item">
							<a onclick="window.open('http://twitter.com/intent/tweet?text=<?php echo current_url(); ?>','twitter-share-dialog','width=626,height=436'); return false;" href="javascript:void(0);">
							<span class="fa fa-twitter"></span> Twitter</a>
						</li>
						<li class="list-group-item">
							<a onclick="window.open('https://plus.google.com/share?url=<?php echo current_url(); ?>','twitter-share-dialog','width=626,height=436'); return false;" href="javascript:void(0);">
							<span class="fa fa-google-plus"></span> Google</a>
						</li>
						<li class="list-group-item">
							<a onclick="window.open('https://linkedin.com/shareArticle?mini=true&url=<?php echo current_url(); ?>&title=<?php echo $articles[0]['title'];?>','twitter-share-dialog','width=626,height=436'); return false;" href="javascript:void(0);">
							<span class="fa fa-linkedin"></span> LinkedIn</a>
						</li>
						<li class="list-group-item">
							<a href="whatsapp://send?text=<?php echo $articles[0]['title'].' '.current_url();?>">
							<span class="fa fa-whatsapp"></span> Whatsapp</a>
						</li>

					</ul>
				</div>

			</div>
			<div class="list-group-item">
				<div class="list-group-item active">Table of Contents</div>
				<div class="list-group-item"><a href="#article"><i class="fa fa-arrow-circle-right"></i> Article</a></div>
				<div class="list-group-item"><a href="#abstract"><i class="fa fa-arrow-circle-right"></i> Abstract</a></div>

				<?php if(strip_tags($articles[0]['introduction']) != "" || strip_tags($articles[0]['introduction']) != null){?>
				<div class="list-group-item"><a href="#introduction"><i class="fa fa-arrow-circle-right"></i> Introduction</a></div>
				<?php } ?>
				
				<?php if(strip_tags($articles[0]['experimental_method']) != "" || strip_tags($articles[0]['experimental_method']) != null){?>
				<div class="list-group-item"><a href="#experimental"><i class="fa fa-arrow-circle-right"></i> Experimental Methods</a></div>
				<?php } ?>
				
				<?php if(strip_tags($articles[0]['result']) != "" || strip_tags($articles[0]['result']) != null){?>
				<div class="list-group-item"><a href="#result"><i class="fa fa-arrow-circle-right"></i> Results and Discussion</a></div>
				<?php } ?>
				
				<?php if(strip_tags($articles[0]['conclusion']) != "" || strip_tags($articles[0]['conclusion']) != null){?>
				<div class="list-group-item"><a href="#conclusion"><i class="fa fa-arrow-circle-right"></i> Conclusion</a></div>
				<?php } ?>
				
				<?php if(strip_tags($articles[0]['acknowledgement']) != "" || strip_tags($articles[0]['acknowledgement']) != null){?>
				<div class="list-group-item"><a href="#acknowledgement"><i class="fa fa-arrow-circle-right"></i> Acknowlegement</a></div>
				<?php } ?>
				
				<?php if(!empty($supplement)){ ?>
				<div class="list-group-item"><a href="#supplement"><i class="fa fa-arrow-circle-right"></i> Supplementary Material</a></div>
				<?php } ?>

				<?php if(strip_tags($articles[0]['references']) != "" || strip_tags($articles[0]['references']) != null){?>
				<div class="list-group-item"><a href="#references"><i class="fa fa-arrow-circle-right"></i> References</a></div>
				<?php } ?>
			</div>

		</div>
	</div>

<?php }else{?>
	<div class="col-md-4 sidebar">
		<div class="panel panel-primary">

			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-book"></i> About the Journal</h3>
			</div>
			<div class="panel-body">
				<ul class="list">
					<li><a href="<?php echo site_url().'people';?>">Editorial Board</a></li>
					<li><a href="<?php echo site_url().'about/5/focus-and-scope';?>">Focus and Scope</a></li>
					<li><a href="<?php echo site_url().'about/3/online-submission';?>">Online Submissions</a></li>
					<li><a href="<?php echo site_url().'about/11/publication-policy';?>">Publication Policy</a></li>
					<li><a href="<?php echo site_url().'about/10/policy';?>">Publication Ethics and Policy</a></li>
					<li><a href="<?php echo site_url().'about/4/author-guidelines';?>">Author Guidelines</a></li>					
					<li><a href="<?php echo site_url().'about/12';?>">List of Reviewers</a></li>
				</ul>
				<hr>
                <ul class="list">
                    <li><a href="<?php echo site_url().'home/mostdownloadedpapers';?>">Most downloaded papers</a></li>
                    <li><a href="<?php echo site_url().'about/14';?>">Most cited papers</a></li>
                </ul>
			</div>
		

		<?php if($this->uri->segment(1) !== "login"){?>
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-lock"></i> Login</h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo site_url().'login/auth';?>" method="post">				
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="username" placeholder="Username or email">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="password" placeholder="Password">
					</div>
					<hr/>
					<div class="form-action">
						<span class="pull-left">
							Not as user?<br/>
							<a href="<?php echo site_url().'register';?>">Register</a>	
						</span>
						<input type="submit" name="submit" class="btn btn-primary pull-right" value="Login">
					</div>
				</form>
			</div>		
		<?php } ?>

			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-book"></i> IJTech </h3>
			</div>
			<div class="panel-body">			
				<h5 class="list-group-item-heading"><a href="https://portal.issn.org/resource/ISSN/2086-9614" target="_blank">p-ISSN : <?php echo P_ISSN;?></a></h5>
				<h5 class="list-group-item-heading"><a href="https://portal.issn.org/resource/ISSN/2087-2100" target="_blank">e-ISSN : <?php echo E_ISSN;?></a></h5>
			</div>
	
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-line-chart"></i> Journal Metrics</h3>
			</div>
			<div class="panel-body">
			    <a href="https://www.scimagojr.com/journalsearch.php?q=21100235612&amp;tip=sid&amp;exact=no" title="SCImago Journal &amp; Country Rank"><img border="0" src="https://www.scimagojr.com/journal_img.php?id=21100235612" alt="SCImago Journal &amp; Country Rank"></a>
			    <br>
				<iframe src="<?php echo site_url().'Home/get_info'; ?>" frameborder="0" scrolling="auto" height="200" width="300"></iframe> <!--ruki31jan2019-->
			</div>

			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-line-chart"></i> IJTech is indexed in</h3>
			</div>
			<div class="panel-body">
				<div class="">
					<a href="https://www.scopus.com/sourceid/21100235612" target="_blank">
						<img src="<?php echo site_url().'assets/front/img/side_02.gif';?>">
					</a>
				</div>
				<div class="">
					<a href="http://www.ebsco.com/index.asp" target="_blank">
						<img src="<?php echo site_url().'assets/front/img/side_03.gif';?>">
					</a>
				</div>
				<div class="">
					<a href="https://doaj.org/toc/2086-9614" target="_blank">
						<img src="<?php echo site_url().'assets/front/img/side_04.gif';?>">
					</a>
				</div>
				<div class="">
					<a href="https://www.scimagojr.com/journalsearch.php?q=21100235612&tip=sid" target="_blank">
						<img src="<?php echo site_url().'assets/front/img/side_05.gif';?>">
					</a>
				</div>
				<div class="">
					<a href="https://journals.indexcopernicus.com/search/details?id=31340" target="_blank">
						<img src="<?php echo site_url().'assets/front/img/side_06.gif';?>">
					</a>
				</div>
				<div class="">
					<a href="http://www.crossref.org" target="_blank">
						<img src="<?php echo site_url().'assets/front/img/side_07.gif';?>">
					</a>
				</div>
				<div class="">
					<a href="https://scholar.google.co.id/scholar?q=site%3Ahttp%3A%2F%2Fijtech.eng.ui.ac.id" target="_blank">
						<img src="<?php echo site_url().'assets/front/img/google-scholar-logo.gif';?>">
					</a>
				</div>
				<div class="">
					<a href="https://mjl.clarivate.com:/search-results?issn=2086-9614" target="_blank">
						<img src="<?php echo site_url().'assets/front/img/side_08.gif';?>">
					</a>
				</div>
				<div style="text-align: center">
					<a href="http://info.flagcounter.com/AoS7"><img src="//s10.flagcounter.com/count2/AoS7/bg_FFFFFF/txt_000000/border_CCCCCC/columns_3/maxflags_15/viewers_0/labels_1/pageviews_1/flags_0/percent_0/" alt="Flag Counter" border="0" class="img-responsive"></a>
				</div>

			</div>
		</div>
	</div>
<?php } ?>