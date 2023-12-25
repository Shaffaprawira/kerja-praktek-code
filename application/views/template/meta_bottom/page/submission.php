<!-- DataTables -->
<script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js';?>"></script>
<script type="text/javascript">
$(function(){
	$(".data-table").DataTable({
		// "order":[[1, "desc"]]
	});
});

function delete_submission(id){
	$("#item_id").val(id);
	$(".msg").html("Are you sure want to delete this submission?");
}

function revise_agreement(str){
	var id = str.split('#');
	$("#sub_item_id").val(id[0]);
	$("#round").val(id[1]);
}

function prepare_publish(id){
	$.ajax({
		method : 'GET',
		url : '<?php echo site_url()."dashboard/get_submission_json/";?>'+id,
		success: function(data){			
			$("#sub_id_publish").val(data[0].sub_id);
			$("#manuscript_title").html(data[0].sub_title);
		}
	});
}

function inline_editing(id){
	$.ajax({
		method : 'GET',
		url : '<?php echo site_url()."dashboard/get_submission_json/";?>'+id,
		success: function(data){
			console.log(data);
			$("#sub_id_inline").val(data[0].sub_id);
			$("#manuscript_title_inline").html(data[0].sub_title);
		}
	});
}

function withdraw(str){
	_str = str.split('#');
	sub_id = _str[0];
	title = _str[1];
	id = _str[2];
	$("#wdsub_id").val(sub_id);
	$(".wdmid").html('Withdraw manuscript ID '+id);
	$(".wdmsg").html('Are you sure you want to draw a manuscript the title <b>"'+title+'"</b>? <br/><br/><span class="text-danger">All running processes related to this manuscript will be stoped!</span>');
}

function erratum(sub_id){ //Ruki16feb2019
	$("#ersub_id").val(sub_id);
	$("#ersub_link").attr("href", '<?php echo site_url()."article/view/";?>'+sub_id);
}

</script>