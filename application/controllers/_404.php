<?php

/**
 * @package    ssstud-io
 * @author     Sabbana
 * @copyright  PT. Pajon Tech - sStud-io.net
 * @version    1.0
 */

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class _404 extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
		$this->load->view('template/_404');
    }
}
