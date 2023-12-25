
<script src="<?php echo base_url().'assets/plugins/summernote/summernote.js';?>"></script>
<!--script src="<?php echo base_url().'assets/plugins/summernote/plugin/summernote-cleaner-master/summernote-cleaner.js';?>"></script-->

<script>
$(function(){
	// summernote
    $('.summernote').summernote({
        'height': '400px',
        toolbar: [
            // ['cleaner',['cleaner']],
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            // ['color', ['color']],
            // ['para', ['ul', 'ol', 'paragraph']],
            // ['height', ['height']],
            // ['table', ['table']],
            // ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview']],
            // ['help', ['help']]
          ],
          // cleaner:{
              // notTime: 1000, // Time to display Notifications.
              // action: 'button', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
              // newline: '<br>', // Summernote's default is to use '<p><br></p>'
              // notStyle: 'position:absolute;top:4px;left:2px;opacity:0.9;padding:4px;', // Position of Notification
              // icon: '<i class="note-icon"> Clear External Format </i>',
              // keepHtml: false, // Remove all Html formats
              // keepClasses: false, // Remove Classes
              // badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
              // badAttributes: ['style', 'start'] // Remove attributes from remaining tags
        // }
    });
});
</script>