<div class="content-wrapper">
	<section class="content-header">
		<h1>Online <small>Submission</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/submission';?>"> Submission Review</a></li>
			<li class="active"><?php echo $sts;?></li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-search"></i> &nbsp; Submission Review <?php echo '<i>'.$sts .'</i>';?></h3>				
			</div>
			<div class="box-body" style="overflow:scroll">
				<table class="table table-striped data-table">
				<thead>
					<tr>
						<th>No.</th>
						<th>Assigned</th>
						<th width="100">Manuscript ID</th>
						<th>Title</th>
						<th>Review Result</th>
						<th></th>
<!--tabel certif-->
<?php if($type=='archive'){ echo '<th>Certificate</th>'; } ?>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($submission_review)){ $no=0; foreach ($submission_review as $sr){ $no++; ?>
				<tr>
					<td><?php echo $no;?></td>
					<td width="150"><?php 
					    if(is_null($sr['date_round_start']) || $sr['date_round_start']=='0000-00-00 00:00:00'){
					        echo '<span style="color:red">Need confirmation</span><br>Invited at:<br>'.date('d M Y - H:i', strtotime($sr['date_invite']));
					    }else{
					        echo date('d M Y - H:i', strtotime($sr['date_round_start']));
					    }
					?></td>
					<td><?php echo $sr['round'] > 1 ? 'R'.($sr['round']-1).'-':'';?><?php echo $sr['section_abv'].'-'.$sr['sub_id'];?> (<?=$sr['edition']?>)</td>
					<td><a href="<?php echo site_url().'dashboard/review/'.$sr['sub_id'].'/'.$sr['review_id'];?>"><?php echo $sr['sub_title'];?></a></td>
					<td><?php echo review_result($sr['review_result']);?></td>
					<td><a class="btn btn-primary btn-sm" href="<?php echo site_url().'dashboard/review/'.$sr['sub_id'].'/'.$sr['review_id'];?>" data-tooltip="tooltip" title="Start Review"><i class="fa fa-search"></i></a></td>
<!--tabel certif-->
<?php if($type=='archive'){ ?>
					<td><a target="_blank" class="btn btn-primary btn-sm" href="<?php echo site_url().'dashboard/
					certificate/'.$sr['sub_id'].'/'.$sr['review_id'];?>"> <i class="fa 
					fa-certificate"></i> Download</a></td>
<?php } ?>
				</tr>
				<?php } } ?>
				</tbody>
				</table>
			</div>
		</div>
	</section>
</div>
