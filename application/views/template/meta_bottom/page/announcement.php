<!-- DataTables -->
<script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js';?>"></script>
<script>
$(function(){
	$(".data-table").DataTable();
});

function delete_article(id){
	$("#item_id").val(id);
	$(".msg").html("Are you sure want to delete this announcement?");
}
</script>