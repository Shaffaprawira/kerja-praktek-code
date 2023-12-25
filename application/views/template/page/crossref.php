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
			<div class="box-body" style="overflow:scroll">
				<table class="table table-striped table-hover data-table">
				<thead>
					<tr>
						<th>No</th>
						<th>Issue</th>
						<th>Published</th>
						<th>Item</th>
						<th>Status</th>
						<th>Generate XML</th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($issue)){ $no=0; foreach($issue as $a){ $no++;?>
				<tr>
					<td><?php echo $no;?></td>
					<td><a href="<?php echo site_url().'dashboard/submission/issue/'.$a['issue_id'];?>" target="_blank"><?php echo 'Vol '.$a['volume'].', No '.$a['issue_number'].' ('.$a['year'].')';?></a></td>
					<td><?php echo date('d M Y - H:i', strtotime($a['date_publish']));?></td>
					<td><?php echo number_format($this->lib_view->count_submission_issue($a['issue_id']));?></td>
					<td><?php echo $a['status'] == 1 ? '<span class="badge label-success">Current Issue</span>':'<span class="badge label-default">Back Issue</span>';?></td>
					<td>
						<span class="btn-group">
							<a href="<?php echo site_url().'xml_generator/issue/'.$a['issue_id'];?>" class="btn btn-sm btn-default" data-tooltip="tooltip" title="Generate Crossref XML">Crossref</a>
              <a href="<?php echo site_url().'xml_generator_doaj/issue/'.$a['issue_id'];?>" class="btn btn-sm btn-default" data-tooltip="tooltip" title="Generate DOAJ XML">DOAJ</a>
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