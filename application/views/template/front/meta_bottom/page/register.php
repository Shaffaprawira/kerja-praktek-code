<script src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js';?>"></script>
	<script>
	  $(function () {
		$('input').iCheck({
		  checkboxClass: 'icheckbox_square-blue',
		  radioClass: 'iradio_square-blue',
		  increaseArea: '20%'
		});
		
		
		$('#user_id').on('blur', function(){
			var id = $(this).val();
			$.ajax({
				type:'POST',
				data:{key:'user_id', value:id},
				url: '<?php echo site_url()."login/check_user";?>',
				success: function(data){
					if(data > 0){
						$(".note-userid").fadeIn();
						$(".submit").attr('disabled', true);
					}else{
						$(".note-userid").fadeOut();
						$(".submit").attr('disabled', false);
					} 
				},error: function(){
					alert('error, Please check your internet connection!');
				}
			});
		});
		
		$('#email').on('blur', function(){
			var email = $(this).val();
			$.ajax({
				type:'POST',
				data:{key:'email', value:email},
				url: '<?php echo site_url()."login/check_user";?>',
				success: function(data){
					if(data > 0){
						$(".note-email").fadeIn();
						$(".submit").attr('disabled', true);
					}else{
						$(".note-email").fadeOut();
						$(".submit").attr('disabled', false);
					} 
				},error: function(){
					alert('error, Please check your internet connection!');
				}
			});
		});

	  });

	/*
	$(".reviewer").click(function(){
		$("#main-interest").toggle();
	});
	*/
	
	</script>