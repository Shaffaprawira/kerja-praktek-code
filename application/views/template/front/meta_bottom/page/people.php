<script>
	function detail(id){
		$.ajax({
			type : 'GET',
			url : '<?php echo site_url().'home/current_people/';?>'+id,
			success: function(data){				
				var status = 'Member';
				var img = '<img src="<?php echo site_url().'uploads/team/default.jpg';?>" style="width:120px">';
				if(data[0].status == 1)
					status = 'Editor in Chief';
				if(data[0].status == 2)
					status = 'Managing Editor';
				mail = '-----';
				href = data[0].email;
				if(data[0].email !== ""){
					mail = data[0].email;
					if(mail.indexOf("@") > 0){
						href = 'mailto:'+data[0].email;
					}
				}
				if(data[0].photo !== "")
					img = '<img src="<?php echo site_url();?>'+data[0].photo+'" style="width:120px">';

				$(".img-profile").html(img);
				$(".label-status").html('<b>'+status+'</b>');
				$(".label-name").html(data[0].fullname);
				$(".label-email").html('<a href="'+href+'">'+mail+'</a>');
				$(".label-affiliation").html(data[0].affiliation);
				$(".label-country").html(data[0].country);

				$("#google_scholar").attr('href', data[0].google_scholar);
				$("#research_gate").attr('href', data[0].research_gate);
				$("#scopus").attr('href', data[0].scopus);
			}
		});
	}
</script>