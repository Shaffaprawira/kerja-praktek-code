<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">
	<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
	<i class="fa fa-envelope modal-icon" style="font-size: 3em;"></i>
	<h4 class="modal-title">Sent Message</h4>
	<div>Draft message sent to author(s)</div>
</div>			
<div class="modal-body" style="max-height: 400px; overflow: auto;">

	<!-- Messages screening -->
	<?php 
	$authors = array();
	foreach($msg['author'] as $a){
		array_push($authors, $a['salutation'].' '.$a['first_name'].' '.$a['last_name'].' <i>['.$a['email'].']</i>');
	}
	?>
	<table class="table-striped">
		<tr><th width="100">From</th><td>: <?php echo $msg['sender'][0]['salutation'].' '.$msg['sender'][0]['first_name'].' '.$msg['sender'][0]['last_name'];?></td></tr>
		<tr><th>To</th><td>: <?php echo implode(', ', $authors);?></td></tr>
		<tr><th>Subject</th><td>: Editor dicision manuscript</td></tr>
	</table>
	<hr/>
	Dear <b><?php echo $msg['author'][0]['salutation'].' '.$msg['author'][0]['first_name'].' '.$msg['author'][0]['last_name'];?> </b>

	<p>
	We have finished doing review and decided about your manuscript entitled [ <b><?php echo $msg['submission'][0]['sub_title'];?></b> ] which submitted on International Journal of Technology.
	</p>

	<p>Please login into application <a href="<?php echo site_url().'login';?>"><?php echo site_url().'login';?></a> to view editor decision</p>

	<p>
	Yours sincerely,<br/>
	IJTech Secretariat<br/>
	ijtech@eng.ui.ac.id<br/>
	</p>

	<p>
	<b>Title :</b> <?php echo $msg['submission'][0]['sub_title'];?><br/>
	<b>Abstract :</b> <?php echo $msg['submission'][0]['abstract'];?>
	</p>

	<p>
	International Journal of Technology (IJTech)<br/>
	p-ISSN : 2086-9614<br/>
	e-ISSN 2087-2100, <a href="<?php echo site_url();?>"><?php echo site_url();?></a>
	</p>

</div>
<div class="modal-footer">
	<input type="reset" name="reset" class="btn btn-default" value="Close" data-dismiss="modal">				
</div>	