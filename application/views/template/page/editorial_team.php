<div class="content-wrapper">
	<section class="content-header">
		<h1>People</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/section';?>">Site Management</a></li>
			<li class="active">Editorial Team</li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-users"></i> &nbsp; Editorial Team</h3>
				<div class="box-tools pull-right">
					<a class="btn btn-primary btn-sm" data-tooltip="tooltip" title="Create section" href="<?php echo base_url().'dashboard/create/people';?>"><i class="fa fa-plus-circle"></i></a>
				</div>
			</div>
			<div class="box-body">
				<table  class="table table-striped table-hover data-table">
				<thead>
					<tr>
						<th>No</th>
						<th>Title</th>
						<th>Name</th>
						<th>Affiliation</th>
						<th>Status</th>
						<th>Last update</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					if(!empty($people)){ $no=0; foreach($people as $a){ $no++; 	?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo $a['salutation'];?></td>
					<td><?php echo $a['fullname'];?><br/><i><?php echo $a['email'];?></i></td>
					<td><?php echo $a['affiliation'];?></td>					
					<td><?php echo status_people($a['status']);?></td>					
					<td><?php echo $a['date_update'];?></td>
					<td>
						<span class="btn-group">
							<a href="<?php echo site_url().'dashboard/edit/people/'.$a['pid'];?>" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
							<a href="<?php echo site_url().'dashboard/delete/people/'.$a['pid'];?>" class="btn btn-sm btn-warning"><i class="fa fa-trash"></i></a>
							<!--a href="#" class="btn btn-sm btn-default"  data-toggle="modal" data-target="#modalDelete" onclick="return delete_people('<?php echo $a['pid'];?>')"><i class="fa fa-trash"></i></a-->
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
				<h4 class="modal-title">Delete Journal Section</h4>
				<div>Remove section from list.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/delete/section';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="section_id" id="item_id">
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
