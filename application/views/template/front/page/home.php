<div class="container">

	<div class="row">
		<div class="col-md-8">
		    
<!--div style="
    background: #ffe6c1;
    padding: 5px 19px 19px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #f00;
    zoom: 1.2
    "><h4 style="font-weight:bold">Special Edition Publication Policy</h4>
    <a href="https://ijtech.eng.ui.ac.id/about/15">Click here</a> for more details.</div-->
    
<div style="
    background: #ffe6c1;
    padding: 5px 19px 19px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #f00;
    zoom: 1.2
    "><h4 style="font-weight:bold">APC Notice</h4>
    All accepted articles that are initially submitted at January 1<sup>st</sup> 2023 or later will be subject to article processing charges (APC) of US$ 1000 plus tax. <a href="https://ijtech.eng.ui.ac.id/about/13">Click here</a> for more details.</div>
    <!-- Starting from January 1<sup>st</sup> 2023, all accepted articles are subject to an article processing charges (APC) of US$ 1000 plus tax. <a href="https://ijtech.eng.ui.ac.id/about/13">Click here</a> for more details. -->
    
<!--div style="
    background: #ffe6c1;
    padding: 5px 19px 19px;
    margin-bottom: 30px;
    border-radius: 5px;
    border: 1px solid #f00;
    zoom: 1.2
    "><h4 style="font-weight:bold">Announcement</h4>
    Call for Papers - Special Issue on Engineering and Technology in Response to COVID-19. Submission deadline: 31 October 2021.
    </div-->
		    
			<!-- courusel -->
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner" role="listbox">
					<?php if(!empty($news)){ $no=0; foreach($news as $s){ $no++; ?>
						<div class="item <?php echo $no == 1 ? 'active':'';?>">
							<div class="row">
								<div class="col-md-4">									
									<i class="fa fa-bullhorn" aria-hidden="true" style="font-size: 8em"></i>
								</div>
								<div class="col-md-8">
                <?php //ruki: tambah field issue_id di tabel announcement
                  if(isset($s['issue_id']) && $s['issue_id']!="" && $s['issue_id']!="0"){
                    $link=site_url().'issue/'.$s['issue_id'];
                  }else{
                    $link=site_url().'announcement/view/'.$s['ann_id'];
                  }
                ?>
									<!--div class="title"><a href="<?php echo $link;?>"><?php echo strlen($s['ann_title']) > 75 ? substr($s['ann_title'], 0, 75).'...':$s['ann_title'];?></a></div-->
									<div class="title"><a href="<?php echo $link;?>"><?php echo $s['ann_title'];?></a></div>
									<hr/>	
									<p><?php echo substr(strip_tags($s['ann_description']), 0, 200);?></p>
									<p><a href="<?php echo $link;?>">Read more &raquo;</a></p>
								</div>
							</div>
						</div>
					<?php }}else{?>
						<div class="item active">
							<h3>No Announcement yet</h3>
							<p>No data can be displayed.</p>
						</div>
					<?php } ?>
				</div>
				<!-- Controls -->
				<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
				<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
			</div>
		</div>
		<!-- latest -->
		<div class="col-md-4" style="background-color:#EEE; padding: 10px; display:block; color:#888; border:solid 1px #DDD">
			<div class="row">
				<?php if(!empty($journal)){?>
				<div class="col-md-5">
					<a href="<?php echo $this->lib_view->preview_image($journal[0]['sub_id']);?>" data-lightbox="graphical image" data-title="<?php echo $journal[0]['sub_title'];?>"><img class="img-responsive thumbnail" alt="image" src="<?php echo $this->lib_view->preview_image($journal[0]['sub_id']);?>"></a>
				</div>
				<div class="col-md-7">
					<small><?php echo $this->lib_view->get_issue($journal[0]['issue_id']);?></small>
					<h5><a href="<?php echo site_url().'article/view/'.$journal[0]['sub_id'];?>"><?php echo $journal[0]['sub_title'];?></a></h5>
					<p><i><?php echo $this->lib_view->author_submission($journal[0]['sub_id']);?></i></p>
				</div>
				<?php }else { echo "<div class='col-md-12'>Data empty!</div>";} ?>
			</div>
		</div>
	</div>
	<hr/>

	<!-- journal-->
	<div class="row">
		<div class="col-md-8">
			
			<h3>Newest articles</h3>
			<div class="well">			
				<?php if(!empty($journal)){ $no = 0; foreach($journal as $s){ $no++; ?>
					<div class="row">
						<div class="col-md-2">
							<a href="<?php echo $this->lib_view->preview_image($s['sub_id']);?>" data-lightbox="graphical image" data-title="<?php echo $s['sub_title'];?>">
								<img class="img-responsive thumbnail" alt="image" src="<?php echo $this->lib_view->preview_image($s['sub_id']);?>"></a>
						</div>
						<div class="col-md-5">
							<h1 class="title" style="margin-top:0"><a href="<?php echo site_url().'article/view/'.$s['sub_id'];?>"><?php echo $s['sub_title'];?></a></h1>
							<p><i><?php echo $this->lib_view->author_submission($s['sub_id']);?></i></p>
						</div>
						<div class="col-md-5">
							<div class="date">
								Publication Date (Online):<br/><?php echo date('d M Y', strtotime($s['publish_date']));?>
								<br/><a href="<?php echo $s['doi_url'];?>"><?php echo $s['doi_url'];?></a><br/>
								<?php echo "Pages : ".$s['pages'];?>
							</div>						
						</div>
					</div>
					<hr/>
				<?php } ?>
				<?php }else{?>
				<h4>Latest Journal List Section</h4>
				<p>This section will be shown about latest published journals.</p>
				<?php } ?>
			</div>
			<?php echo $paging;?>
		</div>
		<?php $this->load->view('template/inc/sidebar');?>
	</div>
</div>