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
	$filename = "ijtech_reviewer_".date('Y-m-d').'.xls';
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-type: application/force-download');
	header('Content-Transfer-Encoding: binary');
	header('Pragma: public');
	print "\xEF\xBB\xBF"; // UTF-8 BOM
	# ==================================================
	?>
	<h2>Reviewer International Journal of Technology</h2>
	<table class="list">
	<thead>
	<tr>
		<th height="50">No</th>
		<th>Salutation</th>
		<th>Fullname</th>
		<th>Email</th>
		<th>Affiliation</th>
		<th>Expertise</th>
		<!-- <th>Date Invite</th> -->
	</tr>
	</thead>
	<tbody>
		<?php if(!empty($reviewer)){ $no=0; foreach($reviewer as $a){ $no++;?>
		<tr>
			<td valign="top"><?php echo $no;?></td>
			<td valign="top"><?php echo $a['salutation'] ? $a['salutation'] : '-';?></td>
			<td valign="top"><?php echo $a['fullname'];?></td>
			<td valign="top"><?php echo $a['email'];?></td>
			<td valign="top"><?php echo $a['affiliation'] ? $a['affiliation'] : '-';?></td>
			<td valign="top"><?php echo $a['expertise'] ? $a['expertise'] : '-';?></td>
			<!-- <td valign="top"><?php echo $a['date_input'];?></td>-->
		</tr>
		<?php }} ?>
	</tbody>
	</table>
	<br/>
	<div style="font-size: 10px; font-style: italic;">International Journal of Technology Online System - Generated at <?php echo date('Y-m-d H:i:s');?></div>
</body>
</html>