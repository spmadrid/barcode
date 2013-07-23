<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {

	/*display error page */
		function index()
		{
			
			$this->load->view('error');
		}
		
		/* set session to null and destroy session and redirect*/
		function logout()
		{
				$newdata = array(
					'user_id'=>NULL,
					'role'=>NULL,
					'username'=>NULL,
					'logged'=>NULL,
				);
				$this->session->unset_userdata($newdata);
				$this->session->sess_destroy();
				redirect('/welcome/index/');
		}
}