<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*this is for super admin*/
class Add extends CI_Controller {
	
	/*check user information if he/she has right to access this controller*/
	function __construct()
	{
			parent::__construct();
			$this->globals->is_head($this->session->userdata('logged'),$this->session->userdata('user_id'),$this->session->userdata('role'));		
	}	
	 /*display list of addons*/
	function index()
	{
		$data['css'] =  $this->globals->css();
		$data['javascript'] = $this->globals->javascript();
		$data['title'] = 'SP Madrid - Add Ons';
		$this->load->view('header',$data);	
			$this->load->view('addon_index',$data);
		$this->load->view('footer');	
	}
	
	/*display supervisor page*/
	function supervisor()
	{
			$this->load->view('supervisor');		
	}
	
	/*return supervisor list return JSON*/
	function suplist()
	{
		$table = $this->input->get('table');	
		$rows = array();
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
			$sql  = $this->addons->list_data($where,$table);
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
		
		
		  $query = $this->addons->user_sort_limit($where, $sort,$limit,$table);
		  if($query){
					if($query->num_rows() > 0){
							foreach($query->result() as $dis){
switch($table)
		{
			case 'tblsupervisor':
			$rows[] = array ("id" => $dis->id,"cell" => array(
	'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->id.'" />'
	,$dis->id,$dis->supervisor_name));
			break;
			case 'tbllead':
			$rows[] = array ("id" => $dis->id,"cell" => array(
	'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->id.'" />'
	,$dis->id,$dis->lead_name));
			break;
			case 'tblbranch':
		$rows[] = array ("id" => $dis->id,"cell" => array(
	'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->id.'" />'
	,$dis->id,$dis->branch_name));	
			break;
			case 'tblbank':
		$rows[] = array ("id" => $dis->id,"cell" => array(
	'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->id.'" />'
	,$dis->id,$dis->bank_name));	
			break;
		}								
								
								
								
								
		
							}
					}
			}

		$data['rows'] = $rows;
		$data['params'] = $_POST;
		echo json_encode($data);
	}
	/* team leader display page */
	function tlead()
	{
		$this->load->view('lead');	
	}
	/*branch display page*/
	function branch()
	{
		$this->load->view('branch');	
	}
	
	/*bank display page*/
	function bank()
	{
		$this->load->view('bank');	
	}
	
	/*dynamic access */
	function addnamic($cur)
	{
		switch($cur)
		{
			case 'tblsupervisor':
			$data['header'] = 'Add Supervisor';
			$data['table'] = 'tblsupervisor';
			break;
			case 'tbllead':
			$data['header'] = 'Add Team Lead';
			$data['table'] = 'tbllead';
			break;
			case 'tblbranch':
			$data['header'] = 'Add Branch';
			$data['table'] = 'tblbranch';
			break;
			case 'tblbank':
			$data['header'] = 'Add Bank';
			$data['table'] = 'tblbank';
			break;
		}

		$this->load->view('addons_add',$data);
	}
	/*save name on the database*/
	function save()
	{
		$name = $this->input->post('name');
		$table = $this->input->post('hidden');
		$response = array();
		if($this->addons->submit($name,$table))
		{
			$response['status'] = TRUE;
		}else
		{
			$response['status'] = FALSE;
			$response['error'] = "Can not save this time";
		}
		
		
		echo json_encode($response);
		exit;
	}
	
	/*delete name for tlead or sup*/
	function deletenames()
	{
		foreach($this->input->post('del_lead') as $index)
		{
			$this->addons->delete($index,$this->input->post('table'));
		}
		echo "1";
		exit;
	}
	
	/*display form for edit tlead and sup*/
	function edit()
	{
		$id =  $this->input->get('id');
		$table = $this->input->get('table');
		$data['result'] = $this->addons->search($id,$table);
		$data['header'] = "Update";
		$data['table'] = $table;
		
		$this->load->view('addons_edit',$data);
	}
	
	/* update tl or sup  */
	function update()
	{
		$name = $this->input->post('name');
		$id = $this->input->post('id');
		$table = $this->input->post('hidden');
		$response = array();
		if($this->addons->update($id,$name,$table))
		{
			$response['status'] = TRUE;
		}else
		{
			$response['status'] = FALSE;
			$response['error'] = "Can not update this time";
		}
		
		
		echo json_encode($response);
		exit;
	}
	
	/*view status*/
	function status()
	{
		$data['status'] = $this->status->status_list();
		$data['bank'] = $this->status->back_list();
		$this->load->view('viewstatus',$data);
	}
	
	/* return json for sub status*/
	function checksub()
	{
		$bank_id = $this->input->post('bank_id');
		$status_id = $this->input->post('status_id');
		 $response = array();
		 $q = $this->addons->sublist($bank_id,$status_id);
		 
		 if($q)
		 {
			$response['status'] = TRUE;
			$response['list'] = $q;
		 }else
		 {
			$response['status'] = FALSE;
		 }
		echo json_encode($response);
		exit;
	}
	
	/*display sub status form*/
	function addsub()
	{
		$this->load->view('addsub');
	}
	
	/*save to sub status to database*/
	function savesub(){
			$sub = $this->input->post('substat');
			$text = $this->input->post('text');
			$status = $this->input->post('status_id');
			$bank = $this->input->post('bank_id');
			$response = array();
			$data = array(
				'status_name_id'=>$status,
				'bank_id'=>$bank,
				'status_acro'=>$sub,
				'status_mean'=>$text
			);
			$q = $this->addons->tblsuvsave($data);
			
			if($q)
			{
				$response['status'] = TRUE;
			}else{
				$respone['status'] = FALSE;
			}
		echo json_encode($response);
	}
	
	/*delte sub status s*/
	function deletesub()
	{
		$id = $this->input->post('id');
		$q = $this->addons->deletesub($id);
		$response = array();
		if($q)
		{
				$response['status'] = TRUE;
		}else
		{
			$response['status'] = FALSE;
		}
		echo json_encode($response);
		exit;
	}
	
	/*diplay edit page for supervisor*/
	function editsub($id)
	{
		$q = $this->addons->subrow($id);
		$data['info'] = $q;
		$this->load->view('editsub',$data);
	}
	
	
	/*update supervisor*/
	function upsub()
	{
		$id = $this->input->post('id');
		$acro = $this->input->post('substat');
		$mean = $this->input->post('text');
		$response = array();
		$data = array(
				'status_acro'=>$acro,
				'status_mean'=>$mean
			);
		$q = $this->addons->updatesub($data,$id);
		if($q)
		{
			$response['status'] = TRUE;
		}else
		{
			$response['status']= FALSE;
		}
		echo json_encode($response);
	}
}