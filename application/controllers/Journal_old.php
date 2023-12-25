<?php

/**
 * Journal engineering FTUI	
 * @author	: Sabbana
 * @corp	: sStud-io.net
 * @Date Created	: 28 April 2017
 */

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Journal_old extends CI_Controller {

	

    public function __construct() {
        parent::__construct();
    }

    public function referal($param1, $param2, $param3) {
    	$page = site_url().'old/index.php/journal/'.$param1.'/'.$param2.'/'.$param3;     	
        redirect($page);
	}

	public function issue_referal($param1, $param2, $param3){
		$page = site_url().'old/index.php/journal/issue/'.$param1.'/'.$param2.'/'.$param3;
        redirect($page);    	
	}


}
