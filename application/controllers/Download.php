<?php 

/*
Date created : 08-09-2018
*/

class Download extends CI_Controller{

	public function __construct(){
		parent::__construct();
		// $this->load->model('Mdl_cms','cms');
		$this->load->library('Lib_cms');
		$this->load->helper('download');
	}
	public function _remap($parameter){ //all function will go here first
		$this->index($parameter);
	}
public function index($sub_id){
    $filepath = $this->input->post('f');
		if(!isset($filepath)){
			$filepath = $this->input->get('f'); 
			// http://localhost/ijtech/download?f=./assets/front/img/logo_lama.png
			// http://localhost/ijtech/download?f=./assets/front/img/logo_lama.png&k=coba
			// http://localhost/ijtech/download/coba?f=./assets/front/img/logo_lama.png
			$k = $this->input->get('k');
			if(!isset($k)){
				$k = $sub_id;
			}
			if(isset($k)){
				$this->db->set('time_read', date('Y-m-d H:i:s'))->where('k',$k)->update('sendmail_log');
			}
			$this->go($filepath,false); //false = no download
		}
		$role = $this->session->userdata('role');
    $user_id = $this->session->userdata('user_id');
    $user_email = $this->session->userdata('email');
    
		if(empty($role)){ redirect('login'); }
    if( in_array(1,$role)    //administrator
        || in_array(2,$role) //secretariat
        || in_array(3,$role) //editor
        || in_array(4,$role) //section editor
    ){
      // $this->getfile(base_url().$filepath);
			$this->go($filepath);
    }elseif( in_array(5,$role) ){ //the author
      // cek apakah user ini adalah author utk paper ini
      $tmp = $this->cms->get_submission_by_sub_id_and_user_id($sub_id,$user_id);
      if(!empty($tmp)){
        // $this->getfile(base_url().$filepath);
				$this->go($filepath);
      }
    }elseif( in_array(6,$role) ){ //the reviewer
      // cek apakah ini merupakan reviewer yg sudah setuju mereview paper ini dan belum selesai mereview
      $tmp = $this->cms->get_submission_by_sub_id_and_reviewer_email($sub_id,$user_email);
      if(!empty($tmp)){
        // $this->getfile(base_url().$filepath);
				$this->go($filepath);
      }
    }
}
  
  private function getfile($file_url){ //obsolete, replaced by go()
    header('Content-Type: application/octet-stream');
    // header("Content-Transfer-Encoding: Binary"); 
    // header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
    header('Content-Transfer-Encoding: Binary'); 
    header('Content-disposition: attachment; filename="' . basename($file_url) . '"'); 
    readfile($file_url);
  }
	
	private function go($filepath,$download=true){
		if($filepath){
		 if($download){
			$file = realpath($filepath);
			if (file_exists ( $file )) {
				$data = file_get_contents ( $file );
				// die('Loading...');
				// header('Content-type: application/pdf');
				// header('Content-Disposition: attachment; filename="IJTech-'.basename($filepath).'";');
				force_download ( basename($filepath), $data );
			} else {
				die('0');
			}
		 }else{
			if(file_exists($filepath)){ 
				// $mime = mime_content_type($filepath); //<-- detect file type
				header('Content-Length: '.filesize($filepath)); //<-- sends filesize header
				header("Content-Type: image/png"); //<-- send mime-type header
				header('Content-Disposition: inline; filename="IJTech-'.basename($filepath).'";'); //<-- sends filepath header
				readfile($filepath); //<--reads and outputs the file onto the output buffer
				die(); //<--cleanup
			}
		 }
			
		}
	}
	
}

?>