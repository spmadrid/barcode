<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
			parent::__construct();
			/*check if already log and redirect*/
			$this->is_logged_in();
	}
	 /* login page */
	public function index()
	{
		$data['css'] =  $this->globals->login();
		$data['javascript'] = $this->globals->javascript();
		$data['error'] = '';
		$this->load->view('login/header',$data);
		$this->load->view('login/login' ,$data);
		$this->load->view('login/footer');
	}
	
	/*validate username and password then redirect if valid*/
	function login()
	{
		$data['css'] =  $this->globals->login();
		$data['javascript'] = $this->globals->javascript();
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Passwrod', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$data['error'] = 'Username or Password is not match.';
			$this->load->view('login/header',$data);
			$this->load->view('login/login',$data);
			$this->load->view('login/footer');
		}
		else
		{
			$valid = $this->tblagent->validate_account();
			if($valid)
			{	
				$newdata = array(
					'user_id'=>$valid->ID,
					'role'=>$valid->AccessL,
					'username'=>$valid->AgentName,
					'bank'=>$valid->AgentBank,
					'code'=>$valid->AgentCode,
					'name'=>$valid->PseudoName,
					'photo'=>$valid->AgentPhoto,
					'logged'=>TRUE,
				);
				
				$this->session->set_userdata($newdata);
				
				$pos = $this->session->userdata('role');
				$pos = explode(",",$pos);
				$pos = $pos[0];
				if($pos == 'ADMIN')
				{
					redirect('/admin/index/');	
				}else if($pos == 'AGENT')
				{
					redirect('/agent/index/');
				}
				else if($pos == 'TL')
				{
					redirect('/tl/index/');
				}
				else if($pos == 'OJT')
				{
					redirect('/ojt/index/');
				}
				else if($pos == 'FIELDS')
				{
					redirect('/fields/index/');
				}
				else if($pos == 'HEADADMIN')
				{
					redirect('/add/index/');
				}
				
				
			}else
			{

				
				$data['error'] = 'Username or Password is not match.';
				$this->load->view('login/header',$data);
				$this->load->view('login/login',$data);
				$this->load->view('login/footer');	
			}
		}
	}
	
	/*check user if logged and redirect*/
	function is_logged_in()
	{
		if($this->session->userdata('logged'))
		{
			$pos = $this->session->userdata('role');
				$pos = explode(",",$pos);
				$pos = $pos[0];
				if($pos == 'ADMIN')
				{
					redirect('/admin/index/');	
				}else if($pos == 'AGENT')
				{
					redirect('/agent/index/');
				}
				else if($pos == 'TL')
				{
					redirect('/tl/index/');
				}
				else if($pos == 'OJT')
				{
					redirect('/ojt/index/');
				}
				else if($pos == 'FIELDS')
				{
					redirect('/fields/index/');
				}
				else if($pos == 'HEADADMIN')
				{
					redirect('/add/index/');
				}
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */