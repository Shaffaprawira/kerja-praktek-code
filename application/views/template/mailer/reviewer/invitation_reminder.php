<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>[IJTech] - Review invitation reminder on manuscript #<?php echo $journal_id;?></title>
    <style type="text/css">
    	*{margin: 0; padding: 0; font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; } img {max-width: 100%; } body {-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6; } table td {vertical-align: top; } body {background-color: #f6f6f6; } .body-wrap {background-color: #f6f6f6; width: 100%; } .container {display: block !important; max-width: 600px !important; margin: 0 auto !important; clear: both !important; } .content {max-width: 600px; margin: 0 auto; display: block; padding: 20px; }.main {background: #fff; border: 1px solid #e9e9e9; border-radius: 3px; } .content-wrap {padding: 20px; } .content-block {padding: 0 0 20px; } .header {width: 100%; margin-bottom: 20px; } .footer {width: 100%; clear: both; color: #999; padding: 20px; } .footer a {color: #999; } .footer p, .footer a, .footer unsubscribe, .footer td {font-size: 12px; } h1, h2, h3 {font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; color: #000; margin: 40px 0 0; line-height: 1.2; font-weight: 400; } h1 {font-size: 32px; font-weight: 500; } h2 {font-size: 24px; } h3 {font-size: 18px; } h4 {font-size: 14px; font-weight: 600; } p, ul, ol {margin-bottom: 10px; font-weight: normal; } p li, ul li, ol li {margin-left: 5px; list-style-position: inside; } a {color: #1ab394; text-decoration: underline; } .btn-primary {text-decoration: none; color: #FFF; background-color: #1ab394; border: solid #1ab394; border-width: 5px 10px; line-height: 2; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; } .last {margin-bottom: 0; } .first {margin-top: 0; } .aligncenter {text-align: center; } .alignright {text-align: right; } .alignleft {text-align: left; } .clear {clear: both; } .alert {font-size: 16px; color: #fff; font-weight: 500; padding: 20px; text-align: center; border-radius: 3px 3px 0 0; } .alert a {color: #fff; text-decoration: none; font-weight: 500; font-size: 16px; } .alert.alert-warning {background: #f8ac59; } .alert.alert-bad {background: #ed5565; } .alert.alert-good {background: #1ab394; } .invoice {margin: 40px auto; text-align: left; width: 80%; } .invoice td {padding: 5px 0; } .invoice .invoice-items {width: 100%; } .invoice .invoice-items td {border-top: #eee 1px solid; } .invoice .invoice-items .total td {border-top: 2px solid #333; border-bottom: 2px solid #333; font-weight: 700; } @media only screen and (max-width: 640px) {h1, h2, h3, h4 {font-weight: 600 !important; margin: 20px 0 5px !important; } h1 {font-size: 22px !important; } h2 {font-size: 18px !important; } h3 {font-size: 16px !important; } .container {width: 100% !important; } .content, .content-wrap {padding: 10px !important; } .invoice {width: 100% !important; } } .btn-block{ display: block; width:100%; }.btn-danger{text-decoration: none; color: #FFF; background-color: #d9534f; border: solid #d43f3a; border-width: 5px 10px; line-height: 2; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize;}
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
                                        <h5 style="color: #333; font-style: italic; padding: 10px; margin-bottom: 10px; border-bottom: solid 1px #DDD; background-color: #F7F7F7; font-weight: normal;"><i class="fa fa-file-text-o"></i> Review invitation reminder on manuscript #<?php echo $journal_id;?></h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        
                                        <p>Dear <b> <?php echo $reviewer[0]['salutation'].' '.$reviewer[0]['fullname'];?> </b>,</p>

										<p>In our previous email, we invited you to review a manuscript <b>#<?php echo $journal_id;?></b> entitled <b>[ <?php echo $journal[0]['sub_title'];?> ]</b> for International Journal of Technology (IJTech). This is a reminder about the invitation, as we haven't received a response from you yet. We would appreciate it if you would take a few moments to review the abstract below and confirm your intent to provide your review comments by <b>[ <?php echo $time; ?> - three days after re-invitation ]</b>. </p>

										<p>If you accept this invitation, please click the following link:  
                                        <a class="btn btn-primary btn-block" href="<?php echo $accepted;?>" target="_blank">Accept</a>. 
                                        Then log into the editorial online system at <a href="<?php echo site_url();?>" target="_blank">[ <?php echo site_url();?> ]</a> using your IJTech credential to download the manuscript and complete the review process. A short guideline for conducting a review in our online system is provided here: <a href="<?php echo base_url().'file/IJTech_reviewer_guideline.pdf" target="_blank">'; echo base_url(); echo 'file/IJTech_reviewer_guideline.pdf'; ?></a>.</p>

										<p>Should you choose to decline this invitation, please click this button
                                        <a class="btn btn-danger btn-block" href="<?php echo $refused;?>" target="_blank">Refuse</a>.</p>

										<p>If the above links do not work, please go to [ <a href="<?php echo site_url().'login';?>" target="_blank"><?php echo site_url().'login';?></a> ] and log into the editorial management system.</p>										

                                    </td>
                                </tr>                                
                                <tr>
                                    <td class="content-block" style="font-size: 8px">
										<p>Yours sincerely,</p>
										<p>
											<?php //if(!empty($editorss)){?>
											<?php //echo $editor[0]['salutation'].' '.$editor[0]['first_name'].' '.$editor[0]['last_name'];?>
											<?php //}else{?>
											Secretariat<br/>
											<a href="mailto:ijtech@eng.ui.ac.id">ijtech@eng.ui.ac.id</a><br/>
											<?php // } ?>
											<b>International Journal of Technology (IJTech)</b><br/>
											p-ISSN : <?php echo P_ISSN;?><br/>
											e-ISSN : <?php echo E_ISSN;?><br/>
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
