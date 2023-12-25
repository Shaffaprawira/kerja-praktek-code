<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>[IJTech] Decision (Revise) manuscript #<?php echo $journal_id;?></title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style type="text/css">
    	*{margin: 0; padding: 0; font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; } img {max-width: 100%; } body {-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6; } table td {vertical-align: top; } body {background-color: #f6f6f6; } .body-wrap {background-color: #f6f6f6; width: 100%; } .container {display: block !important; max-width: 600px !important; margin: 0 auto !important; clear: both !important; } .content {max-width: 600px; margin: 0 auto; display: block; padding: 20px; }.main {background: #fff; border: 1px solid #e9e9e9; border-radius: 3px; } .content-wrap {padding: 20px; } .content-block {padding: 0 0 20px; } .header {width: 100%; margin-bottom: 20px; } .footer {width: 100%; clear: both; color: #999; padding: 20px; } .footer a {color: #999; } .footer p, .footer a, .footer unsubscribe, .footer td {font-size: 12px; } h1, h2, h3 {font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; color: #000; margin: 40px 0 0; line-height: 1.2; font-weight: 400; } h1 {font-size: 32px; font-weight: 500; } h2 {font-size: 24px; } h3 {font-size: 18px; } h4 {font-size: 14px; font-weight: 600; } p, ul, ol {margin-bottom: 10px; font-weight: normal; } p li, ul li, ol li {margin-left: 5px; list-style-position: inside; } a {color: #1ab394; text-decoration: underline; } .btn-primary {text-decoration: none; color: #FFF; background-color: #1ab394; border: solid #1ab394; border-width: 5px 10px; line-height: 2; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; } .last {margin-bottom: 0; } .first {margin-top: 0; } .aligncenter {text-align: center; } .alignright {text-align: right; } .alignleft {text-align: left; } .clear {clear: both; } .alert {font-size: 16px; color: #fff; font-weight: 500; padding: 20px; text-align: center; border-radius: 3px 3px 0 0; } .alert a {color: #fff; text-decoration: none; font-weight: 500; font-size: 16px; } .alert.alert-warning {background: #f8ac59; } .alert.alert-bad {background: #ed5565; } .alert.alert-good {background: #1ab394; } .invoice {margin: 40px auto; text-align: left; width: 80%; } .invoice td {padding: 5px 0; } .invoice .invoice-items {width: 100%; } .invoice .invoice-items td {border-top: #eee 1px solid; } .invoice .invoice-items .total td {border-top: 2px solid #333; border-bottom: 2px solid #333; font-weight: 700; } @media only screen and (max-width: 640px) {h1, h2, h3, h4 {font-weight: 600 !important; margin: 20px 0 5px !important; } h1 {font-size: 22px !important; } h2 {font-size: 18px !important; } h3 {font-size: 16px !important; } .container {width: 100% !important; } .content, .content-wrap {padding: 10px !important; } .invoice {width: 100% !important; } }
    </style>
</head>

<body>

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">

                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-wrap">
                            <table  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                    	<img class="img-responsive" src="http://ijtech.eng.ui.ac.id/assets/front/img/logo_lama.png"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <h5 style="color: #333; font-style: italic; padding: 10px; margin-bottom: 10px; border-bottom: solid 1px #DDD; background-color: #F7F7F7; font-weight: normal;"><i class="fa fa-file-text-o"></i> Decision Result : Revise</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <?php 
											$due = date('Y-m-d');
											$dd = date('d M Y', strtotime(due_date($revise_days, $due)));
										?> 
										
										<p>Dear <b> <?php echo $author[0]['salutation'].' '.$author[0]['first_name'].' '.$author[0]['last_name'];?> </b></p>
										
										<p>We have finished the review and made decision on your manuscript entitled <span class="name"><b>[ <?php echo strip_tags($journal[0]['sub_title']);?> ]</b></span> which was submitted to International Journal of Technology.</p>

										<p>We have decided that your manuscript <b><?php echo $status;?></b></p>
										<p>We also send you the review result from the reviewers. Here is the detail review result:</p>
										
										<p>Notes from Editor:<br/><?php echo $notes;?></p>

										<?php if(!empty($review_result)){ $no=0; foreach($review_result as $rs){ $no++; ?>
										<?php
											$point = array("originality","technical","methodology","readability","practicability","organization","importance");
											$val = array("-", "poor","fair","average","above average","excellent");
										?>
										<table class="table" width="100%">
											<tr><td colspan="2">Reviewer (<?php echo $no;?>)</td></tr>
											<tr><td><b>Introduction:</b><br/> <?php echo nl2br(strip_tags($rs['introduction_comment']));?></td></tr>
											<tr><td><b>Methodology: </b><br/><?php echo nl2br(strip_tags($rs['methodology_comment']));?></td></tr>
											<tr><td><b>Results and Discussion: </b><br/><?php echo nl2br(strip_tags($rs['result_comment']));?></td></tr>
											<tr><td><b>References: </b><br/><?php echo nl2br(strip_tags($rs['references_comment']));?></td></tr>
											<tr><td><b>Other: </b><br/><?php echo nl2br(strip_tags($rs['other_comment'])).'<br><br>'.nl2br(strip_tags($rs['additional_comment']));?></td></tr>
											<tr><td colspan="2">
												<table class="table table-bordered table-striped">
												<?php for($a=0; $a<count($point); $a++){?>
												<tr><td width="100"><?php echo ucwords($point[$a]);?></td><td><?php echo isset($rs[$point[$a]]) ? $rs[$point[$a]]."<i> (".$val[$rs[$point[$a]]].")</i>":'';?></td></tr>	
												<?php } ?>
												</table>
											</td></tr>										
											<tr><td><b>Attachment from reviewer:</b><br/>
												<?php if($rs['review_url'] != ""){?>
												<a href="<?php echo site_url().$rs['review_url'];?>">Click to download</a>
												<?php }else{ echo "-"; } ?>
											</td></tr>
										</table>
										<hr/>
										<?php }}else{ ?>
											<i class="fa fa-info-circle"></i> Waiting review from suggested reviewer.
										<?php } ?>
										<p>Please login into application <?php echo site_url().'login';?> for more detail. </p>

										<?php if($revise_days !== 0){?>
											<p>You must respond to this revise and resubmit request before <b><?php echo $dd;?></b>, after which point we will presume that you have withdrawn your submission from International Journal of Technology (IJTech) Online System.</p>
										<?php } ?>

                                    </td>
                                </tr>                                
                                <tr>
                                    <td class="content-block" style="font-size: 8px">
										<p>Yours sincerely,</p>
										<p>
											<?= chief_data()->n ?><br/>
                                            <b>Editor in Chief</b><br/>
                                            
                                            <b>International Journal of Technology (IJTech)</b><br/>
											p-ISSN : <?php echo P_ISSN;?><br/>
											e-ISSN <?php echo E_ISSN;?><br/>
											<a href="<?php echo site_url();?>" target="_blank"><?php echo site_url();?></a>
										</p>
									</td>
                                </tr>                                
                              </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
                    <table width="100%">
                        <tr>
                            <td class="aligncenter content-block">IJTech is currently indexed in SCOPUS and Emerging Sources Citation Index (ESCI) Thomson Reuters</td>
                        </tr>
                    </table>
                </div></div>                
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>
