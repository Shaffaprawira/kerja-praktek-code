<style>
.popover{
	font-family: "Droid Serif";
}
.popover-title{
	background-color: #158cba;
	color: #EEE;
}
.popover-content{
	font-size: 14px;
}
.popover div p{
	font-size: 0.8em;
	border-top: solid 1px #DDD;
	padding-top: 4px;
	margin-top: 4px;
	background-color: #FFFFDD;
}
</style>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Schedule <small>Reminder</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/reminder';?>"> Reminder</a></li>
			<li class="active">Reminder</li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="row">
			<div class="col-md-3 col-lg-3 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-clock-o"></i> &nbsp; Scheduler</h3>
						<div class="box-tools pull-right">
							
						</div> 
					</div>
					<div class="box-body">
						<form method="GET" action="<?php echo site_url().'dashboard/reminder';?>">
							<div class="form-group">
								<label>Reminder Type</label>
								<select name="type" class="form-control">
									<option value="1" <?php echo $type == "1" ? 'selected':'';?>>Revise Manuscript (Author)</option>
									<option value="2" <?php echo $type == "2" ? 'selected':'';?>>Review Invitation (Reviewer)</option>							
									<option value="3" <?php echo $type == "3" ? 'selected':'';?>>Review Manuscript (Reviewer)</option>
								</select>
							</div>
							<div class="form-group">
								<input type="submit" name="submit" value="View" class="btn btn-primary pull-right">
							</div>
						</form>
					</div>
				</div>
			</div>

			<!-- Result -->
			<div class="col-md-9 col-lg-9 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-clock-o"></i> &nbsp; Schedule Reminder</h3>
						<div class="box-tools pull-right">							
						</div> 
					</div>
					<div class="box-body" style="overflow:scroll">
						<table class="table table-striped data-table">
							<thead>
							<tr>
								<th>No</th>
								<th>Manuscript</th>
								<th>Email Destination</th>
								<th>Date Set</th>
								<th>Date Remind</th>
								<th>Attempt</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
								<?php 
									if(!empty($reminder)){ $no=0; foreach($reminder as $a){ $no++;
										$_status = $a['sub_status'] == 0 || $a['sub_status'] == 7 ? "":"<i class='fa fa-check-circle text-success'></i>";
									$content = '<div>'.$a['sub_title'].' ('.$a['sub_status'].')</div><p> Author(s): '.$this->lib_view->author_submission($a['sub_id']).'</p>';
								?>
								<tr>
									<td><?php echo $no;?></td>
									<td><span class="btn" data-toggle="popover" title="<b>Manuscript:</b>" data-content="<?php echo $content;?>" data-trigger="hover" data-html="true"><i class="fa fa-file-text-o fa-2x"></i></span></td>
									<td><?php echo $a['email_destination'];?></td>
									<td><?php echo $a['date_set'];?></td>
									<td><?php echo $a['date_remind'];?></td>
									<td align="center"><?php echo $a['attempt'];?></td>
									<td width="100">
										<span class="btn-group">
											<a href="#" data-toggle="modal" data-tooltip="tooltip" data-target="#modalSend" title="Send Email Reminder" class="btn btn-default btn-sm" onclick="return reminder('send', '<?php echo $a['reminder_id'];?>');" data-type=""><i class="fa fa-send"></i></a>
											<a href="#" data-toggle="modal" data-tooltip="tooltip" data-target="#modalSend" title="Stop Reminder" class="btn btn-danger btn-sm" onclick="return reminder('stop', '<?php echo $a['reminder_id'];?>');"><i class="fa fa-exclamation-circle"></i></a>
										</span>
									</td>
								</tr>
								<?php }} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

	</section>
</div>


<!-- modal publish -->
<div class="modal inmodal" id="modalSend" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-exclamation-circle modal-icon icon"></i>
				<h4 class="modal-title set-header"></h4>
				<div class="set-header-label"></div>
			</div>
			<form name="formreminder" action="<?php echo base_url().'reminder/sendaction';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="sub_id" id="sub_id">
				<input type="hidden" name="email_destination" id="email_destination">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<input type="hidden" name="action" id="action">
				<input type="hidden" name="reminder_id" id="reminder_id">
				<input type="hidden" name="type" value="<?php echo $type ? $type : 1;?>">
				<div class="msg">
					<div class="callout callout-default msg-reminder"></div>	
				</div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="OK" class="btn btn-success action">
			</div>
			</form>
		</div>	
	</div>
</div>
