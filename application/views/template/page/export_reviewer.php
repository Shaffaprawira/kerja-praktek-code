<div class="content-wrapper">
	<section class="content-header">
		<h1>Export <small>Reviewer</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/export';?>"> Export</a></li>
			<li class="active">Reviewer</li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="row">
			<div class="col-md-3 col-lg-3 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-desktop"></i> &nbsp; Export Reviewer</h3>
						<div class="box-tools pull-right">
							
						</div> 
					</div>
					<div class="box-body">
						<form method="GET" action="<?php echo site_url().'dashboard/export/reviewer';?>">
							<div class="form-group">
								<label>Reviewer Status</label>
								<select name="status" class="form-control">
									<option value="" <?php echo $status == NULL ? 'selected':'';?>>All Reviewer</option>
									<option value="1" <?php echo $status == "1" ? 'selected':'';?>>Accept</option>
									<option value="2" <?php echo $status == "2" ? 'selected':'';?>>Reject</option>							
									<option value="0" <?php echo $status == "0" ? 'selected':'';?>>Unconfirm</option>
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
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp; Reviewer Result</h3>
						<div class="box-tools pull-right">
							<a href="<?php echo site_url().'dashboard/export/reviewer?status='.$status.'&year='.$year.'&export=true';?>" class="btn btn-success btn-sm" data-tooltip="tooltip" title="Export to Excel"><i class="fa fa-file-excel-o"></i></a>
						</div> 
					</div>
					<div class="box-body" style="overflow:scroll">
						<table class="table table-striped data-table">
							<thead>
							<tr>
								<th>No</th>
								<th>Salutation</th>
								<th>Fullname</th>
								<th>Email</th>
								<th>Affiliation</th>
								<th>Expertise</th>
								<!-- <th>Date Invite</th> -->
							</tr>
							</thead>
							<tbody>
								<?php if(!empty($reviewer)){ $no=0; foreach($reviewer as $a){ $no++;?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $a['salutation'];?></td>
									<td><?php echo $a['fullname'];?></td>
									<td><?php echo $a['email'];?></td>
									<td><?php echo $a['affiliation'];?></td>
									<td><?php echo $a['expertise'];?></td>
									<!-- <td><?php echo $a['date_input'];?></td>-->
								</tr>
								<?php }} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

	</section>
</div>
