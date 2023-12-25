<html xmlns:x="urn:schemas-microsoft-com:office:excel">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--[if gte mso 9]>
    <xml>
    <x:ExcelWorkbook>
    <x:ExcelWorksheets>
    <x:ExcelWorksheet>
    Name of the sheet
    <x:WorksheetOptions>
    <x:Panes>
    </x:Panes>
    </x:WorksheetOptions>
    </x:ExcelWorksheet>
    </x:ExcelWorksheets>
    </x:ExcelWorkbook>
    </xml>
    <![endif]-->
	<style>
		.list{
			font-size:14px;
		}
		.title{
			font-size:1.5em;
			color:#0055AA;
		}
		.list th{
			font-size:1.1em;
			background:#EEE;
			color:#222;
		}
	</style>
  </head>
<body>
<?php
	$filename = "ijtech_manuscript_".date('Y-m-d').'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-type: application/force-download');
	header('Content-Transfer-Encoding: binary');
	header('Pragma: public');
	print "\xEF\xBB\xBF"; // UTF-8 BOM
	# ==================================================
	?>
	<h2>Manuscript International Journal of Technology</h2>
	<table class="list">
	<thead>
	<tr>
		<th height="50">No</th>
		<th>Manuscript ID</th>
		<th>Journal Section</th>
		<th>Title</th>
		<th width="100">Year</th>
		<th>Author(s)</th>
		<th>Suggested Reviewer(s)</th>
		<th>Status</th>
		<th>Date Submit</th>
	</tr>
	</thead>
	<tbody>
		<?php if(!empty($submission)){ $no=0; foreach($submission as $a){ $no++;?>
		<tr bgcolor="<?php echo $a['sub_status'] == 9 ? '#d9ffef':'';?>">
			<td valign="top"><?php echo $no;?></td>
			<td valign="top"><?php echo $a['round'] > 1 ? 'R'.($a['round']-1).'-':'';?><?php echo $a['section_abv'].'-'.$a['sub_id'];?></td>
			<td valign="top"><?php echo $a['section_title'];?></td>
			<td valign="top"><?php echo $a['sub_title'];?></td>
			<td valign="top" align="center"><?php echo date('Y', strtotime($a['date_submit']));?></td>
			<td valign="top"><?php echo $this->lib_view->author_submission($a['sub_id'], 1);?></td>
			<td valign="top"><?php echo $this->lib_view->reviewer_submission($a['sub_id'], 1);?></td>
			<td valign="top"><?php echo submission_status($a['sub_status']);?></td>
			<td valign="top"><?php echo $this->lib_view->first_submit_date($a['sub_id']) ? $this->lib_view->first_submit_date($a['sub_id']) :'Data migration';?></td>
		</tr>
		<?php }} ?>
	</tbody>
	</table>
	<br/>
	<div style="font-size: 10px; font-style: italic;">International Journal of Technology Online System - Generated at <?php echo date('Y-m-d H:i:s');?></div>
</body>
</html>