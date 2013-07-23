<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*tlead page*/
class Tl extends CI_Controller {
	/*check user if right to access this controller*/
	function __construct()
	{
		parent::__construct();
		$this->globals->is_other($this->session->userdata('logged'),$this->session->userdata('user_id'),$this->session->userdata('role'),$this->uri->segment(1));		
	}
	
	/*display tlead home page*/
	function index()
	{
		$result = '';
		$list = '';
		$data['css'] =  $this->globals->css();
		$data['javascript'] = $this->globals->javascript();
		$data['title'] = 'SP Madrid - TL';
		$where = "WHERE Agenttlead='".$this->session->userdata('name')."' and AgentBank != ''";
		$agent = $this->tblagent->list_data($where);
		if($agent){
			$result = $agent->result();
			foreach($result as $per)
			{
				if($per->AgentBank != 'ALL'){
					if($per->AgentPhoto != NULL){ $pho = $per->AgentPhoto;}else { $pho = "0";}	

					$list[] = array(
						'bank'=>$per->AgentBank,
						'code'=>$per->AgentCode,
						'name'=>$per->PseudoName,
						'photo'=>$pho,
					);	
				}
			}
		}else
		{
			$result = '';
			$list = '';
		}
		$data['result'] = $result;
		$data['list'] = $list;
		$this->load->view('header',$data);	
			$this->load->view('report',$data);
		$this->load->view('footer');
	}
	
	/* view agent under tlead*/
	function viewagentleads($code,$bank,$name,$photo)
	{
		$where = "WHERE AgentCode = '".$code."'";
		$id  = $this->tblagent->list_data($where);
		$res = $id->row();
		$num  = $res->ID;
		$data['code'] = $code;
		$data['bank'] = $bank;
		$data['name'] = $name;
		$data['photo'] = $photo;
		$data['id'] = $num;
 		$this->load->view('viewagentleads',$data);
	}
	
	/* display leads of the agent and return JSON*/
	function listleads()
	{
		$code = $this->input->get('code');
		$bank = $this->input->get('bank');
		$tbl = array(
			'bpi'=>'tblBPI',
			'hsbcm'=>'tblHSBCM',
			'ubp'=>'tblUBP',
			'mcc'=>'tblMCC',
			'ewb'=>'tblEWB',
			'ewb7'=>'tblEWBC7',
			'pif'=>'tblHDMF',
			'hsbg'=>'tblHSBCM',
			'psb'=>'tblPSB'
		);
		switch($bank){
			
			case 'PSB':
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
				$where .= " WHERE Agent = '".$code."' ";
				if ($query) {
					$qtype = explode('||', $qtype);
					$flag = 0;
					
					foreach ($qtype as $value) {
							if ($flag == 1) {
								$where .= " OR $value LIKE '%$query%' ";
							} else {
									$where .= " OR $value LIKE '%$query%' ";
									$flag = 1;
							}
						}
					}
					$sql  = $this->agentmodel->list_data($tbl['psb'],$where);
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
				
				
				  $query = $this->agentmodel->user_sort_limit($tbl['psb'],$where, $sort,$limit);
				  if($query){
							if($query->num_rows() > 0){
									foreach($query->result() as $dis){
									$rows[] = array (
									"id" => $dis->ID,
									"cell" => array(
									'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
									,$dis->ID
									,$dis->CHCode
									,$dis->AccountName
									,$dis->Agency
									)
									);
									}
							}
					}
		
				$data['rows'] = $rows;
				$data['params'] = $_POST;
				echo json_encode($data); 
			break;
			case 'BPI':
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
				$where .= " WHERE Agent = '".$code."' ";
				if ($query) {
					$qtype = explode('||', $qtype);
					$flag = 0;
					
					foreach ($qtype as $value) {
							if ($flag == 1) {
								$where .= " OR $value LIKE '%$query%' ";
							} else {
									$where .= " OR $value LIKE '%$query%' ";
									$flag = 1;
							}
						}
					}
					$sql  = $this->agentmodel->list_data($tbl['bpi'],$where);
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
				
				
				  $query = $this->agentmodel->user_sort_limit($tbl['bpi'],$where, $sort,$limit);
				  if($query){
							if($query->num_rows() > 0){
									foreach($query->result() as $dis){
									$rows[] = array (
									"id" => $dis->ID,
									"cell" => array(
									'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
									,$dis->ID
									,$dis->CHCode
									,$dis->CHName
									,$dis->Placement
									)
									);
									}
							}
					}
		
				$data['rows'] = $rows;
				$data['params'] = $_POST;
				echo json_encode($data); 
			break;
			case "HSBM":
			
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
				$where .= " WHERE Agent = '".$code."' ";
				if ($query) {
					$qtype = explode('||', $qtype);
					$flag = 0;
					
					foreach ($qtype as $value) {
							if ($flag == 1) {
								$where .= " OR $value LIKE '%$query%' ";
							} else {
									$where .= " OR $value LIKE '%$query%' ";
									$flag = 1;
							}
						}
					}
					$sql  = $this->agentmodel->list_data($tbl['hsbcm'],$where);
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
				
				
				  $query = $this->agentmodel->user_sort_limit($tbl['hsbcm'],$where, $sort,$limit);
				  if($query){
							if($query->num_rows() > 0){
									foreach($query->result() as $dis){
									$rows[] = array (
									"id" => $dis->ID,
									"cell" => array(
									'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
									,$dis->ID
									,$dis->CHCode
									,$dis->NAME
									,$dis->coll_name
									)
									);
									}
							}
					}
		
				$data['rows'] = $rows;
				$data['params'] = $_POST;
				echo json_encode($data); 
			break;
				case "HSBG":
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
				$where .= " WHERE Agent = '".$code."' ";
				if ($query) {
					$qtype = explode('||', $qtype);
					$flag = 0;
					
					foreach ($qtype as $value) {
							if ($flag == 1) {
								$where .= " OR $value LIKE '%$query%' ";
							} else {
									$where .= " OR $value LIKE '%$query%' ";
									$flag = 1;
							}
						}
					}
					$sql  = $this->agentmodel->list_data($tbl['hsbg'],$where);
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
				
				
				  $query = $this->agentmodel->user_sort_limit($tbl['hsbg'],$where, $sort,$limit);
				  if($query){
							if($query->num_rows() > 0){
									foreach($query->result() as $dis){
									$rows[] = array (
									"id" => $dis->ID,
									"cell" => array(
									'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
									,$dis->ID
									,$dis->CHCode
									,$dis->NAME
									,$dis->coll_name
									)
									);
									}
							}
					}
		
				$data['rows'] = $rows;
				$data['params'] = $_POST;
				echo json_encode($data);
				break;
				
				case "PIF":
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
				$where .= " WHERE Agent = '".$code."' ";
				if ($query) {
					$qtype = explode('||', $qtype);
					$flag = 0;
					
					foreach ($qtype as $value) {
							if ($flag == 1) {
								$where .= " OR $value LIKE '%$query%' ";
							} else {
									$where .= " OR $value LIKE '%$query%' ";
									$flag = 1;
							}
						}
					}
					$sql  = $this->agentmodel->list_data($tbl['pif'],$where);
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
				
				
				  $query = $this->agentmodel->user_sort_limit($tbl['pif'],$where, $sort,$limit);
				  if($query){
							if($query->num_rows() > 0){
									foreach($query->result() as $dis){
									$rows[] = array (
									"id" => $dis->ID,
									"cell" => array(
									'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
									,$dis->ID
									,$dis->CHCode
									,$dis->NAME
									,$dis->PROJECT
									)
									);
									}
							}
					}
		
				$data['rows'] = $rows;
				$data['params'] = $_POST;
				echo json_encode($data);
				break;
				case "EWB":
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
				$where .= " WHERE Agent = '".$code."' ";
				if ($query) {
					$qtype = explode('||', $qtype);
					$flag = 0;
					
					foreach ($qtype as $value) {
							if ($flag == 1) {
								$where .= " OR $value LIKE '%$query%' ";
							} else {
									$where .= " OR $value LIKE '%$query%' ";
									$flag = 1;
							}
						}
					}
					$sql  = $this->agentmodel->list_data($tbl['ewb'],$where);
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
				
				
				  $query = $this->agentmodel->user_sort_limit($tbl['ewb'],$where, $sort,$limit);
				  if($query){
							if($query->num_rows() > 0){
									foreach($query->result() as $dis){
									$rows[] = array (
									"id" => $dis->ID,
									"cell" => array(
									'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
									,$dis->ID
									,$dis->CHCODE
									,$dis->FULLNAME
									,$dis->NEW_AGENCY
									)
									);
									}
							}
					}
		
				$data['rows'] = $rows;
				$data['params'] = $_POST;
				echo json_encode($data);
				break;
				case "EWB7":
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
				$where .= " WHERE Agent = '".$code."' ";
				if ($query) {
					$qtype = explode('||', $qtype);
					$flag = 0;
					
					foreach ($qtype as $value) {
							if ($flag == 1) {
								$where .= " OR $value LIKE '%$query%' ";
							} else {
									$where .= " OR $value LIKE '%$query%' ";
									$flag = 1;
							}
						}
					}
					$sql  = $this->agentmodel->list_data($tbl['ewb7'],$where);
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
				
				
				  $query = $this->agentmodel->user_sort_limit($tbl['ewb7'],$where, $sort,$limit);
				  if($query){
							if($query->num_rows() > 0){
									foreach($query->result() as $dis){
									$rows[] = array (
									"id" => $dis->ID,
									"cell" => array(
									'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
									,$dis->ID
									,$dis->CHCODE
									,$dis->FULLNAME
									,$dis->NEW_AGE
									)
									);
									}
							}
					}
		
				$data['rows'] = $rows;
				$data['params'] = $_POST;
				echo json_encode($data);
				break;
				case "MCC":
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
				$where .= " WHERE Agent = '".$code."' ";
				if ($query) {
					$qtype = explode('||', $qtype);
					$flag = 0;
					
					foreach ($qtype as $value) {
							if ($flag == 1) {
								$where .= " OR $value LIKE '%$query%' ";
							} else {
									$where .= " OR $value LIKE '%$query%' ";
									$flag = 1;
							}
						}
					}
					$sql  = $this->agentmodel->list_data($tbl['mcc'],$where);
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
				
				
				  $query = $this->agentmodel->user_sort_limit($tbl['mcc'],$where, $sort,$limit);
				  if($query){
							if($query->num_rows() > 0){
									foreach($query->result() as $dis){
									$rows[] = array (
									"id" => $dis->ID,
									"cell" => array(
									'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
									,$dis->ID
									,$dis->CHCode
									,$dis->NAME
									,$dis->NEW_U3
									)
									);
									}
							}
					}
		
				$data['rows'] = $rows;
				$data['params'] = $_POST;
				echo json_encode($data);
				
				case "UBP":
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
				$where .= " WHERE Agent = '".$code."' ";
				if ($query) {
					$qtype = explode('||', $qtype);
					$flag = 0;
					
					foreach ($qtype as $value) {
							if ($flag == 1) {
								$where .= " OR $value LIKE '%$query%' ";
							} else {
									$where .= " OR $value LIKE '%$query%' ";
									$flag = 1;
							}
						}
					}
					$sql  = $this->agentmodel->list_data($tbl['ubp'],$where);
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
				
				
				  $query = $this->agentmodel->user_sort_limit($tbl['ubp'],$where, $sort,$limit);
				  if($query){
							if($query->num_rows() > 0){
									foreach($query->result() as $dis){
									$rows[] = array (
									"id" => $dis->ID,
									"cell" => array(
									'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
									,$dis->ID
									,$dis->CHCode
									,$dis->CARD_NAME
									,$dis->REMARKS
									)
									);
									}
							}
					}
		
				$data['rows'] = $rows;
				$data['params'] = $_POST;
				echo json_encode($data);
				break;
			default:
			break;
			
		}
		
	}
	

}