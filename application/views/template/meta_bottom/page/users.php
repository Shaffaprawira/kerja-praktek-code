<!-- DataTables -->
<script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js';?>"></script>
<script>

$(function(){
	// $(".data-table").DataTable();
	$('.filter').click(function(){
		var filter = $(this).attr('data-value');
		by = filter.replace('_',' ');
		$('.filter-value').val(filter);
		$('.choice').html(by+ ' <span class="caret"></span>').css({'text-transform': 'capitalize'});
	});
});

function delete_user(id){
	$("#user_id").val(id);
	$(".msg").html("Are you sure want to delete this user?");
}
function status_user(id){
	sts = id.split('#');
	$("#user_id_status").val(sts[0]);
	$("#status").val(sts[1]);
	$(".msg").html("Are you sure want to inactivate this user?");
	if(sts[1] == 0)
		$(".msg").html("Are you sure want to activate this user?");
}
function reset(id){
	$("#user_pass_id").val(id);
	$(".msg").html("Are you sure want to change the password selected user with default : <b>123456</b>?");
}

function user_privilage(id){
	$.ajax({
		url : '<?php echo site_url()."dashboard/get_user_privilage/";?>'+id,
		method : 'GET',
		success : function(data){
			$(".msg-privilage").html(data);
		}
	});
}
</script>