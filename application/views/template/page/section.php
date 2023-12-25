<div class="content-wrapper">
	<section class="content-header">
		<h1>Journal Section</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/section';?>">Site Management</a></li>
			<li class="active">Journal Section</li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp; Journal Section</h3>
				<div class="box-tools pull-right">
					<a class="btn btn-primary btn-sm" data-tooltip="tooltip" title="Create section" href="<?php echo base_url().'dashboard/create/section';?>"><i class="fa fa-plus-circle"></i></a>
				</div>
			</div>
			<div class="box-body">
				<table  class="table table-striped table-hover data-table">
				<thead>
					<tr>
						<th>No</th>
						<th>Section Title</th>
						<th>Abbrev.</th>
						<th>Last update</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					if(!empty($section)){ $no=0; foreach($section as $a){ $no++; 	?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo $a['section_title'];?></td>
					<td><?php echo $a['section_abv'];?></td>					
					<td><?php echo $a['date_update'] !== '0000-00-00 00:00:00' ? date('d M Y - H:i', strtotime($a['date_input'])) : 'No expired date';?></td>
					<td>
						<span class="btn-group">
							<a href="<?php echo site_url().'dashboard/edit/section/'.$a['section_id'];?>" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-sm btn-default"  data-toggle="modal" data-target="#modalDelete" onclick="return delete_article('<?php echo $a['section_id'];?>')"><i class="fa fa-trash"></i></a>
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
