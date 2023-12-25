<!-- DataTables -->
<script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js';?>"></script>
<script type="text/javascript">
$(function(){
	$(".data-table").DataTable({
		drawCallback : function(){
    		$('[data-toggle="popover"]').popover();
  		}
	});
	$('[data-toggle="popover"]').popover();
});

function reminder(action, id){
	$("#action").val(action);
	$.ajax({
		type: 'GET',
		url : '<?php echo site_url().'reminder/get_reminder/';?>'+id,
		success: function(res){
			$("#reminder_id").val(res[0].reminder_id);
			$("#sub_id").val(res[0].sub_id);
			$("#email_destination").val(res[0].email_destination);
			header = "Send Reminder";
			label = "Send reminder for this email";
			msg = '<i class="fa fa-info-circle"></i> Send email reminder to <b>'+res[0].email_destination+'</b>';
			$(".action").removeClass('btn-danger').addClass('btn-success');
			if(action == 'stop'){
				$(".action").removeClass('btn-success').addClass('btn-danger');
				header = "Stop Reminder";
				label = "Stop author reminder for this email";
				msg = '<i class="fa fa-info-circle"></i> Stop send email reminder to <b>'+res[0].email_destination+'</b>';
			}
			$(".set-header").html(header);
			$(".set-header-label").html(label);
			$(".msg-reminder").html(msg);

		}
	});
	
}

</script>