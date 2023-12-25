<script>
	function get_abstract(id){
		$.ajax({
			type:'GET',
			url:'<?php echo site_url()."home/current_publication/";?>'+id,
			success: function(data){
				res = JSON.parse(data);
				$("#titlePub").html(res[0].title);
				$("#contentPub").html(res[0].abstract);
			}
		});
	}
</script>
