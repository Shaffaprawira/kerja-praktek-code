<div class="content-wrapper">
    <section class="content-header">
        <h1>Dashboard <small>International Journal of Technology</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>

    <section class="content">

        <!-- DASHBOARD CONTENT ADMINISTRATOR -->
        <?php if(in_array(11, $this->session->userdata('role'))){?>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-globe"></i> Online Submission Journal</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="fa fa-newspaper-o"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/submission/secretariat/status/1/page/1';?>">New Submission</a></b></span>
                                    <span class="info-box-heading"><i>Need to be checked and send to suggested reviewer.</i></span>
                                    <span class="info-box-number"><?php echo number_format($new);?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-book"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/submission/secretariat/status/5/page/1';?>">Review Received</a></b></span>
                                    <span class="info-box-heading"><i>Review Received from reviewer(s). Send decision.</i></span>
                                    <span class="info-box-number"><?php echo number_format($received);?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-bookmark"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/submission/secretariat/status/completed/page/1';?>">Completed Manuscript</a></b></span>
                                    <span class="info-box-heading"><i>Submission received, rejected, and published</i></span>
                                    <span class="info-box-number"><?php echo number_format($completed);?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- DASHBOARD CONTENT SECRETARIAT -->
        <?php }else if (in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role'))) {?>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-globe"></i> Online Submission Journal</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="well">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-blue"><i class="fa fa-newspaper-o"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/submission/secretariat';?>">All</a></b></span>
                                        <span class="info-box-heading"><i>All Submission</i></span>
                                        <span class="info-box-number"><?php echo number_format($all);?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-newspaper-o"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/submission/secretariat/status/8';?>">Accepted</a></b></span>
                                        <span class="info-box-heading"><i>Accepted Submission</i></span>
                                        <span class="info-box-number"><?php echo number_format($accepted);?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-book"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/submission/secretariat/status/11';?>">In Press</a></b></span>
                                        <span class="info-box-heading"><i>Submission in press</i></span>
                                        <span class="info-box-number"><?php echo number_format(isset($inpress) ? $inpress : 0);?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-bookmark"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/submission/secretariat/status/9';?>">Published</a></b></span>
                                        <span class="info-box-heading"><i>Published Submission </i></span>
                                        <span class="info-box-number"><?php echo number_format($published);?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3><?php echo number_format($alluser);?></h3>
                                    <p>All Users</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <!-- articles -->
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3><?php echo number_format($section_editor);?></h3>
                                    <p>Section Editor</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-pencil"></i>
                                </div>
                            </div>
                        </div>
                        <!-- quotes -->
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3><?php echo number_format($author);?></h3>
                                    <p>Authors</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-edit"></i>
                                </div>
                            </div>
                        </div>

                        <!-- journal -->
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3><?php echo number_format($reviewer);?></h3>
                                    <p>Reviewers</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3><?php echo ($acceptance_rate). ' %';?></h3>
                                    <p>Acceptance Rate</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-check-square-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3><?php echo number_format($time_to_pub).' days';?></h3>
                                    <p>Average time to publish</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3><?php echo number_format($all_downloads);?></h3>
                                    <p>Average Downloads Per Paper</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-download"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chart submission -->
                    <!-- <div class="row">

                        <div class="col-md-12">

                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Submission</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="areaChart" style="height:400px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- last accepted and submitted manuscript -->
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-newspaper-o"></i> Last Submitted Manuscript</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>No.</th>
                                            <th>Manuscript</th>
                                        </tr>
                                        <?php if(!empty($last_submitted)){ $no=0; foreach ($last_submitted as $ls){ $no++;?>
                                            <tr>
                                                <td><?php echo $no;?></td>
                                                <td>
                                                    <a href="<?php echo site_url().'dashboard/detail/submission/'.$ls['sub_id'];?>"><?php echo $ls['sub_title'];?></a>
                                                    <div class="small"><i class="fa fa-clock-o"></i> <?php echo date('d M Y - H:i', strtotime($ls['date_submit']));?></div>
                                                    <div class="small"><i class="fa fa-user"></i> <?php echo $this->lib_view->author_submission($ls['sub_id']);?></div>
                                                </td>
                                            </tr>
                                        <?php }}else{?>
                                            <tr><td colspan="3">No submitted manuscript...</td></tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-newspaper-o"></i> Last Accepted Manuscript</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>No.</th>
                                            <th>Manuscript</th>
                                        </tr>
                                        <?php if(!empty($last_accepted)){ $no=0; foreach ($last_accepted as $ls){ $no++;?>
                                            <tr>
                                                <td><?php echo $no;?></td>
                                                <td>
                                                    <a href="<?php echo site_url().'dashboard/detail/submission/'.$ls['sub_id'];?>"><?php echo $ls['sub_title'];?></a>
                                                    <div class="small"><i class="fa fa-clock-o"></i> <?php echo date('d M Y - H:i', strtotime($ls['date_submit']));?></div>
                                                    <div class="small"><i class="fa fa-user"></i> <?php echo $this->lib_view->author_submission($ls['sub_id']);?></div>
                                                </td>
                                            </tr>
                                        <?php }}else{?>
                                            <tr><td colspan="3">No accepted manuscript...</td></tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DASHBOARD CONTENT USERS -->
        <?php }else{?>
            <div class="box">
                <!--vincent 20-jan-20
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-globe"></i> Online Submission Journal</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>-->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">

                                    <?php if(in_array(3, $this->session->userdata('role')) || in_array(4, $this->session->userdata('role'))){?>
                                        <li class="active"><a href="#authoring" data-toggle="tab">My Editorial Activities</a></li>
                                    <?php } ?>
                                    <?php if(in_array(5, $this->session->userdata('role'))){?>
									<li class="active"><a href="#authoring" data-toggle="tab">My Submissions</a></li>
                                        <?php if(in_array(6, $this->session->userdata('role'))){?>
										<li><a href="#reviewing" data-toggle="tab">My Active Reviewing Assigments</a></li>
                                        <?php } ?>
                                    <?php } ?>
								
                                </ul>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="authoring">
                                        <div class="row">
										
                                            <?php if(in_array(3, $this->session->userdata('role')) || in_array(4, $this->session->userdata('role'))){?>
                                                <div class="col-md-12">
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <div class="info-box">
                                                            <span class="info-box-icon bg-yellow"><i class="fa fa-newspaper-o"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/submission/editor/status/1';?>">New Submission</a></b></span>
                                                                <span class="info-box-heading"><i>Need to be checked and send to suggested reviewer.</i></span>
                                                                <span class="info-box-number"><?php echo number_format($new);?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <div class="info-box">
                                                            <span class="info-box-icon bg-red"><i class="fa fa-book"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/submission/editor/status/5';?>">Review Received</a></b></span>
                                                                <span class="info-box-heading"><i>Review Received from reviewer(s). Send decision.</i></span>
                                                                <span class="info-box-number"><?php echo number_format($received);?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <div class="info-box">
                                                            <span class="info-box-icon bg-green"><i class="fa fa-bookmark"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/submission/editor/status/completed';?>">Completed Manuscript</a></b></span>
                                                                <span class="info-box-heading"><i>Submission received, rejected, and published</i></span>
                                                                <span class="info-box-number"><?php echo number_format($completed);?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            <?php } ?>
                                            <?php if(in_array(5, $this->session->userdata('role'))) { ?>
                                                <!--vincent 20jan20 start-->
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title"><i class="fa fa-newspaper-o"></i> <b>Active Submission</b></h3>
                                                        <div class="box-tools pull-right">
                                                            <?php if (in_array(5, $this->session->userdata('role'))){?>
                                                                <a class="btn btn-primary btn-sm" href="<?php echo base_url().'dashboard/create/submission';?>" data-tooltip="tooltip" title="Submit new article"><i class="fa fa-plus-circle"></i>
                                                                    <span>Add new submission</span></a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <?php $no = $offset; ?>
                                                        <div class="row" style="background-color: #f4f4f4;padding-top: 10px;margin:5px; border:solid 1px #EEE">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Total : </label> <span><?php echo isset($total) ? $total : 0;?> Records</span>
                                                                    <p><?php echo 'Showing '.($no+1).' to '.($no+$perpage).' entries';?></p>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $_url = explode('/submission/author/status/active/page/', current_url());
                                                            $url = $_url[0].'/submission/author/status/active/page/1';
                                                            ?>
                                                            <div class="col-md-6">
                                                                <form method="GET" action="<?php echo $url;?>">
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="search" name="q" class="form-control" data-toggle="modal" data-target="#modalStepInfo"  data-tooltip="tooltip" title="You can search by manuscript's title, author's firstname or lastname. For searching the manuscript's number ID, please add prefix ID, Ex: id:123" placeholder="Type keyword and press enter" value="<?php echo isset($keyword) ? $keyword :'';?>">
                                                                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <table  class="table table-striped table-hover data-tables">
                                                            <thead>
                                                            <th>No.</th>
                                                            <th>Submit Date</th>
                                                            <th>Manuscript ID</th>
                                                            <th>Authors</th>
                                                            <th>Title</th>
                                                            <?php if($this->uri->segment(3) == 'issue'){?>
                                                                <th width="100">Pages</th>
                                                            <?php } ?>
                                                            <th>Status</th>
                                                            <th width="150">Action</th>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            if(!empty($submission)){
                                                                foreach($submission as $a){ $no++;
                                                                    $journal_id = ($a['round'] > 1 ? 'R'.($a['round']-1).'-':'').$a['section_abv'].'-'.$a['sub_id'];
                                                                    ?>
                                                                    <tr style="<?php echo $a['sub_status'] == 7 ? 'background: #FFFFDD':'';?>">
                                                                        <td><?php echo $no;?></td>
                                                                        <td width="150"><?php echo $a['date_submit'] == '0000-00-00 00:00:00' ? 'Draft': ($this->lib_view->first_submit_date($a['sub_id']) ? date('d M Y - H:i', strtotime($this->lib_view->first_submit_date($a['sub_id']))):'Data migration');?></td>
                                                                        <td width="150"><?php echo $journal_id;?></td>
                                                                        <td><?php echo $this->lib_view->author_submission($a['sub_id']);?></td>
                                                                        <?php if($a['sub_status'] == 9 && (in_array(2, $this->session->userdata('role')))) {?>
                                                                            <td><a href="<?php echo site_url().'dashboard/detail/journal/'.$a['sub_id'];?>"><?php echo $a['sub_title'];?></td>
                                                                        <?php }else{?>
                                                                            <td><a href="<?php echo site_url().'dashboard/detail/submission/'.$a['sub_id'];?>"><?php echo $a['sub_title'];?></td>
                                                                        <?php } ?>

                                                                        <?php if($this->uri->segment(3) == 'issue'){?>
                                                                            <td><?php echo $a['pages'];?></td>
                                                                        <?php } ?>

                                                                        <td>
                                                                            <?php
                                                                            if (in_array(5, $this->session->userdata('role'))){
                                                                                echo $this->lib_view->log_submission_status($a['sub_id'], $a['round']);
                                                                            }else{
                                                                                if($a['sub_status'] == 7){
                                                                                    echo $this->lib_view->check_revise($a['sub_id']);
                                                                                }else{
                                                                                    echo submission_status($a['sub_status'], $a['round']);
                                                                                    echo $a['sub_status'] == 10 ? ' (Rejected)':'';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td width="100">
																<span class="btn-group">
																	<?php if($a['sub_status'] != 0){?>
                                                                        <a href="<?php echo site_url().'dashboard/detail/submission/'.$a['sub_id'];?>" class="btn btn-sm btn-default" data-tooltip="tooltip" title="Detail Submission"><i class="fa fa-search-plus"></i></a>
                                                                    <?php } ?>

                                                                    <?php if(in_array(5, $this->session->userdata('role')) && ($a['sub_status'] == 0 || $a['sub_status'] == 7)){
                                                                        $screening = $this->lib_view->submission_screening($a['sub_id'], $a['round']);
                                                                        if(!empty($screening) && $screening[count($screening)-1]['author_respond'] == 0){ ?>
                                                                            <!--a href="#" class="btn btn-sm btn-info" data-tooltip="tooltip" title="Continue Revise" data-toggle="modal" data-target="#revise-agreement" onclick="return revise_agreement('<?php echo $a['sub_id'].'#'.$a['round'];?>')"><i class="fa fa-warning"></i></a-->
                                                                            <!--a href="#" class="btn btn-sm btn-info" data-tooltip="tooltip" title="Continue" data-toggle="modal" data-target="#revise-agreement" onclick="return revise_agreement('<?php echo $a['sub_id'].'#'.$a['round'];?>')"><i class="fa fa-arrow-right"></i></a-->
                                                                        <?php }else{?>
                                                                            <a href="<?php echo site_url().'dashboard/edit/submission/'.$a['sub_id'];?>" class="btn btn-sm btn-warning" data-tooltip="tooltip" title="Edit Submission"><i class="fa fa-edit"></i></a>
                                                                        <?php } ?>
                                                                    <?php } ?>

                                                                    <?php if($a['sub_status'] == 0){?>
                                                                        <a class="btn btn-sm btn-danger" href="#" data-tooltip="tooltip" title="Delete Submission" data-toggle="modal" data-target="#modalDelete" onclick="return delete_submission('<?php echo $a['sub_id'];?>')"><i class="fa fa-trash"></i></a>
                                                                    <?php } ?>

                                                                    <?php if(in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role'))) {?>

                                                                        <?php if($a['sub_status'] == 8 || $a['sub_status'] == 12){?>

                                                                            <a class="btn btn-sm btn-success" href="#" data-tooltip="tooltip" title="Publish Manuscript" data-toggle="modal" data-target="#modalPublish" onclick="return prepare_publish('<?php echo $a['sub_id'];?>')"><i class="fa fa-sign-out"></i></a>

                                                                        <?php } ?>


																		<?php if($a['sub_status'] == 11 || $a['sub_status'] == 9){?>
                                                                            <a class="btn btn-sm btn-success" href="<?php echo site_url().'dashboard/'.( (isset($a['read_ethics']) && ($a['read_ethics'] == 0) && (isset($a['not_publish']) && ($a['not_publish'] == 0)) ? 'migrate':'process')).'/'.$a['sub_id'];?>" data-tooltip="tooltip" title="Continue Process Manuscript"><i class="fa fa-sign-out"></i></a>
                                                                        <?php } ?>
                                                                    <?php } ?>
																</span>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            }else{
                                                            ?>
                                                            <tr><td colspan="7">No data available in table</td>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php echo $paging;?>
                                                    </div>
                                                </div>
                                                <!-- vincent 20jan20 END -->

                                            <?php } ?>
                                            <?php if(in_array(6, $this->session->userdata('role')) && count($this->session->userdata('role')) == 1){?>

                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <div class="info-box">
                                                        <span class="info-box-icon bg-green"><i class="fa fa-search"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/review/active';?>">Active</a></b></span>
                                                            <span class="info-box-heading"><i>Active review's manuscript </i></span>
                                                            <span class="info-box-number"><?php echo number_format($review_active);?></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <div class="info-box">
                                                        <span class="info-box-icon bg-red"><i class="fa fa-book"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text"><b><a href="<?php echo site_url().'dashboard/review/archive';?>">Archive</a></b></span>
                                                            <span class="info-box-heading"><i>Pass Review activities.</i></span>
                                                            <span class="info-box-number"><?php echo number_format($review_archive);?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <?php if(in_array(6, $this->session->userdata('role'))){?>
                                        <div class="tab-pane" id="reviewing">
                                            <table class="table table-striped data-table">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Assigned</th>
                                                    <!--th>Sec</th-->
                                                    <th>Title</th>
                                                    <th>Review Result</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(!empty($submission_review)) {
                                                    foreach ($submission_review as $sr) { ?>
                                                        <tr>
                                                            <td><?php echo $sr['section_abv'];?>-<?php echo $sr['round'] > 1 ? 'R'.($sr['round']-1).'-':'';?><?php echo $sr['sub_id'];?></td>
                                                            <td width="150">
                        <?php if(is_null($sr['date_round_start']) || $sr['date_round_start']=='0000-00-00 00:00:00'){
					        echo '<span style="color:red">Need confirmation</span><br>Invited at:<br>'.date('d M Y - H:i', strtotime($sr['date_invite']));
					    }else{
					        echo date('d M Y - H:i', strtotime($sr['date_round_start']));
					    } ?>
                                                            </td>
                                                            <!--td width="100"><?php echo $sr['round'] > 1 ? 'R'.($sr['round']-1).'-':'';?><?php echo $sr['section_abv'];?></td-->
                                                            <td><a href="<?php echo site_url().'dashboard/review/'.$sr['sub_id'].'/'.$sr['review_id'];?>" data-tooltip="tooltip" title="Start Review"><?php echo $sr['sub_title'];?></a></td>
                                                            <td><?php echo review_result($sr['review_result']);?></td>
                                                            <td><a class="btn btn-primary btn-sm" href="<?php echo site_url().'dashboard/review/'.$sr['sub_id'].'/'.$sr['review_id'];?>" data-tooltip="tooltip" title="Start Review"><i class="fa fa-search"></i></a></td>
                                                        </tr>
                                                    <?php }
                                                } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
    </section>
</div>

<div class="modal inmodal" id="modalDelete" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-trash modal-icon"></i>
				<h4 class="modal-title">Delete Submission</h4>
				<div>Remove submission from list.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/delete/submission';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<input type="hidden" name="sub_id" id="item_id">
				<div class="msg"></div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="Remove" class="btn btn-danger action">
			</div>
			</form>
		</div>	
	</div>
</div>

<div class="modal inmodal" id="revise-agreement" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-check-circle modal-icon"></i>
				<h4 class="modal-title">Revise Agreement</h4>
				<div>Agree to revise manuscript.</div>
			</div>
			<form name="revise_agreement-form" action="<?php echo base_url().'dashboard/update/revise_agreement';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="sub_id" id="sub_item_id">
				<input type="hidden" name="round" id="round">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<div class="msg">If you want to revise your manuscript, please click <b>Yes</b><br/>
				or if you want to decline your manuscript, please click <b>No</b></div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" class="btn btn-default pull-left" value="Cancel" data-dismiss="modal">
				<input type="submit" name="action" value="No" class="btn btn-danger">
				<input type="submit" name="action" value="Yes" class="btn btn-success action">
			</div>
			</form>
		</div>	
	</div>
</div>

<div class="modal inmodal" id="modalPublish" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-book modal-icon icon"></i>
				<h4 class="modal-title set-header">Publish Manuscript</h4>
				<div class="set-header-label">Rearrangement of submission manuscript to web journal format.</div>
			</div>
			<form name="formpublish" action="<?php echo base_url().'dashboard/insert/publish ';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="sub_id" id="sub_id_publish">
				<input type="hidden" name="page" value="<?php echo current_url();?>">
				<div class="msg">					
					<div class="form-group">
						<label>Manuscript Title :</label>
						<p id="manuscript_title"></p>
					</div>				
				</div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="OK" class="btn btn-success action">
			</div>
			</form>
		</div>	
	</div>
</div>

<div class="modal inmodal" id="modalStepInfo" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<h4 class="modal-title"><i class="fa fa-info-circle"></i> Steps in article processing</h4>
				<!--div>All published articles must have completed all of these steps:</div-->
			</div>
			<div class="modal-body">
        <ol>
          <li><span class="badge label-info">Screening by eic</span> : All articles are subjected to preliminary check by Editor in Charge (EiC). EiC will conduct rapid assessment and decide whether the article is eligible for further review process or decline the submission. If the article is passed to the next process, EiC will recommend a list of prospective suitable reviewers by entering the reviewers’ data (name, email, and affiliation) in the notes box. These recommended reviewers will be assigned by Secretariat at the next process (Step 3. Reviewer Assignment).</li>
          <li><span class="badge bg-blue">Screening by secret</span> : All articles are required to be checked for format compliance with the Author’s Guideline or IJTech template. Secretariat will check the citation-reference style, figure, tables, spacing, and indication of plagiarism of the article(s). Principally, all articles passed through this step are ready to proceed to the blind-review process.</li>
          <li><span class="badge bg-yellow">Review Assignment</span> : All articles will be submitted to the prospective reviewers. Secretariat will assign the reviewers based on the recommendation from Editor in Charge both from the listed reviewers in Step 1. Screening by Editor in Charge and or from the IJTech reviewers database.</li>
          <li><span class="badge bg-green">Review Process</span> : All articles are being reviewed by the invited reviewers. The review process will approximately take two weeks to two months. Reminder will be sent regularly to the reviewers who have not confirmed their acceptance to the invitation to review or have not submitted the review comments. Secretariat will assign new reviewers, if the invited reviewers reject the invitation to conduct review.</li>
          <li><span class="badge bg-yellow">Reviewe Received</span> : All authors of the reviewed articles will receive reviewer’s comments. Editor in Charge or Secretariat need to give the decision for the article based on the reviewer's comments.</li>
          <li><span class="badge bg-yellow">Revision Process</span> : All articles are undergoing revision process by the authors, either revision in response to the secretariat comments during the initial screening or in response to the reviewer’s comments.</li>
          <li><span class="badge bg-green">Accepted</span> : All articles are accepted to be published in IJTech. The accepted article will proceed to the line editing process and author(s) should confirm regarding who will conduct the line editing (Author can choose to conduct their own line editing through the recommended agents, or ask IJTech to conduct the line editing).</li>
          <li><span class="badge label-info">Line Editing</span> : All articles have been confirmed by the author and are awaiting the results of the line editing.</li>
          <li><span class="badge bg-blue">In Press</span> : All articles are ready to be published in IJTech. The secretariat will ensure that all the published articles have been approved by all authors by sending the final proof reading for authors’ approval and the copyright form to be completed and signed by the authors.</li>
          <li><span class="badge bg-red">Archive</span> : This step is a dashboard to see the published, withdrawn, and rejected articles.</li>
        </ol>
			</div>
		</div>	
	</div>
</div>