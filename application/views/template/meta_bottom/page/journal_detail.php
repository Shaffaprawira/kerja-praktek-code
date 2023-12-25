<script type="text/javascript">
	$(window).scroll(function (event) {
	    var scroll = $(window).scrollTop();
	    // Do something
	    if(scroll > 150){
	    	$(".sidebar-content").addClass("sidebar-static");
	    }else{
	    	$(".sidebar-content").removeClass("sidebar-static");	    	
	    }

	});
</script>