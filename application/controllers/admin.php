<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
			parent::__construct();
			/*check user information*/
			$this->globals->is_admin($this->session->userdata('logged'),$this->session->userdata('user_id'),$this->session->userdata('role'));		
	}	
	 
	/*display index page of admin*/ 
	public function index()
	{
		$data['css'] =  $this->globals->css();
		$data['javascript'] = $this->globals->javascript();
		$data['title'] = 'SP Madrid - Admin';
		$this->load->view('header',$data);	
			$this->load->view('user',$data);
		$this->load->view('footer');	
	}
	
	
	/*return json for user lists*/
	function user_data()
	{
		$page =  $this->input->post('page');
		$rp = 	$this->input->post('rp');
		
		$sortname = ($this->input->post('sortname') == 'undefined') ? 'id' : addslashes($this->input->post('sortname'));
		$sortorder = ($this->input->post('sortorder') == 'undefined') ? 'desc' : addslashes($this->input->post('sortorder'));
		$rp = ($this->input->post('rp') == 'undefined') ? 10 : addslashes($this->input->post('rp'));
		
		$sort = "ORDER BY $sortname $sortorder";
		
		if (!$page) $page = 1;
		
		$start = (($page-1) * $rp);
		$limit = "LIMIT $start, $rp";
		
		$query = addslashes($this->input->post('query'));
		$qtype = $this->input->post('qtype');
		
		$where = "";
		if ($query) {
			$qtype = explode('||', $qtype);
			$flag = 0;
			
			foreach ($qtype as $value) {
					if ($flag == 1) {
						$where .= " OR $value LIKE '%$query%' ";
					} else {
							$where .= " where $value LIKE '%$query%' ";
							$flag = 1;
					}
				}
			}
			$sql  = $this->tblagent->list_data($where);
			$resultarray = array();
			if($sql){
					if($sql->num_rows() > 0){
						foreach($sql->result() as $ro){
							$resultarray[] = $ro;
						}	
					}
			}
			
		$total = count($resultarray);
		$data['page'] = $page;
		$data['total'] = $total; 
		
		
		  $query = $this->tblagent->user_sort_limit($where, $sort,$limit);
		  if($query){
					if($query->num_rows() > 0){
							foreach($query->result() as $dis){
							$rows[] = array (
							"id" => $dis->ID,
							"cell" => array(
							'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
							,$dis->ID
							,$dis->AgentName
							,$dis->Agenttlead
							,$dis->AccessL
							,$dis->AgentBranch
							,$dis->AgentContact
							,$dis->AgentStatus
							)
							);
							}
					}
			}

		$data['rows'] = $rows;
		$data['params'] = $_POST;
		echo json_encode($data); 
	}
	
	/*change user status */
	function change_user_status(){
		$id  = $this->input->post('del_lead');
		$id = explode(",",$id);
		$stat = $this->tblagent->updateStatus($id);
		if($stat)
		{
			echo "1";
		}else
		{
			echo "2";
		}
		exit;
	}
	/*display create user page*/
	function add_user()
	{
		$this->load->view('add_user');
	}
	
	/*save new user to database*/
	function create()
	{
		$response = array();
		foreach($this->input->post() as $key => $value){
			$$key = $value;
		}
		
		$level = implode(",",$this->input->post('level'));
		$bank = implode(",",$this->input->post('bank'));
		$pho = $_FILES["photo"]["name"];
		$data = array(
			'ID'=>$id,
			'AgentCode'=>$code,
			'AgentName'=>$name,
			'AgentPin'=>$pass,
			'AgentPhoto'=>$pho,
			'Agenttlead'=>$tlead,
			'AgentSup'=>$sup,
			'AgentBank'=>$bank,
			'AccessL'=>$level,
			'PseudoName'=>$suedo,
			'AgentBranch'=>$branch,
			'AgentContact'=>$contact,
			'AgentStatus'=>'ACTIVE',
			'AgentLevel'=>$alevel,
			'AgentPlace'=>$place,
			'AgentLocal'=>$local,
			'AgentEmail'=>$email,
			'AgentAss'=>$assign
			
		);
		
		$validate = $this->tblagent->validate_user($name,$id);
		if($validate->num_rows() == 0)
		{
			$insert = $this->tblagent->insert($data);
			if($insert){
				if(isset($_FILES["photo"]) && count($_FILES["photo"])>0){
					if(!file_exists($this->globals->right_document()."/../image/photo/".$id)){
						mkdir($this->globals->right_document()."/../image/photo/".$id,7777);
					}
					
					  
						move_uploaded_file( $_FILES["photo"]["tmp_name"], $this->globals->right_document()."/../image/photo/".$id."/" . $_FILES['photo']['name']);  
				}
			$response['error'] = 'Successfully Saved';
			$response['status'] = TRUE;
			}
			
			
		}else
		{
			$response['error'] = 'Agent Already Exists.';
			$response['status'] = FALSE;
			
		}
		
		echo json_encode($response);
			
	}
	/* display user information*/
	function edit(){
		$id = $this->input->get('id');
		$search = $this->tblagent->view_info($id);
		$aclevel = explode(",",$search->AccessL);
		$bnlist = explode(",",$search->AgentBank);
		foreach($aclevel as $lcs)
		{ $lvls[] = $lcs;}
		foreach($bnlist as $bn)
		{ $bns[] = $bn; }
		$data = array(
			'code'=>$search->AgentCode,
			'name'=>$search->AgentName,
			'pass'=>$search->AgentPin,
			'tlead'=>$search->Agenttlead,
			'sup'=>$search->AgentSup,
			'bank'=>$bns,
			'level'=>$lvls,
			'suedo'=>$search->PseudoName,
			'branch'=>$search->AgentBranch,
			'contact'=>$search->AgentContact,
			'alevel'=>$search->AgentLevel,
			'place'=>$search->AgentPlace,
			'local'=>$search->AgentLocal,
			'email'=>$search->AgentEmail,
			'assign'=>$search->AgentAss,
			'id'=>$id
		);
		
		$this->load->view('update_user',$data);
		
	}
	/* update user information*/
	function update()
	{
		$response = array();
		foreach($this->input->post() as $key => $value){
			$$key = $value;
		}
		$level = implode(",",$this->input->post('level'));
		$bank = implode(",",$this->input->post('bank'));
		$phot = $_FILES["photo"]["name"];
		if($name == ''){
			$data = array(
			'AgentCode'=>$code,
			'AgentName'=>$name,
			'AgentPin'=>$pass,
			'Agenttlead'=>$tlead,
			'AgentSup'=>$sup,
			'AgentBank'=>$bank,
			'AccessL'=>$level,
			'PseudoName'=>$suedo,
			'AgentBranch'=>$branch,
			'AgentContact'=>$contact,
			'AgentLevel'=>$alevel,
			'AgentPlace'=>$place,
			'AgentLocal'=>$local,
			'AgentEmail'=>$email,
			'AgentAss'=>$assign
			);
		}
		$data = array(
			'AgentCode'=>$code,
			'AgentName'=>$name,
			'AgentPin'=>$pass,
			'AgentPhoto'=>$phot,
			'Agenttlead'=>$tlead,
			'AgentSup'=>$sup,
			'AgentBank'=>$bank,
			'AccessL'=>$level,
			'PseudoName'=>$suedo,
			'AgentBranch'=>$branch,
			'AgentContact'=>$contact,
			'AgentLevel'=>$alevel,
			'AgentPlace'=>$place,
			'AgentLocal'=>$local,
			'AgentEmail'=>$email,
			'AgentAss'=>$assign
			);
		
		
		
			$upd = $this->tblagent->update($data,$id);
			if($upd){
				if(isset($_FILES["photo"]) && count($_FILES["photo"])>0){
					if(!file_exists($this->globals->right_document()."/../image/photo/".$id)){
						mkdir($this->globals->right_document()."/../image/photo/".$id,0777);
						
					}
					
					  
						move_uploaded_file( $_FILES["photo"]["tmp_name"], $this->globals->right_document()."/../image/photo/".$id."/" . $_FILES['photo']['name']);  
				}
				$response['error'] = 'Successfully Updated';
				$response['status'] = TRUE;
			}else
			{
				$response['error'] = 'Error, please try again later.';
				$response['status'] = FALSE;
			}
		echo json_encode($response);
	}
	
	
	
}