<div class="container">

	<div class="row">
		<div class="col-md-8">			
			<h2 class="heading"><?php echo $title;?></h2>
			<!-- description issue -->
			<div class="row">
				<div class="col-md-12">
					<h4>Editor in Chief</h4>
					<?php if(!empty($people1)){ ?>
					<ol>
						<?php foreach ($people1 as $i){ 
							if($i['salutation']!=''){ $i['fullname'] = $i['salutation'].' '.$i['fullname']; } ?>
							<li><a href="#" onclick="return detail('<?php echo $i['pid'];?>')" data-toggle="modal" data-target="#modalProfile"><?php echo $i['fullname'];?></a>, <?php echo $i['affiliation'].', '.$i['country'];?></li>
						<?php } ?>
					</ol>
					<?php } ?>

					<h4>Managing Editor</h4>
					<?php if(!empty($people2)){ ?>
					<ol>
						<?php foreach ($people2 as $i){
							if($i['salutation']!=''){ $i['fullname'] = $i['salutation'].' '.$i['fullname']; } ?>
							<li><a href="#" onclick="return detail('<?php echo $i['pid'];?>')" data-toggle="modal" data-target="#modalProfile"><?php echo $i['fullname'];?></a>, <?php echo $i['affiliation'].', '.$i['country'];?></li>
						<?php } ?>
					</ol>
					<?php } ?>

					<h4>Members</h4>
					<?php if(!empty($people3)){ ?>
					<ol>
						<?php foreach ($people3 as $i){
							if($i['salutation']!=''){ $i['fullname'] = $i['salutation'].' '.$i['fullname']; } ?>
							<li><a href="#" onclick="return detail('<?php echo $i['pid'];?>')" data-toggle="modal" data-target="#modalProfile"><?php echo $i['fullname'];?></a>, <?php echo $i['affiliation'].', '.$i['country'];?></li>
						<?php } ?>
					</ol>
					<?php } ?>
				</div>
			</div>

		</div>
		<?php $this->load->view('template/inc/sidebar');?>
	</div>

</div>

<!-- modal -->
<div class="modal" id="modalProfile">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Editorial Team</h4>
			</div>
			<div class="modal-body">
				<table class="table">
					<tr>
						<td rowspan="6" style="width:135px;" class="img-profile"></td>
						<td>Status</td>
						<td class="label-status"></td>
					</tr>
					<tr><td>Fullname</td><td class="label-name"></td></tr>
					<!--tr><td>Email/URL</td><td class="label-email"></td></tr-->
					<tr><td>Affiliation</td><td class="label-affiliation"></td></tr>
					<tr><td>Country</td><td class="label-country"></td></tr>				
					<tr><td>Research ID</td>
						<td>
							<span><a href="#" id="google_scholar">Google Scholar</a></span> | 
							<span><a href="#" id="research_gate">Research Gate</a></span> | 
							<span><a href="#" id="scopus">Scopus</a></span>
						</td>
					</tr>				
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>