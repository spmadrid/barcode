<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* this is for field users only */
class fields extends CI_Controller {
	
	/*check user information if he/she has right to access this controller*/
	function __construct()
	{
		parent::__construct();
		$this->globals->is_other($this->session->userdata('logged'),$this->session->userdata('user_id'),$this->session->userdata('role'),$this->uri->segment(1));		
	}
	
	
	/* display home page*/
	function index()
	{
		$data['css'] =  $this->globals->css();
		$data['javascript'] = $this->globals->javascript();
		$data['title'] = 'SP Madrid - Fields';
		$this->load->view('header',$data);	
			//$this->load->view('agentleads',$data);
		$this->load->view('footer');
	}
	

}