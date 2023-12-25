<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>[IJTech] - Invitation to Review Manuscript #<?php echo $journal_id;?></title>
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
                                        <h5 style="color: #333; font-style: italic; padding: 10px; margin-bottom: 10px; border-bottom: solid 1px #DDD; background-color: #F7F7F7; font-weight: normal;"><i class="fa fa-file-text-o"></i> Invitation to Review Manuscript #<?php echo $journal_id;?></h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">

                                        <?php 
                                            $due = date('Y-m-d');
                                            $dd = date('d M Y', strtotime(due_date(DAY_4_REVR_2_RESPOND_INVTN, $due)));
                                        ?> 

                                        <p>Dear <span class="name"><b> <?php echo $reviewer[0]['salutation'].' '.$reviewer[0]['fullname'];?> </b>,</span></p>

                                        <p>We would like to invite you to review manuscript <b>#<?php echo $journal_id;?></b> entitled <b>"<?php echo strip_tags($journal[0]['sub_title']);?>"</b> that was submitted to the International Journal of Technology (IJTech, pISSN: 2086-9614, eISSN: 2087-2100). IJTech is an open-access journal indexed by Scopus, EBSCO, DOAJ, and many internationally-recognized indexers.</p>

<?php
//  Currently, IJTech achieved SJR score of 0.43 (Q2), SJR H-index of 9, acceptance rate of 27%, and average submit-to-publish duration of 145 days.
// Currently, IJTech achieved SJR score of 0.4 (Q2), SJR H-index of 9, acceptance rate of 29.5%, and average submit-to-publish duration of 162 days.
// echo $dd; //ini apa ya.. lupa
?>
																				<p>We believe your expertise is an excellent fit for this manuscript, and we would value your input. We would appreciate it if you could take a few moments to review the attached abstract and confirm your response to this invitation by clicking one of the links below:</p>
																				<p>Accept invitation: <a href="<?php echo $accepted;?>" target="_blank"><?php echo $accepted;?></a></p>
																				
																				<p>Refuse invitation: <a href="<?php echo $refused;?>" target="_blank"><?php echo $refused;?></a></p>
																				
																				<p>Please log in to submit your review comments if you accept our invitation. As you know, timely reviews help us provide authors with a prompt decision. Hence we would appreciate it if you could send your reviews within <?php echo DAY_TO_REVIEW_MANUSCRIPT;?> days of accepting this invitation.</p>
																				<p>If your email address is not associated with an IJTech account, your username and password will be emailed to you. Otherwise, you can log in using your existing username and password or reset your password at <a href="http://ijtech.eng.ui.ac.id/reset">http://ijtech.eng.ui.ac.id/reset</a>.</p>
																				
																				<p>A short guideline for reviewers can be found here: <a href="<?php echo base_url().'file/IJTech_reviewer_guideline.pdf" target="_blank">'; echo base_url(); echo 'file/IJTech_reviewer_guideline.pdf'; ?></a>.</p>
																				
																				<br>
																				<hr>
																				<p><b><i>Article to be reviewed</i></b></p>
                                        <b>Title: </b><?php echo strip_tags($journal[0]['sub_title']);?>
                                        <br><b>Abstract: </b><?php echo strip_tags($journal[0]['abstract']);?>
																				<hr>
																				<br>
																				
                                        <p>We look forward to hearing from you.</p>

                                    </td>
                                </tr>                                
                                <tr>
                                    <td class="content-block" style="font-size: 8px">
                                        <p>Yours sincerely,</p>
                                        
<?= chief_data()->n ?><br/>
<b>Editor in Chief</b><br/>
International Journal of Technology (IJTech)</b><br/>
p-ISSN : 2086-9614<br/>
e-ISSN : 2087-2100<br/>

                                        <?php //di sini, biar ga berfungsi, setiap angka section_id saya tambahin '00'
                                        if ($journal[0]['section_id'] == 500){ ?>
                                            
                                            <div>

                                                <p>
                                                    Dr. Eny Kusrini<br/>
																										Managing Editor<br/>
                                                </p>
                                                <p>
                                                    <b>
                                                    International Journal of Technology (IJTech)</b><br/>
                                                    p-ISSN : 2086-9614<br/>
                                                    e-ISSN : 2087-2100<br/>
                                                    <a href="http://ijtech.eng.ui.ac.id/">http://ijtech.eng.ui.ac.id/</a>
                                                </p>
                                            </div>
                                        
                                        <?php } if ($journal[0]['section_id'] == 600){ ?>

                                            <div>
                                                <p>
                                                    Dr. Eny Kusrini<br/>
                                                    Dr. Sutrasno<br/>
                                                </p>
                                                <p>
                                                    <b>Editor in Charge for Chemical Engineering<br/>
                                                    International Journal of Technology (IJTech)</b><br/>
                                                    p-ISSN : 2086-9614<br/>
                                                    e-ISSN : 2087-2100<br/>
                                                    <a href="http://ijtech.eng.ui.ac.id/">http://ijtech.eng.ui.ac.id/</a>
                                                </p>
                                            </div>

                                        <?php } if ($journal[0]['section_id'] == 300){ ?>

                                            <div>
                                                <p>
                                                    Prof. Yandi Andri Yatmo<br/>
                                                    Prof. Paramita Atmodiwirjo<br/>
                                                </p>
                                                <p>
                                                    <b>Editor in Charge for Architecture<br/>
                                                    International Journal of Technology (IJTech)</b><br/>
                                                    p-ISSN : 2086-9614<br/>
                                                    e-ISSN : 2087-2100<br/>
                                                    <a href="http://ijtech.eng.ui.ac.id/">http://ijtech.eng.ui.ac.id/</a>
                                                </p>
                                            </div>

                                        <?php } if ($journal[0]['section_id'] == 100){ ?>

                                            <div>
                                                <p>
                                                    Dr. Muhamad Asvial<br/>
                                                    Dr. Muhammad Suryanegara<br/>
                                                    Dr. -Ing. Eko Adhi Setiawan<br/>
																										Dr. Ruki Harwahyu<br/>
                                                </p>
                                                <p>
                                                    <b>Editor in Charge for Electrical, Electronics, and Computer Engineering<br/>
                                                    International Journal of Technology (IJTech)</b><br/>
                                                    p-ISSN : 2086-9614<br/>
                                                    e-ISSN : 2087-2100<br/>
                                                    <a href="http://ijtech.eng.ui.ac.id/">http://ijtech.eng.ui.ac.id/</a>
                                                </p>
                                            </div>

                                        <?php } if ($journal[0]['section_id'] == 700){ ?>

                                            <div>
                                                <p>
                                                    Prof. Isti Surjandari<br/>
                                                    Prof. Yuri T. Zagloel<br/>
                                                </p>
                                                <p>
                                                    <b>Editor in Charge for Industrial Engineering<br/>
                                                    International Journal of Technology (IJTech)</b><br/>
                                                    p-ISSN : 2086-9614<br/>
                                                    e-ISSN : 2087-2100<br/>
                                                    <a href="http://ijtech.eng.ui.ac.id/">http://ijtech.eng.ui.ac.id/</a>
                                                </p>
                                            </div>

                                        <?php } if ($journal[0]['section_id'] == 800){ ?>

                                            <div>
                                                <p>
                                                    Prof. Akhmad Herman Yuwono<br/>
                                                    Dr. Nofrijon Sofyan<br/>
                                                    Dr. Sri Harjanto<br/>
                                                </p>
                                                <p>
                                                    <b>Editor in Charge for Metalurgy and Material Engineering<br/>
                                                    International Journal of Technology (IJTech)</b><br/>
                                                    p-ISSN : 2086-9614<br/>
                                                    e-ISSN : 2087-2100<br/>
                                                    <a href="http://ijtech.eng.ui.ac.id/">http://ijtech.eng.ui.ac.id/</a>
                                                </p>
                                            </div>

                                        <?php } if ($journal[0]['section_id'] == 400){ ?>
                                            <div>
                                                <p>
                                                    Prof. Nandy Putra<br/>
                                                    Dr. Muhammad Arif Budianto<br/>
                                                    Dr. Yudan Whulanza<br/>
                                                </p>
                                                <p>
                                                    <b>Editor in Charge for Mechanical Engineering<br/>
                                                    International Journal of Technology (IJTech)</b><br/>
                                                    p-ISSN : 2086-9614<br/>
                                                    e-ISSN : 2087-2100<br/>
                                                    <a href="http://ijtech.eng.ui.ac.id/">http://ijtech.eng.ui.ac.id/</a>
                                                </p>
                                            </div>
                                        <?php } ?>

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
