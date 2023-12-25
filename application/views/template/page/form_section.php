<div class="content-wrapper">
	<section class="content-header">
		<h1><?php echo ucwords($title);?></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'dashboard/section';?>">Site Management</a></li>
			<li class="active"><?php echo ucwords($title);?></li>
		</ol>
	</section>
	<?php 
		# data news
		if(!empty($item)){
			$id = $item[0]['section_id'];
			$title = $item[0]['section_title'];
			$abv = $item[0]['section_abv'];
			$form = $item[0]['review_form'];
			$peer_review = $item[0]['peer_review'];
			$abstract_required = $item[0]['abstract_required'];
			$submission_restriction = $item[0]['submission_restriction'];
			$title_restriction = $item[0]['title_restriction'];
			$author_restriction = $item[0]['author_restriction'];
			$action = 'update';
		}else{
			$id = '';
			$title = '';
			$abv = '';
			$form = '';
			$peer_review = 0;
			$abstract_required = 0;
			$submission_restriction = 0;
			$title_restriction = 0;
			$author_restriction = 0;
			$action = 'insert';
		}
	?>
	<section class="content">
		<input type="hidden" name="section_id" value="<?php echo $id;?>">
		<div class="row">
			<form action="<?php echo base_url().'dashboard/'.$action.'/section';?>" method="POST" enctype="multipart/form-data">
			<div class="col-md-8">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-newspaper-o"></i> &nbsp;<?php echo $title ? $title : 'Create Journal Section';?></h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label>Section Title <span>*</span></label>
							<input type="text" name="section_title" class="form-control" value='<?php echo $title;?>' placeholder="Section Title" required>
						</div>
						<div class="form-group">
							<label>Abbreviation <span>*</span></label><br/><small>For example, Article (ART)</small>
							<input name="section_abv" class="form-control" placeholder="Abbreviation" value="<?php echo $abv;?>" required>
						</div>
						<div class="form-group">
							<label>Review Form</label>
							<select name="review_form" class="form-control">
								<option value="0" <?php echo $form == 0 ? 'selected':'';?>>None/Free from review</option>
								<option value="1" <?php echo $form == 1 ? 'selected':'';?>>Review Form (V1)</option>
								<option value="2" <?php echo $form == 2 ? 'selected':'';?>>IJTech Review Form</option>
							</select>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Indexing</label>
									<br/>Submissions made to this section of the journal<br/>
									<input type="checkbox" name="peer_review" value="1" <?php echo $peer_review == 1 ? "checked='checked'":"";?>>  Will not be peer-reviewed <br/>
									<input type="checkbox" name="abstract_required" value="1" <?php echo $abstract_required == 1 ? "checked='checked'":"";?>> Do not required abstract <br/>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Restriction</label><br/>
									<input type="checkbox" name="submission_restriction" value="1" <?php echo $submission_restriction == 1 ? "checked='checked'":"";?>> Items can only be submitted by Editors and Section Editors <br/>							
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Table of Contents</label><br/>
									<input type="checkbox" name="title_restriction" value="1" <?php echo $title_restriction == 1 ? "checked='checked'":"";?>> Omit the title of this section from issues' table of contents.<br/>
									<input type="checkbox" name="author_restriction" value="1" <?php echo $author_restriction == 1 ? "checked='checked'":"";?>> Omit author names for section items from issues' table of contents. <br/>
								</div>
							</div>
						</div>
						<hr/>
						<div class="form-action">
							<input type="submit" name="submit" class="btn btn-primary" value="<?php echo $action == 'insert'? 'Save':'Update';?>">
						</div>
					</div>
				</div>
			</div>
			</form>

			<form action="<?php echo site_url().'dashboard/insert/section_editor';?>" method="POST">
			<input type="hidden" name="section_id" value="<?php echo $id;?>">
			<div class="col-md-4">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-user"></i> &nbsp;Section Editors</h3>
					</div>
					<div class="box-body">
						<?php if($this->uri->segment(2) == "create"){?>
							<div class="alert alert-default">
								You can select section editor after create new section
							</div>
						<?php }else{?>
							<div class="form-group">
								<select name="editor" class="form-control select" required>
									<option value="">- Search editor -</option>
									<?php if(!empty($editors)){ foreach ($editors as $e){?>
										<option value="<?php echo $e['user_id'];?>"><?php echo $e['first_name'].' '.$e['last_name'];?></option>
									<?php }} ?>
								</select><br/><br/>
								<input type="submit" name="submit" class="btn btn-block btn-default" value="Add Editor">
							</div>
							<hr/>
							<h4 class="box-title"><i class="fa fa-arrow-circle-right"></i> The Section's Editors</h4>
							<table class="table usetooltip">
								<tr>
									<th>No.</th>
									<th>Name</th>
									<th>Remove</th>
								</tr>
								<?php if(!empty($section_editor)){ $no=0; foreach($section_editor as $se){ $no++; ?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $se['first_name'].' '.$se['last_name'];?></td>
									<td><a href="<?php echo site_url().'dashboard/delete/section_editor/'.$se['section_id'].'/'.$se['user_id'];?>" class="btn btn-default btn-xs" data-tooltip="tooltip" title="Remove editor"><i class="fa fa-times"></i></a></td>
								</tr>
								<?php }}else{?>
								<tr><td colspan="2">No section editor.</td></tr>
								<?php } ?>
							</table>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		</form>
	</section>
</div>