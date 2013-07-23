<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* this is for ojt page*/
class ojt extends CI_Controller {
	
	/* before anything else check user information*/
	function __construct()
	{
		parent::__construct();
		$this->globals->is_other($this->session->userdata('logged'),$this->session->userdata('user_id'),$this->session->userdata('role'),$this->uri->segment(1));		
	}
	
	/*display ojt home page..*/
	function index()
	{
		$data['css'] =  $this->globals->css();
		$data['javascript'] = $this->globals->javascript();
		$data['title'] = 'SP Madrid - OJT';
		$this->load->view('header',$data);	
			//$this->load->view('agentleads',$data);
		$this->load->view('footer');
	}
	

}