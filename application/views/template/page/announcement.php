<div class="content-wrapper">
	<section class="content-header">
		<h1>Announcement</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/announcement';?>">Site Management</a></li>
			<li class="active">Announcement</li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp; Announcement</h3>
				<div class="box-tools pull-right">
					<a class="btn btn-primary btn-sm" data-tooltip="tooltip" title="Create Announcement" href="<?php echo base_url().'dashboard/create/announcement';?>"><i class="fa fa-plus-circle"></i></a>
				</div>
			</div>
			<div class="box-body">
				<table  class="table table-striped table-hover data-table">
				<thead>
					<th>No</th>
					<th>Title</th>
					<th>Description</th>
					<th>Date Announced</th>
					<th>Expired</th>
					<th>Action</th>
				</thead>
				<tbody>
				<?php 
					if(!empty($announcement)){ $no=0; foreach($announcement as $a){ $no++; 	?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo $a['ann_title'];?></td>
					<td><?php echo $a['ann_description'];?></td>					
					<td><?php echo date('d M Y - H:i', strtotime($a['date_input']));?></td>
					<td><?php echo $a['expire_date'] !== '0000-00-00 00:00:00' ? date('d M Y - H:i', strtotime($a['expire_date'])) : 'No expired date';?></td>
					<td>
						<span class="btn-group">
							<a href="<?php echo site_url().'dashboard/edit/announcement/'.$a['ann_id'];?>" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-sm btn-default"  data-toggle="modal" data-target="#modalDelete" onclick="return delete_article('<?php echo $a['ann_id'];?>')"><i class="fa fa-trash"></i></a>
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
				<h4 class="modal-title">Delete Announcement</h4>
				<div>Remove Announcement from list.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/delete/announcement';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="ann_id" id="item_id">
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
