<?php 
if(!isset($scriptBeforeJQuery)){$scriptBeforeJQuery = '';}
if(!isset($scriptAfterJQuery)){$scriptAfterJQuery = '';}
if(!isset($scriptFooter)){$scriptFooter = '';}
$this->load->view('parts/header',['add' => $scriptBeforeJQuery, 'add2' => $scriptAfterJQuery]); ?>
   <!-- Main content -->
    <section class="content">
      <div class="row">
	      <div class="col-md-12">
		      <div class="box">
		      	<div class="box-body">
							<?php
							if(isset($beforeTable)){echo $beforeTable;}
							if(isset($replaceGC)){echo $replaceGC;}else{echo $output->output; }
							?>
		      	</div>
		      </div>
	      </div>
  		</div>
  	</section>
<?php $this->load->view('parts/footer',['add'=>$scriptFooter]); ?>
