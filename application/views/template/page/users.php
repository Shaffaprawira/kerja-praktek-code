<div class="content-wrapper">
	<section class="content-header">
		<h1>User <small>Management</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/users';?>"> User Management</a></li>
			<li class="active">Enrolled Users</li>
		</ol>
	</section>

	<section class="content usetooltip">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-mortar-board"></i> &nbsp; Users</h3>
				<div class="box-tools pull-right">
					<a class="btn btn-primary btn-sm" data-tooltip="tooltip" title="Register new user" href="<?php echo base_url().'dashboard/create/user';?>"><i class="fa fa-plus-circle"></i></a>
				</div> 
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12 pull-right">
						<form action="<?php echo site_url().'dashboard/search/users';?>" method="GET">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-btn">
										<a class="btn btn-default dropdown-toggle choice" data-toggle="dropdown" href="#" aria-expanded="false">
									      <?php echo isset($filter) ? $filter : 'Search by';?> <span class="caret"></span>
									    </a>
									    <ul class="dropdown-menu" style="z-index:100000">
											<li class="filter" data-value="first_name"><a href="#issue">First Name</a></li>
											<li class="filter" data-value="last_name"><a href="#author">Last Name</a></li>
											<li class="filter" data-value="email"><a href="#title">Email</a></li>
									    </ul>  
									</span>
									<input type="hidden" name="filter" class="filter-value" value="first_name">
									<input type="search" name="search" class="form-control" value="<?php echo isset($keyword) ? $keyword :'';?>" placeholder="Enter keyword...">
									<span class="input-group-btn">
										<button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
						</form>
					</div>
				</div>
				
				<table  class="table table-striped table-hover">
				<thead>
					<tr style="background-color: #337ab7; color:#FFF">
						<th>No</th>
						<th>Name</th>
						<th>Email</th>
						<th>Role(s)</th>
						<th>Status</th>
						<th>Date Register</th>
						<th>Action</th>
					</tr>
				</thead>				
				<tbody>
				<?php 
					if(!empty($users)){ 
						$no=0;
						$page = $this->uri->segment(5);
						if($page != "")
							$no = ($page-1)*10;
						foreach($users as $a){ $no++;
				?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo $a['first_name'].' '.$a['last_name'].' '.$this->lib_view->user_signal($a['user_id']);?> </td>
					<td><?php echo $a['email'];?></td>
					<td><?php echo $this->lib_view->gen_roles($a['user_id']);?></td>					
					<td><?php echo $a['status'] == 1 ? '<span class="badge label-success">Aktif</span>':'<span class="badge label-default">Inactive</span>';?></td>
					<td><?php echo date('d M Y - H:i', strtotime($a['date_create']));?></td>
					<td>
						<span class="btn-group">
							<a href="<?php echo site_url().'dashboard/profile/'.md5($a['user_id']);?>" class="btn btn-sm btn-default" data-tooltip="tooltip" title="Detail user"><i class="fa fa-search"></i></a>
							<a href="#" class="btn btn-sm btn-default"  data-toggle="modal" data-target="#modalStatus" onclick="return status_user('<?php echo $a['user_id'].'#'.$a['status'];?>')" data-tooltip="tooltip" title="Change status"><i class="fa fa-check-circle"></i></a>
<!--Login as 
date modified = 19-9-2018, vincent-->							
							<a href="<?php echo base_url().'dashboard/login_as_user/'.urlencode($a['user_id']);?>" class="btn btn-sm btn-default" class="btn btn-sm btn-default" data-tooltip="tooltip">Login as</a>
							
							<button aria-expanded="false" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">More...
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<?php if (in_array(1, $this->session->userdata('role'))){?>
								<li><a href="#" data-toggle="modal" data-target="#modalDelete" onclick="return delete_user('<?php echo $a['user_id'];?>')"><i class="fa fa-trash"></i> Delete</a></li>
								<?php } ?>
								<li><a href="#" data-toggle="modal" data-target="#modalPrivilage" onclick="return user_privilage('<?php echo $a['user_id'];?>')"><i class="fa fa-key"></i> Change Privilage</a></li>
								<li><a href="#" data-toggle="modal" data-target="#modalReset" onclick="return reset('<?php echo $a['user_id'];?>')"><i class="fa fa-refresh"></i> Reset Password</a></li>
							</ul>
						</span>
					</td>
				</tr>
				<?php } ?>
				<tr><td colspan="2"><?php echo $msg ? $msg : '';?></b></td><td colspan="5"><?php echo $paging;?></td></tr>
				<?php }else{?>
				<tr><td class="note" colspan="7">Data not found!</tr>
				<?php } ?>
				</tbody>
				</table>
				<hr/>
				
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
				<i class="fa fa-user-times modal-icon"></i>
				<h4 class="modal-title">Delete User</h4>
				<div>Remove user from list.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/delete/user';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="user_id" id="user_id">
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
				<i class="fa fa-check-circle modal-icon"></i>
				<h4 class="modal-title">Status User</h4>
				<div>Active or inactive user status.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/update/user_status';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="user_id" id="user_id_status">
				<input type="hidden" name="status" id="status">
				<div class="msg"></div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="Change" class="btn btn-warning action">
			</div>
			</form>
		</div>	
	</div>
</div>

<!-- modal reset -->
<div class="modal inmodal" id="modalReset" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-refresh modal-icon"></i>
				<h4 class="modal-title">Reset Password</h4>
				<div>Reset default password.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/update/reset_password';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="user_id" id="user_pass_id">
				<div class="msg"></div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="Reset" class="btn btn-warning action">
			</div>
			</form>
		</div>	
	</div>
</div>

<!-- modal privilage -->
<div class="modal inmodal" id="modalPrivilage" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-key modal-icon"></i>
				<h4 class="modal-title">User Privilages</h4>
				<div>Setting user privilages.</div>
			</div>
			<form name="privilage" action="<?php echo base_url().'dashboard/update/user_privilage';?>" method="POST">
			<input type="hidden" name="page" value="<?php echo current_url();?>">
			<div class="modal-body">				
				<div class="msg-privilage"></div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="submit" value="Save" class="btn btn-primary action">
			</div>
			</form>
		</div>	
	</div>
</div>
