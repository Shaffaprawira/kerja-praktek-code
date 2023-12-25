
<script src="<?php echo base_url().'assets/plugins/summernote/summernote.js';?>"></script>

<script>
$(function(){
    $('.summernote').summernote({
        'height': '400px',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']],
          ],
    });
});
</script>