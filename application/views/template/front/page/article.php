<div class="container">

	<div class="row">
		<div class="col-md-8">
			<?php if($param == 'view'){?>

				<!-- detail article / journal -->
				<ul class="breadcrumb" id="article">
				    <li title="IJTech">International Journal of Technology (IJTech)</li>
					<li><?php echo "Vol ".$articles[0]['volume'].", No ".$articles[0]['issue_number']." (".$articles[0]['year'].")";?></li>
					<!--li><?php echo $articles[0]['section_title'];?></li-->
				</ul>
				<h3><?php echo $articles[0]['title'];?></h3>
				<div style="width:0.1px;height:0.1px;overflow:hidden;color:#fff;">
				    <h1><a href="<?=base_url('article/view/'.$articles[0]['sub_id'])?>" rel="bookmark" title="<?=$articles[0]['title']?>"><?=$articles[0]['title']?></a></h1>
				    Title: <b><?=$articles[0]['title']?></b>
				</div>
				<?php if($articles[0]['erratum_file']!=''){ //Ruki16feb2019 ?>
<div style="
    border: 1px solid #ffc235;
    padding: 9px 25px 19px;
    margin: 20px 0px 30px;
    border-radius: 6px;
    background: #fff5de;
"><h4><i class="fa fa-warning"></i> Correction for this article:</h4><a href="<?php echo site_url().'download/article/erratum'.$articles[0]['sub_id']; ?>"><i class="fa fa-download"></i> <?php echo $articles[0]['erratum_type'] .' to: '.$articles[0]['title']; ?></a><br>Published at: <?php echo date('d M Y', strtotime($articles[0]['erratum_date'])); ?></div>
				<?php } ?>

				<!-- author and institution -->
				<ul class="nav nav-tabs">
					<li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">Authors</a></li>
					<li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">Authors and Affiliations</a></li>
				</ul>  
				<div id="myTabContent" class="tab-content">
					<div class="tab-pane fade active in" id="home">
						<div class=""><?php echo $this->lib_view->author_submission($articles[0]['sub_id']);?> 
						<br><br>Corresponding email: <a rel="author" href="mailto:<?php echo $this->lib_view->email_corrensponding($articles[0]['sub_id']);?>"><i class="fa fa-envelope-o"></i> <?php echo $this->lib_view->email_corrensponding($articles[0]['sub_id']);?></div></a>
						<br/><br/>
						<div class="row">
							<div class="col-md-5 br">
								<div class="form-group">
									<p>
										<b>Published at : </b> <?php echo date('d M Y', strtotime($articles[0]['publish_date']));?><br/>
										<b>Volume :</b> <a href="<?php echo site_url();?>"><strong title="IJTech">IJtech</strong> </a>
										<a href="<?php echo site_url().'issue/'.$articles[0]['issue_id'];?>"><?php echo "Vol ".$articles[0]['volume'].", No ".$articles[0]['issue_number']." (".$articles[0]['year'].")";?></a>
										<br/>
										<small style="font-style: normal"><b>DOI :</b> <a href="<?php echo $articles[0]['doi_url'];?>"><?php echo $articles[0]['doi_url'];?></a></small>
									</p>
								</div>
							</div>
							<div class="col-md-5 br">
							  <!--googleoff: all-->
								<b>Cite this article as:</b><br/>
								<small style="font-style: normal"><?php echo $articles[0]['cite'] ? str_replace('..', '.', $articles[0]['cite']) : str_replace('..', '.', $this->lib_view->default_citation($articles[0]['sub_id']));?></small>
							  <!--googleon: all-->
<br><br><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" style="text-transform:none">Export to BibTeX and RIS</button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--googleoff: all-->
        <b>BibTeX : </b><br>
				<div onclick="selectText('bibCitation')" id="bibCitation">
					
				</div>
        <br>
				<a rel="nofollow" class="btn btn-sm btn-default" href="<?=base_url('home/get_bibtex/'.$articles[0]['sub_id'])?>" >Get BibTeX file (*.bib)</a><br>
        <br><b>RIS : </b><br>
				<div onclick="selectText('risCitation')" id="risCitation">
				    
				</div>
        <br>
				<a rel="nofollow" class="btn btn-sm btn-default" href="<?=base_url('home/get_ris/'.$articles[0]['sub_id'])?>" >Get RIS file (*.ris)</a><br>
		<!--googleon: all-->
      </div>
      <div class="modal-footer">
				<script>
				function selectText(containerid) {
						if (document.selection) { // IE
								var range = document.body.createTextRange();
								range.moveToElementText(document.getElementById(containerid));
								range.select();
						} else if (window.getSelection) {
								var range = document.createRange();
								range.selectNode(document.getElementById(containerid));
								window.getSelection().removeAllRanges();
								window.getSelection().addRange(range);
						}
				}
				</script>
      </div>
    </div>
  </div>
</div>
							</div>
							<div class="col-md-2">
								<div class="download"><?php echo number_format($articles[0]['download']);?></div>
								<center>Downloads</center>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="profile">
						<?php echo $this->lib_view->get_author_affiliation($articles[0]['sub_id']);?> 						
					</div>                
				</div>
            

				<hr/>
				
				<div class="form-group">
					<div class="section-title" id="abstract">Abstract</div>
					<img class="img-responsive" alt="<?=$articles[0]['title']?>" title="<?=$articles[0]['title']?>" src="<?php echo $this->lib_view->preview_image($articles[0]['sub_id']);?>" style="float:right; margin: 20px">
					<p style="float: left"><?php echo $articles[0]['abstract'];?></p>
					<label>Keywords</label>
					<p><?php echo $articles[0]['keywords'];?></p>
				</div>

				<?php if(strip_tags($articles[0]['introduction']) != "" || strip_tags($articles[0]['introduction']) != null){?>
				<div class="form-group">
					<div class="section-title" id="introduction">Introduction</div>
					<p><?php echo $articles[0]['introduction'];?></p>
				</div>
				<?php } ?>
			
				<?php if(strip_tags($articles[0]['experimental_method']) != "" || strip_tags($articles[0]['experimental_method']) != null){?>
				<div class="form-group">
					<div class="section-title" id="experimental">Experimental Methods</div>
					<p><?php echo $articles[0]['experimental_method'];?></p>					
				</div>
				<?php } ?>

				<?php if(strip_tags($articles[0]['result']) != "" || strip_tags($articles[0]['result']) != null){?>
				<div class="form-group">
					<div class="section-title" id="result">Results and Discussion</div>
					<p><?php echo $articles[0]['result'];?></p>					
				</div>
				<?php } ?>
	
				<?php if(strip_tags($articles[0]['conclusion']) != "" || strip_tags($articles[0]['conclusion']) != null){?>
				<div class="form-group">
					<div class="section-title" id="conclusion">Conclusion</div>
					<p><?php echo $articles[0]['conclusion'];?></p>					
				</div>
				<?php } ?>

				<?php if(strip_tags($articles[0]['acknowledgement']) != "" || strip_tags($articles[0]['acknowledgement']) != null){?>
				<div class="form-group">
					<div class="section-title" id="acknowledgement">Acknowledgement</div>
					<p><?php echo $articles[0]['acknowledgement'];?></p>					
				</div>
				<?php } ?>
				
				
				<?php if(!empty($supplement)){ ?>			
				<div class="form-group">
					<div class="section-title" id="supplement">Supplementary Material</div>
					<table class="table table-bordered table-striped">
					<tr><th>Filename</th><th>Description</th></tr>
					<?php foreach($supplement as $sup){?>
						<tr>
							<td><a href="<?php echo site_url().$sup['file_url'];?>" target="_blank"><?php $name = explode('/', $sup['file_url']); echo $name[count($name)-1];?></a></td>
							<td><?php echo $sup['file_description'] ? $sup['file_description']:'---';?></td>
						</tr>
					<?php }	?>
					</table>
				</div>
				<?php } ?>
				
				<?php if(strip_tags($articles[0]['references']) != "" || strip_tags($articles[0]['references']) != null){?>
				<div class="form-group">
					<div class="section-title" id="references">References</div>
					<p><?php echo $articles[0]['references'];?></p>
				</div>
				<?php } ?>

			<?php } else{ ?>
				<h2 class="heading"><?php echo $title;?></h2>
				<?php if(!empty($articles)){ foreach($articles as $s){?>
					<div class="row">
						<!--div class="col-md-2">
							<img class="img-responsive" alt="image" src="<?php //echo $this->lib_view->preview_image($s['sub_id']);?>">
						</div>
						<div class="col-md-5"-->
						<div class="col-md-7">
							<h2 class="title"><a href="<?php echo site_url().'article/view/'.$s['sub_id'];?>"><?php echo $s['sub_title'];?></a></h2>
							<p><?php echo $this->lib_view->author_submission($s['sub_id']);?></p>
						</div>
						<div class="col-md-5 white">
							<div class="date">
								Publication Date (Web):<br/><?php echo date('d M Y', strtotime($s['date_publish']));?>
								<br/><a href="<?php echo $s['doi_url'];?>"><?php echo $s['doi_url'];?></a><br/>
								<?php echo "Pages : ".$s['pages'];?>
							</div>						
						</div>
					</div>
					<hr/>
				<?php } ?>
				<?php echo $paging; ?>
				<?php } ?>
			<?php } ?>
			
<div id="risTmp" style="display:none">
<!--googleoff: all-->
<?php 
$ttt = $this->lib_view->getRIS($articles[0]['sub_id']);
echo nl2br($ttt);
?>
<!--googleon: all-->
</div>

			<script>
var bibTxt = "<?php 
$ttt = $this->lib_view->getBibtex($articles[0]['sub_id']);
$ttt = str_replace("\n"," ",$ttt);
$ttt = str_replace("\t"," ",$ttt);
$ttt = str_replace("  "," ",$ttt);
echo $ttt;
?>
";
document.addEventListener("DOMContentLoaded", (event) => { 
    document.getElementById('bibCitation').innerHTML = bibTxt;
});
document.addEventListener("DOMContentLoaded", (event) => { 
    document.getElementById('risCitation').innerHTML = document.getElementById('risTmp').innerHTML;
});
			</script>
		</div>
		<?php $this->load->view('template/inc/sidebar');?>
	</div>

</div>
