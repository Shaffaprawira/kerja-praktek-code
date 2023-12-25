<div class="content-wrapper">
	<section class="content-header">
		<h1>Issue <small>Management</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/issue';?>"> Issue Management</a></li>
			<li class="active">Issue</li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-book"></i> &nbsp; Issue</h3>
				<div class="box-tools pull-right">
					<a class="btn btn-primary btn-sm" data-tooltip="tooltip" title="Create Issue" href="<?php echo base_url().'dashboard/create/issue';?>"><i class="fa fa-plus-circle"></i></a>
				</div> 
			</div>
			<div class="box-body">
				<table class="table table-striped table-hover data-table">
				<thead>
					<tr>
						<th>No</th>
						<th>Issue</th>
						<th>Published</th>
						<th>Item</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($issue)){ $no=0; foreach($issue as $a){ $no++;?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo 'Vol '.$a['volume'].', No '.$a['issue_number'].' ('.$a['year'].')';?> <?php echo $a['special_issue'] == 1 ? '<sup class="badge label-danger">Special Issue</sup>':'';?></td>
					<td><?php echo date('d M Y - H:i', strtotime($a['date_publish']));?></td>
					<td><?php echo number_format($this->lib_view->count_submission_issue($a['issue_id']));?></td>
					<td><?php echo $a['status'] == 1 ? '<span class="badge label-success">Current Issue</span>':'<span class="badge label-default">Back Issue</span>';?></td>
					<td>
						<span class="btn-group">
							<a href="<?php echo site_url().'dashboard/edit/issue/'.$a['issue_id'];?>" class="btn btn-sm btn-default" data-tooltip="tooltip" title="Edit Issue"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-sm btn-default"  data-toggle="modal" data-target="#modalStatus" onclick="return change_issue('<?php echo $a['issue_id'];?>')" data-tooltip="tooltip" title="Set Current Issue"><i class="fa fa-check-circle"></i></a>
                            <?php if($a['status'] == 1){ //if current issue ?>
                                <a onclick="return confirm('Are you sure?')" href="<?=base_url().'dashboard/broadcastNewIssueNews/'.$a['issue_id']?>" class="btn btn-sm btn-success" data-tooltip="tooltip" title="Notify all users that this issue is published"><i class="fa fa-envelope"></i></a>
                            <?php } ?>
							<?php if($a['date_publish'] > date("Y-m-d")){ ?><a href="#" class="btn btn-sm btn-default"  data-toggle="modal" data-target="#modalDelete" onclick="return delete_issue('<?php echo $a['issue_id'];?>')" data-tooltip="tooltip" title="Delete Issue"><i class="fa fa-trash"></i></a><?php } ?>
						</span>
					</td>
				</tr>
				<?php }}?>
				</tbody>
				</table>
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
				<h4 class="modal-title">Delete Issue</h4>
				<div>Remove issue from list.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/delete/issue';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="issue_id" id="item_id">
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

<!-- modal status -->
<div class="modal inmodal" id="modalStatus" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-book modal-icon"></i>
				<h4 class="modal-title">Set Current Issue</h4>
				<div>Set selected issue as current issue.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/update/issue_status';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="issue_id" id="issue_id_status">				
				<div class="msg">Are you sure want to change this issue as current issue?</div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="Change" class="btn btn-warning action">
			</div>
			</form>
		</div>	
	</div>
</div>