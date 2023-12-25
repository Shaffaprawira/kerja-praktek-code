<div class="container">
	<div class="row">
		<div class="col-md-8">
		<?php if (isset($detail)){?>
			<h3 class="heading"><?php echo $announcement[0]['ann_title'];?></h3>
			<p>
				<small><?php echo date('M d, Y - H:i', strtotime($announcement[0]['date_input']));?></small><br/>
				<?php echo $announcement[0]['ann_description'];?>
			</p>
		<?php }else{?>
			<h3 class="heading">Announcement</h3>
			<?php if(!empty($announcement)){ ?>
				<table class="table table-striped">
				<?php foreach ($announcement as $a){ ?>
				<tr>
					<td>
						<h5><a href="<?php echo site_url().'announcement/view/'.$a['ann_id'];?>"><?php echo $a['ann_title'];?></a></h5>
						<p>
							<small>Announced : <?php echo date('M d, Y - H:i', strtotime($a['date_input']));?></small><br/>
							<?php echo substr($a['ann_description'],0,100).'...';?>
						</p>
					</td>
				</tr>
				<?php }?>
				</table>
				<hr/>
				<?php echo $paging;?>
			<?php }else{ echo "No announcement yet."; } ?>
		<?php } ?>

		</div>
		<?php $this->load->view('template/inc/sidebar');?>
	</div>
</div>