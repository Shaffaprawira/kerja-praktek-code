<script src="<?php echo base_url().'assets/plugins/summernote/summernote.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js';?>"></script>
<script>
$(function(){
	$('.summernote').summernote({
        'height': '100px',
        'toolbar': [
		    ['font', ['bold', 'italic', 'underline', 'clear']],
		    ['fontname', ['fontname']],
		    ['color', ['color']],
		    ['para', ['ul', 'ol', 'paragraph']],		  
		],
    });

	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});

});
</script>