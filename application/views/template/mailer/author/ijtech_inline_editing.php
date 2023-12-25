 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>[IJTech] - Inline Editing Process on Manuscript #<?php echo $journal_id;?></title>
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
                                        <h5 style="color: #333; font-style: italic; padding: 10px; margin-bottom: 10px; border-bottom: solid 1px #DDD; background-color: #F7F7F7; font-weight: normal;"><i class="fa fa-file-text-o"></i> Inline Editing Process</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        
                                        <p style="padding:10px; border:dashed 1px #DDD; background-color: #F7F7F7">
                                            Ms ID <b>#<?php echo $journal_id;?></b><br/>
                                            Title : <?php echo strip_tags($journal[0]['sub_title']);?><br/>
                                            Author(s) : <?php echo $this->lib_view->author_submission($journal[0]['sub_id']);?>
                                        </p>

										<p>Dear <b><?php echo $author[0]['salutation'].' '.$author[0]['first_name'].' '.$author[0]['last_name'];?></b></p>

                                        <p>We received your confirmation regarding the Line-editing process, that you choose to let IJTech conduct the process. </p>
                                        <p>The line editing process fee is <span style="color:#FF5555; font-weight: bold">IDR 2.000.000,-</span> per article. You can make a payment via bank transfer (please noted that transfer fees may be additionally charged and become the responsibility of the sender) addressed to :</p>
                                        <p style="padding:10px; border:solid 1px #7ba6c5; border-left:solid 5px #7ba6c5; background-color: #c5dcec; font-weight: 500">
                                            Bank : Bukopin<br/>
                                            Branch : BUKOPIN kas FT UI Depok, Indonesia<br/>
                                            Swift Code : BBUKIDJA<br/>
                                            Acc. Number: <b>422 105 1810</b> <br/>
                                            Acc. Name: NyomanSuwartha,ST.MT.
                                        </p>
                                        <p>We appreciate if you can confirm your payment (along with the receipt of transfer) no later than 3 days after this email submitted. </p>
                                        <p>We will send you the receipt of payment, along with the line editing results. Any confirmation can be submitted by email to <a href="mailto:ijtech@eng.ui.ac.id">ijtech@eng.ui.ac.id</a>. We look forward to receiving your confirmation at your earliest convenience. </p>

                                    </td>
                                </tr>                                
                                <tr>
                                    <td class="content-block" style="font-size: 8px">
                                        <p>Yours sincerely,</p>
                                        <p>
                                            <?= chief_data()->n ?><br/>
                                            <b>Editor in Chief</b><br/>

                                            International Journal of Technology (IJTech)<br/>
                                            p-ISSN: <?php echo P_ISSN;?><br/>
                                            e-ISSN: <?php echo E_ISSN;?><br/>
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
