<div class="content-wrapper">
	<section class="content-header">
		<h1>Static Pages</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/about';?>"> About the Journal</a></li>
			<li class="active">Pages</li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-book"></i> &nbsp; About the Journal</h3>
				<div class="box-tools pull-right">
					<a href="<?php echo site_url().'dashboard/create/page';?>" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i></a>
				</div>
			</div>
			<div class="box-body">
				<table  class="table table-striped">
				<thead>
					<th width="20">No</th>
					<th>Page title</th>
					<th>Date Created</th>
					<th>Last updated</th>
					<th width="120">Action</th>
				</thead>
				<tbody>
				<?php if(!empty($static)){ $no=0; foreach($static as $a){ $no++; ?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo $a['page_title'];?></td>
					<td><?php echo date('d M Y - H:i', strtotime($a['date_input']));?></td>
					<td><?php echo date('d M Y - H:i', strtotime($a['date_update']));?></td>
					<td>
						<span class="btn-group">
							<a href="<?php echo site_url().'dashboard/edit/page/'.$a['page_id'];?>" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
							<!-- a href="#" class="btn btn-sm btn-default"  data-toggle="modal" data-target="#modalDelete" onclick="return delete_article('<?php echo $a['page_id'];?>')"><i class="fa fa-trash"></i></a -->
						</td>
				</tr>
				<?php }}else{?>
				<tr><td colspan="5">No page available...</td></tr>
				<?php }?>
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
				<h4 class="modal-title">Delete Page</h4>
				<div>Remove Page from System.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/delete/page';?>" method="POST">
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
