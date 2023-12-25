<div class="content-wrapper">
	<section class="content-header">
		<h1>Export <small>Manuscript</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/export';?>"> Export</a></li>
			<li class="active">Manuscript</li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="row">
			<div class="col-md-3 col-lg-3 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-desktop"></i> &nbsp; Export Manuscript</h3>
						<div class="box-tools pull-right">
							
						</div> 
					</div>
					<div class="box-body">
						<form method="GET" action="<?php echo site_url().'dashboard/export';?>">
							<div class="form-group">
								<label>Manuscript Status</label>
								<select name="status" class="form-control">
									<option value="">All Manuscript</option>
									<option value="1" <?php echo $status == 1 ? 'selected':'';?>>Initial Screening</option>
									<option value="2" <?php echo $status == 2 ? 'selected':'';?>>Checked by editor (Post Screening)</option>
									<option value="3" <?php echo $status == 3 ? 'selected':'';?>>Reviewer Assigment</option>
									<option value="4" <?php echo $status == 4 ? 'selected':'';?>>Review Process</option>
									<option value="5" <?php echo $status == 5 ? 'selected':'';?>>Review Received</option>
									<option value="6" <?php echo $status == 6 ? 'selected':'';?>>Decision by Editor</option>
									<option value="7" <?php echo $status == 7 ? 'selected':'';?>>Revised</option>
									<option value="8" <?php echo $status == 8 ? 'selected':'';?>>Accepted</option>
									<option value="9" <?php echo $status == 9 ? 'selected':'';?>>Published</option>
									<option value="11" <?php echo $status == 11 ? 'selected':'';?>>In Press Process</option>
								</select>
							</div>
							<div class="form-group">
								<label>Section</label>
								<select name="section" class="form-control">
									<option value="">All Section</option>
									<?php if(!empty($sections)){ foreach ($sections as $s) {?>
										<option value="<?php echo $s['section_id'];?>" <?php echo $section == $s['section_id'] ? 'selected':'';?>><?php echo $s['section_title'];?></option>
									<?php }} ?>
								</select>
							</div>
							<div class="form-group">
								<label>Year</label>
								<select name="year" class="form-control">
									<option value="">All Years</option>
									<?php for($a=date('Y'); $a > 2005; $a--){?>
										<option value="<?php echo $a;?>" <?php echo $year == $a ? 'selected':'';?>><?php echo $a;?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<input type="submit" name="submit" value="Filter" class="btn btn-primary pull-right">
							</div>
						</form>
					</div>
				</div>
			</div>

			<!-- Result -->
			<div class="col-md-9 col-lg-9 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp; Manuscript Result</h3>
						<div class="box-tools pull-right">
							<a href="<?php echo site_url().'dashboard/export?status='.$status.'&section='.$section.'&year='.$year.'&export=true';?>" class="btn btn-success btn-sm" data-tooltip="tooltip" title="Export to Excel"><i class="fa fa-file-excel-o"></i></a>
						</div> 
					</div>
					<div class="box-body" style="overflow:scroll">
						<table class="table table-striped data-table">
							<thead>
							<tr>
								<th>No</th>
								<th>Manuscript ID</th>
								<th>Title</th>
								<th>Status</th>
								<th>Date Submit</th>
							</tr>
							</thead>
							<tbody>
								<?php if(!empty($submission)){ $no=0; foreach($submission as $a){ $no++;?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $a['round'] > 1 ? 'R'.($a['round']-1).'-':'';?><?php echo $a['section_abv'].'-'.$a['sub_id'];?></td>
									<td><?php echo $a['sub_title'];?></td>
									<td><?php echo submission_status($a['sub_status']);?></td>
									<td><?php echo $this->lib_view->first_submit_date($a['sub_id']);?></td>									
								</tr>
								<?php }} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

	</section>
</div>
