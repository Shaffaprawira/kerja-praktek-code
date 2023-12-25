<div class="container">

	<div class="row">
		<div class="col-md-8">			
			<h2 class="heading">Reviewer Contributing to this issue</h2>
			<hr/>
			<div class="box-body">
				
				<?php if(!empty($issue_reviewer)){
						echo '<ol>';
$hiddenUserIds = array('4dm1n','riri.arisyia0992','reviewer.ijtech57','riri.arisyia2','secretariatijtech');
						foreach($issue_reviewer as $ir){
if(in_array($ir['user_id'],$hiddenUserIds)){continue;}
							echo '<li>'.$ir['salutation'].' '.$ir['first_name'].' '.$ir['last_name'];
							if (!empty($ir['affiliation']))
								echo ', '.$ir['affiliation'];
							echo "</li>";
						}
						echo '</ol>';
					}?>
				
			</div>
		</div>
		<?php $this->load->view('template/inc/sidebar');?>
	</div>

</div>
