<div class="content-wrapper">
	<section class="content-header">
		<h1>Journal Editions</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/section';?>">Site Management</a></li>
			<li class="active">Journal Editions</li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp; Journal Editions</h3>
				<div class="box-tools pull-right">
					<a class="btn btn-primary btn-sm" data-tooltip="tooltip" title="Create section" href="<?php echo base_url().'dashboard/create/edition';?>"><i class="fa fa-plus-circle"></i></a>
				</div>
			</div>
			<div class="box-body">
				<table  class="table table-striped table-hover data-table">
				<thead>
					<tr>
						<th>No</th>
						<th>Edition Title</th>
						<th>Abbreviation</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					if(!empty($section)){ $no=0; foreach($section as $a){ $no++; 	?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo $a['title'];?></td>
					<td><?php echo $a['abv'];?></td>
					<td><?php echo $a['status'];?></td>					
					<td>
						<span class="btn-group">
							<a href="<?php echo site_url().'dashboard/edit/edition/'.$a['id'];?>" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
							<a href="<?php echo base_url().'dashboard/delete/edition/'.$a['id'];?>" class="btn btn-sm btn-default" onclick="if(confirm('Are you sure?')){return true;}else{return false;}"><i class="fa fa-trash"></i></a>
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


