<!DOCTYPE html>
<html>
<?php 
require('head.php'); 
$at = $this->uri->segment(1);
$at2 = $this->uri->segment(2);
$at3 = $this->uri->segment(3);

if(isset($this->session->hideSide) & $this->session->hideSide==true){ $hideSide=true; }

?>

<body class="hold-transition skin-black <?=(!isset($simple) ? 'sidebar-mini' : '')?> <?=isset($hideSide)?'sidebar-collapse':''?> <?=(isset($add_body_class) ? $add_body_class : '');?>">
<?php if(!isset($simple)) { ?>
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?=base_url();?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?=base_url('assets/img/ico100.png');?>" height="25"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?=base_url('assets/img/ico100.png');?>" height="25">Office</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!--img src="<?=base_url('assets/dist/img/user2-160x160.jpg');?>" class="user-image" alt="User Image"-->
							<i class="fa fa-user"></i>
              <span class="hidden-xs"><?=$this->session->name;?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <!--img src="<?=base_url('assets/dist/img/user2-160x160.jpg');?>" class="img-circle" alt="User Image"-->
								<i class="fa fa-user" style="color: #fff;font-size: 55pt;"></i>
                <p>
                  <?=$this->session->name;?>
									<br><?=$this->session->role;?>
                  <small><?=$this->session->email;?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
							 <?php if(isset($this->session->id)){ ?>
                <div class="pull-left">
                  <a href="<?=base_url('users/profile');?>" class="btn btn-default btn-flat">Profile<?php if($this->session->role_SSO==''){echo ' & Password';}?></a>
                </div>
								<div class="pull-right">
									<?php if(isset($this->session->user_id_old) && is_numeric($this->session->user_id_old)){ ?>
										<a href="<?=base_url('users/logoutas');?>" class="btn btn-default btn-flat">Back to myself</a>
									<?php }else{ ?>
										<a href="<?=base_url('logout');?>" class="btn btn-default btn-flat">Sign out</a>
									<?php } ?>
                </div>
							 <?php }else{ ?>
								<a href="<?=base_url();?>" class="btn btn-default btn-flat">Keluar</a> 
							 <?php } ?>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!--div class="user-panel">
        <div class="pull-left image">
          <img src="<?=base_url('assets/dist/img/user2-160x160.jpg');?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?=$this->session->name;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div-->
      <!-- search form -->
      <!--form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <!--li class="header">MAIN NAVIGATION</li-->
				
<?php if($this->session->role=='admin'){ ?>
					<li class="<?= $at == 'dashboard' && $at2==''? 'active':''; ?>" ><a href="<?=base_url('dashboard');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
					<li class="<?= $at == 'kokin'? 'active':''; ?>" ><a href="<?=base_url('kokin');?>"><i class="fa fa-dashboard"></i> <span>Pantau KoKin</span></a></li>
					<li class="<?= $at == 'dashboard' && $at2=='info'? 'active':''; ?>" ><a href="<?=base_url('dashboard/info');?>"><i class="fa fa-dashboard"></i> <span>Manage Dashboard Content</span></a></li>
					<li class="<?= $at == 'rooms' ? 'active':''; ?>"><a href="<?=base_url('rooms');?>"><i class="fa fa-building"></i> <span>Rooms</span></a></li>
					<li class="treeview <?= $at == 'calendar' ? 'active':''; ?>" >
						<a href="#"><i class="fa fa-calendar"></i> <span>Room Calendar</span>   <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= ($at2==''&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar');?>"><i class="fa fa-calendar"></i> <span>All Rooms</span></a></li>
							<li class="<?= ($at3=='1'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/1');?>"><i class="fa fa-calendar"></i> <span>Ruang Rapat Lt.1</span></a></li>
							<li class="<?= ($at3=='2'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/2');?>"><i class="fa fa-calendar"></i> <span>Ruang Shizuoka</span></a></li>
							<li class="<?= ($at3=='3'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/3');?>"><i class="fa fa-calendar"></i> <span>Ruang Rapat Lt.1 MRPQ</span></a></li>
							<li class="<?= ($at3=='4'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/4');?>"><i class="fa fa-calendar"></i> <span>Ruang Multimedia</span></a></li>
							<li class="<?= ($at3=='5'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/5');?>"><i class="fa fa-calendar"></i> <span>Lab. Cisco</span></a></li>
							<li class="<?= ($at3=='6'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/6');?>"><i class="fa fa-calendar"></i> <span>Auditorium MRPQ</span></a></li>
							<li class="<?= ($at3=='7'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/7');?>"><i class="fa fa-calendar"></i> <span>Online</span></a></li>
						</ul>
					</li>
					<li class="treeview <?= ($at == 'meetings' || $at == 'rapat') ? 'active':''; ?>">
						<a href="#"><i class="fa fa-users"></i> <span>Meetings</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= ($at2==''&&$at=='meetings') ? 'active':''; ?>"><a href="<?=base_url('meetings');?>"><i class="fa fa-users"></i> <span>
							<?php 
								if($this->session->role=='admin'){ echo 'Meetings &amp; Room Bookings';}
								elseif($this->session->role=='dosen'){echo 'Meetings';}
								else{echo 'Room Bookings';}
							?>
							</span></a></li>
							<?php // if($this->session->role=='admin'){ ?>
							<!--li><a href="<?=base_url('meetings/list_undangan');?>"><i class="fa fa-envelope"></i> <span>Invitations</span></a></li-->
							<li class="<?= ($at2=='list_mom'&&$at=='meetings') ? 'active':''; ?>"><a href="<?=base_url('meetings/list_mom');?>"><i class="fa fa-file"></i> <span>Minutes of Meetings</span></a></li>
							<li class="<?= $at=='rapat' ? 'active':$at; ?>"><a href="<?=base_url('rapat');?>"><i class="fa fa-file"></i> <span>Presensi</span></a></li>
							<li class="<?= ($at2=='cert'&&$at=='meetings') ? 'active':$at; ?>"><a href="<?=base_url('meetings/cert/l');?>"><i class="fa fa-certificate"></i> <span>Sertifikat Kehadiran</span></a></li>
							<?php // } ?>
						</ul>
					</li>
					<li class="treeview <?= ($at=='keterangan') ? 'active':''; ?>">
						<a href="#"><i class="fa fa-inbox"></i> <span>Surat Keterangan</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= ($at2=='jenis'&&$at=='keterangan') ? 'active':''; ?>"><a href="<?=base_url('keterangan/jenis');?>"><i class="fa fa-list"></i> <span>Template</span></a></li>
							<li class="<?= ($at2==''&&$at=='keterangan') ? 'active':''; ?>"><a href="<?=base_url('keterangan');?>"><i class="fa fa-inbox"></i> <span>Pengajuan</span></a></li>
						</ul>
					</li>
					<li class="treeview <?= $at == 'ta' ? 'active':''; ?>">
						<a href="#"><i class="fa fa-graduation-cap"></i> <span>Paper &amp; Transfer SKS</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= $at2 == 'manuskrip' ? 'active':''; ?>"><a href="<?=base_url('ta/manuskrip');?>"><i class="fa fa-inbox"></i> <span>Paper untuk Dinilai</span></a></li>
							<li class="<?= $at2 == 'paper'     ? 'active':''; ?>"><a href="<?=base_url('ta/paper');?>"><i class="fa fa-sticky-note"></i> <span>Nilai Paper</span></a></li>
							<li class="<?= ($at2=='transfer'&&$at=='ta') ? 'active':''; ?>"><a href="<?=base_url('ta/transfer');?>"><i class="fa fa-exchange-alt"></i> <span>Transfer SKS</span></a></li>
						</ul>
					</li>
					<li class="treeview <?= $at=='pinjam' ? 'active':''; ?>">
						<a href="#"><i class="fa fa-table"></i> <span>Inventaris</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= ($at2=='barang'&&$at=='pinjam') ? 'active':''; ?>"><a href="<?=base_url('pinjam/barang');?>"><i class="fa fa-wrench"></i> <span>Daftar Inventaris</span></a></li>
							<li class="<?= ($at2==''&&$at=='pinjam') ? 'active':''; ?>"><a href="<?=base_url('pinjam');?>"><i class="fa fa-copy"></i> <span>Peminjaman</span></a></li>
						</ul>
					</li>
					
					<li class="treeview  <?= $at=='users' ? 'active':''; ?>">
						<a href="#"><i class="fa fa-group"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= ($at=='users'&&$at2=='jabatan') ? 'active':''; ?>"><a href="<?=base_url('users/jabatan');?>"><i class="fa fa-user"></i> <span>Jabatan</span></a></li>
							<li class="<?= ($at=='users'&&$at2=='dosen') ? 'active':''; ?>"><a href="<?=base_url('users/dosen');?>"><i class="fa fa-graduation-cap"></i> <span>Dosen</span></a></li>
							<li class="<?= ($at=='users'&& $at2=='reviewer') ? 'active':''; ?>"><a href="<?=base_url('users/reviewer');?>"><i class="fa fa-search-plus"></i> <span>Reviewer</span></a></li>
							<li class="<?= ($at=='users'&&$at2=='') ? 'active':''; ?>"><a href="<?=base_url('users');?>"><i class="fa fa-group"></i> <span>Semua</span></a></li>
							<li class="<?= ($at=='users'&&$at2=='busy') ? 'active':''; ?>"><a href="<?=base_url('users/busy');?>"><i class="fa fa-hourglass"></i> <span>Jadwal Sibuk Dosen</span></a></li>
							<!--li class="<?= ($at=='users'&&$at2=='pegawai') ? 'active':''; ?>"><a href="<?=base_url('users/pegawai');?>"><i class="fa fa-user"></i> <span>Staff</span></a></li-->
						</ul>
					</li>
					
					<li class="treeview  <?= ($at=='sidang'||$at=='semta') ? 'active':''; ?>">
						<a href="#"><i class="fa fa-legal"></i> <span>TA &amp; Sidang</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= $at=='semta'&&$at2=='' ? 'active':''; ?>"><a href="<?=base_url('semta');?>"><i class="fa fa-list"></i> <span>Pengajuan</span></a></li>
							<li class="<?= $at=='semta'&&$at2=='ditetapkan' ? 'active':''; ?>"><a href="<?=base_url('semta/ditetapkan');?>"><i class="fa fa-list"></i> <span>Ditetapkan</span></a></li>
							<li class="<?= ($at=='sidang'&& ($at2=='' || $at2=='index')) ? 'active':''; ?>"><a href="<?=base_url('sidang');?>"><i class="fa fa-list"></i> <span>Daftar Sidang</span></a></li>
							<li class="<?= ($at=='sidang'&& $at2=='fetchFromJson') ? 'active':''; ?>"><a href="<?=base_url('sidang/fetchFromJson');?>"><i class="fa fa-code"></i> <span>Import Daftar Sidang</span></a></li>
						</ul>
					</li>
					
					
					<!--li class="<?= $at == 'kp' ? 'active':''; ?>"><a href="<?=base_url('kp');?>"><i class="fa fa-gears"></i> <span>Jadwal Sidang KP</span></a></li-->
					<li class="treeview  <?= $at=='kp' ? 'active':''; ?>">
						<a href="#"><i class="fa fa-legal"></i> <span>KP, PPT-1, Magang (S1)</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= $at=='kp'&& ($at2==''||$at2=='index') ? 'active':''; ?>"><a href="<?=base_url('kp');?>"><i class="fa fa-list"></i> <span>Jadwal Sidang</span></a></li>
							<li class="<?= $at=='kp'&& $at2=='ppt1'              ? 'active':''; ?>"><a href="<?=base_url('kp/ppt1');?>"><i class="fa fa-list"></i> <span>PPT-1</span></a></li>
							<li class="<?= $at=='kp'&& $at2=='info'              ? 'active':''; ?>"><a href="<?=base_url('kp/info');?>"><i class="fa fa-list"></i> <span>Lowongan KP</span></a></li>
						</ul>
					</li>
					
					
					<li class="treeview  <?= $at=='pangkat' ? 'active':''; ?>">
						<a href="#"><i class="fa fa-trophy"></i> <span>Kenaikan Pangkat</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= ($at=='pangkat'&& $at2=='sync') ? 'active':''; ?>"><a href="<?=base_url('pangkat/sync');?>"><i class="fa fa-upload"></i> <span>Upload HTML SIPEG</span></a></li>
							<li class="<?= ($at=='pangkat'&& $at2=='sipeg') ? 'active':''; ?>"><a href="<?=base_url('pangkat/sipeg');?>"><i class="fa fa-list"></i> <span>Semua Data SIPEG</span></a></li>
							<li class="<?= ($at=='pangkat'&& $at2=='assignReview') ? 'active':''; ?>"><a href="<?=base_url('pangkat/assignReview');?>"><i class="fa fa-list"></i> <span>SK Reviewer</span></a></li>
						</ul>
					</li>
					<li class="<?= $at == 'filesharing' ? 'active':''; ?>"><a href="<?=base_url('filesharing');?>"><i class="fa fa-upload"></i> <span>File Hosting</span></a></li>
					<li class="<?= $at == 'scholarship' ? 'active':''; ?>"><a href="<?=base_url('scholarship');?>"><i class="fa fa-dollar"></i> <span>Info Beasiswa</span></a></li>
					<li class="<?= $at == 'tamu' ? 'active':''; ?>"><a href="<?=base_url('tamu');?>"><i class="fa fa-arrow-right"></i> <span>Buku Tamu</span></a></li>
					
<?php }elseif($this->session->role=='dosen'){ ?>
					<li class="<?= $at == 'dashboard' ? 'active':''; ?>" ><a href="<?=base_url('dashboard');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
					<?php 
						$idKadep = $this->db->query("select user from user_jabatan where jabatan = 'Ketua Departemen Teknik Elektro' and hingga is null limit 1")->row()->user;
						$idSekdep = $this->db->query("select user from user_jabatan where jabatan = 'sekretaris Departemen' and hingga is null limit 1")->row()->user;
						if($this->session->id==$idKadep || $this->session->id==$idSekdep){
					?>
					<li class="<?= $at == 'kokin'? 'active':''; ?>" ><a href="<?=base_url('kokin');?>"><i class="fa fa-dashboard"></i> <span>Pantau KoKin</span></a></li>
					<?php } ?>
					
					<li class="treeview <?= $at == 'calendar' ? 'active':''; ?>" >
						<a href="#"><i class="fa fa-calendar"></i> <span>Room Calendar</span>   <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= ($at2==''&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar');?>"><i class="fa fa-calendar"></i> <span>All Rooms</span></a></li>
							<li class="<?= ($at3=='1'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/1');?>"><i class="fa fa-calendar"></i> <span>Ruang Rapat Lt.1</span></a></li>
							<li class="<?= ($at3=='2'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/2');?>"><i class="fa fa-calendar"></i> <span>Ruang Shizuoka</span></a></li>
							<li class="<?= ($at3=='3'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/3');?>"><i class="fa fa-calendar"></i> <span>Ruang Rapat Lt.1 MRPQ</span></a></li>
							<li class="<?= ($at3=='4'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/4');?>"><i class="fa fa-calendar"></i> <span>Ruang Multimedia</span></a></li>
							<li class="<?= ($at3=='5'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/5');?>"><i class="fa fa-calendar"></i> <span>Lab. Cisco</span></a></li>
							<li class="<?= ($at3=='6'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/6');?>"><i class="fa fa-calendar"></i> <span>Auditorium MRPQ</span></a></li>
							<li class="<?= ($at3=='7'&&$at=='calendar') ? 'active':''; ?>"><a href="<?=base_url('calendar/index/7');?>"><i class="fa fa-calendar"></i> <span>Online</span></a></li>
						</ul>
					</li>
					<li class="treeview <?= $at == 'meetings' ? 'active':''; ?>">
						<a href="#"><i class="fa fa-users"></i> <span>Your Meetings</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= ($at2==''&&$at=='meetings') ? 'active':''; ?>"><a href="<?=base_url('meetings');?>"><i class="fa fa-users"></i> <span>
							<?php 
								if($this->session->role=='admin'){ echo 'Meetings &amp; Room Bookings';}
								elseif($this->session->role=='dosen'){echo 'Meeting Lists';}
								else{echo 'Room Bookings';}
							?>
							</span></a></li>
							<?php // if($this->session->role=='admin'){ ?>
							<!--li><a href="<?=base_url('meetings/list_undangan');?>"><i class="fa fa-envelope"></i> <span>Invitations</span></a></li-->
							<li class="<?= ($at2=='list_mom'&&$at=='meetings') ? 'active':''; ?>"><a href="<?=base_url('meetings/list_mom');?>"><i class="fa fa-file"></i> <span>Minutes of Meetings</span></a></li>
							<?php // } ?>
						</ul>
					</li>
					<li class="<?= $at == 'keterangan' ? 'active':''; ?>"><a href="<?=base_url('keterangan');?>"><i class="fa fa-inbox"></i> <span>Surat Keterangan</span></a></li>
					
					<li class="treeview<?= $at == 'semta' ? ' active':''; ?>">
						<a href="#"><i class="fa fa-file"></i> <span>Bimbingan TA</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= ($at2==''&&$at=='semta') ? 'active':''; ?>">          <a href="<?=base_url('semta');?>"><i class="fa fa-file">            </i> <span>Yang diajukan mhs.</span></a></li>
							<li class="<?= ($at2=='ditetapkan'&&$at=='semta') ? 'active':''; ?>"><a href="<?=base_url('semta/ditetapkan');?>"><i class="fa fa-check"></i> <span>Yang ditetapkan dept.</span> <!--label class="label label-xs pull-right bg-green">New</label--></a></li>
							<li class="<?= ($at2=='juduls'&&$at=='semta') ? 'active':''; ?>">    <a href="<?=base_url('semta/juduls');?>"><i class="fa fa-blah"></i> <span>History semua judul</span></a></li>
						</ul>
					</li>
					
					<li class="<?= $at == 'users' && $at2 == 'busy' ? 'active':''; ?>"><a href="<?=base_url('users/busy');?>"><i class="fa fa-hourglass"></i> <span>Jadwal tak bisa sidang</span></a></li>
					<li class="<?= $at == 'sidang' ? 'active':''; ?>"><a href="<?=base_url('sidang');?>"><i class="fa fa-legal"></i> <span>Sidang TA</span></a></li>
					<li class="<?= $at == 'kp' ? 'active':''; ?>"><a href="<?=base_url('kp');?>"><i class="fa fa-gears"></i> <span>Sidang KP</span></a></li>
					
					<li class="<?= $at2 == 'paper'     ? 'active':''; ?>"><a href="<?=base_url('ta/paper');?>"><i class="fa fa-sticky-note"></i> <span>Penilaian Paper S2/S3</span></a></li>
					<li class="<?= $at=='pangkat' && $at2=='paperList' ? 'active':''; ?>"><a href="<?=base_url('pangkat/paperList');?>"><i class="fa fa-search-plus"></i> <span>Review Paper <i>Peer</i></span></a></li>
<?php }elseif($this->session->role=='mahasiswa'){ ?>
					<!-- <?php echo $this->session->prodi; ?> li class="<?= $at == 'meetings' ? 'active':''; ?>" ><a href="<?=base_url('meetings');?>"><i class="fa fa-calendar"></i> <span>Bookings data</span></a></li-->
					<li class="<?= $at == 'dashboard' || $at=='' ? 'active':''; ?>"><a href="<?=base_url('dashboard');?>"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
					<li class="<?= $at == 'scholarship' ? 'active':''; ?>"><a href="<?=base_url('scholarship');?>"><i class="fa fa-dollar"></i> <span>Info Beasiswa</span><small class="label pull-right label-success">NEW</small></a></li>
					<li class="<?= $at == 'keterangan' ? 'active':''; ?>"><a href="<?=base_url('keterangan');?>"><i class="fa fa-inbox"></i> <span>Surat Keterangan</span></a></li>
			<?php if(in_array($this->session->prodi,[1,2,3,4,5,10])){ //semua prodi S1 ?>
					<li class="treeview<?= $at == 'kp' ? ' active':''; ?>">
						<a href="#"><i class="fa fa-file"></i> <span>KP, PPT-1, Magang (S1)</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="<?= $at=='kp'&& $at2=='info'              ? 'active':''; ?>"><a href="<?=base_url('kp/info');?>"><i class="fa fa-list"></i> <span>Info Lowongan</span></a></li>
							<li class="<?= $at=='kp'&& ($at2==''||$at2=='index') ? 'active':''; ?>"><a href="<?=base_url('kp');?>"><i class="fa fa-list"></i> <span>Pendaftaran Sidang</span></a></li>
						</ul>
					</li>
					<!--li class="<?= $at == 'kp' ? 'active':''; ?>"><a href="<?=base_url('kp');?>"><i class="fa fa-file"></i> <span>KP &amp; PPT-1 (S1)</span></a></li-->
					<li class="<?= $at == 'ppt2' ? 'active':''; ?>"><a href="<?=base_url('ppt2');?>"><i class="fa fa-trophy"></i> <span>PPT-2 (S1)</span></a></li>
					<li class="<?= $at=='semta'&&$at2=='tf' ? 'active':''; ?>"><a href="<?=base_url('semta/tf');?>"><i class="fa fa-file"></i> <span>Transfer SKS Skripsi</span></a></li>
			<?php } ?>
			<?php if(in_array($this->session->prodi,[6,7,8,9])){ //semua prodi S2 & S3 ?>
					<li class="<?= $at2 == 'manuskrip' ? 'active':''; ?>"><a href="<?=base_url('ta/manuskrip');?>"><i class="fa fa-inbox"></i> <span>Penilaian Paper (S2/S3)</span></a></li>
			<?php } ?>
					<li class="<?= $at=='semta'&&$at2!='tf'&&$at2!='juduls' ? 'active':''; ?>"><a href="<?=base_url('semta');?>"><i class="fa fa-file"></i> <span>Pendaftaran Tugas Akhir</span></a></li>
					<li class="<?= $at=='semta'&&$at2=='juduls' ? 'active':''; ?>"><a href="<?=base_url('semta/juduls');?>"> &nbsp; &nbsp; <i class="fa fa-lightbulb-o"></i> <span>Cari ide judul?</span></a></li>
					<li class="<?= $at=='uji'&&$at2!='berkas' ? 'active':''; ?>"><a href="<?=base_url('uji');?>"><i class="fa fa-legal"></i> <span>Sidang Anda</span></a></li>
					<li class="<?= $at=='uji'&&$at2=='berkas' ? 'active':''; ?>"><a href="<?=base_url('uji/berkas');?>"><i class="fa fa-graduation-cap"></i> <span>Persiapan Kelulusan</span></a></li>
					<li class="<?= $at=='meetings'&&$at2=='cert' ? 'active':''; ?>"><a href="<?=base_url('meetings/cert/l');?>"><i class="fa fa-certificate"></i> <span>Sertifikat Kehadiran</span></a></li>
<?php } ?>
				
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$title;?>
        <!--small>Control panel</small-->
      </h1>
      <!--ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$title;?></li>
      </ol-->
    </section>
<?php } ?>