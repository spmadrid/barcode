<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		/*check user information if right to visit the page*/
		$this->globals->is_other($this->session->userdata('logged'),$this->session->userdata('user_id'),$this->session->userdata('role'),$this->uri->segment(1));		
	}
	
	/*display agent index page*/
	function index()
	{
		$data['css'] =  $this->globals->css();
		$data['javascript'] = $this->globals->javascript();
		$data['title'] = 'SP Madrid - Agent Leads';
		$this->load->view('header',$data);	
			$this->load->view('agentleads',$data);
		$this->load->view('footer');
	}
	
	/*check for current bank and display agent leads*/
	function leads()
	{
		$bank = $this->input->get('bnk');
		$code = $this->session->userdata('code');
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

		switch($bank)
		{
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
				break;
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
	
	/*display agent status form*/
	function status()
	{
		$data['css'] =  $this->globals->css();
		$data['javascript'] = $this->globals->javascript();
		$data['title'] = 'SP Madrid - Lead Status';
		$data['status_list'] = $this->status->status_lists();
		$this->load->view('header',$data);	
			$this->load->view('status',$data);
		$this->load->view('footer');	
	}
	
	/*save bank status to tblStatus*/
	function savestatus()
	{
		foreach($this->input->post() as $key => $value)
		{$$key = $value; }
		
		if($ptpdate != '')
		{
			$ptpdate = date("Y-m-d",strtotime($ptpdate));
		}else
		{
			$ptpdate = "";
		}
		
		if(!isset($radio_checked))
		{
			$radio_checked = NULL;
		}
		
		$table = '';
		$response = array();
		switch($bank)
		{
				case "BPI":
					$table = 'tblBPI';
				break;
				case "HSBG":
					$table = 'tblHSBCM';
				break;
				case "HSBM":
					$table = 'tblHSBCM';
				break;
				case "PIF":
					$table = 'tblHDMF';
				break;
				case "EWB":
					$table = 'tblEWB';
				break;
				case "EWB7":
					$table = 'tblEWBC7';
				break;
				case "MCC":
					$table = 'tblMCC';
				break;
				case "UBP":
					$table = 'tblUBP';
				break;
				case 'PSB':
					$table = 'tblPSB';
				break;
		}
		
		if($data = $this->agentmodel->checkbar($table,$barcode,$this->session->userdata('code'))){
			$status_table = "tblStatus";
		switch($bank)
		{
				case "BPI":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->AcctNo,
							'CHName'=>$data->CHName,
							'Amt'=>$amount,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						
						if($this->agentmodel->insertstatus($ins,$status_table))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->CHName;
							$response['acctno'] = $data->AcctNo;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "HSBG":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->accountnumber,
							'CHName'=>$data->NAME,
							'Amt'=>$amount,
							//'dDate'=>$data->STATE_ENTRY_DATE,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->insertstatus($ins,$status_table))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->NAME;
							$response['acctno'] = $data->accountnumber;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "HSBM":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->accountnumber,
							'CHName'=>$data->NAME,
							'Amt'=>$amount,
							//'dDate'=>$data->STATE_ENTRY_DATE,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->insertstatus($ins,$status_table))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->NAME;
							$response['acctno'] = $data->accountnumber;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "PIF":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->AGENT,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->HLIDNO,
							'CHName'=>$data->NAME,
							'Amt'=>$amount,
							//'dDate'=>$data->fDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->insertstatus($ins,$status_table))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->NAME;
							$response['acctno'] = $data->HLIDNO;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "EWB":
					$ins = array(
							'ChCode'=>$data->CHCODE,
							'AgentCode'=>$data->AGENT,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->ACCTNO,
							'CHName'=>$data->FULLNAME,
							'Amt'=>$amount,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->insertstatus($ins,$status_table))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCODE;
							$response['chname'] = $data->FULLNAME;
							$response['acctno'] = $data->ACCTNO;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "EWB7":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->AGENT,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->ACCOUNT_NUMBER,
							'CHName'=>$data->FULLNAME,
							'Amt'=>$amount,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->insertstatus($ins,$status_table))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->FULLNAME;
							$response['acctno'] = $data->ACCOUNT_NUMBER;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "MCC":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->CARDNUMBER,
							'CHName'=>$data->NAME,
							'Amt'=>$amount,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->insertstatus($ins,$status_table))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->NAME;
							$response['acctno'] = $data->CARDNUMBER;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "UBP":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->CARD_NUMBER,
							'CHName'=>$data->CARD_NAME,
							'Amt'=>$amount,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->insertstatus($ins,$status_table))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->CARD_NAME;
							$response['acctno'] = $data->CARD_NUMBER;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case 'PSB':
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->AccountNo,
							'CHName'=>$data->AccountName,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->insertstatus($ins,$status_table))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->AccountName;
							$response['acctno'] = $data->AccountNo;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
		}



		}
		else
		{
			$response['success'] = FALSE;
			$response['message'] = 'Invalid barcode or agent code.';
		}
		echo json_encode($response);
	}
	
	function substatus()
	{
		$bank = $this->input->post('bank');
		$status = $this->input->post('status');
		$response =array();
		$bank_id = $this->addons->bank_id($bank);
		$status_id = $this->addons->status_id($status);
		
		$search = $this->addons->search_sub($bank_id,$status_id);
		if($search)
		{	$response['status'] = TRUE;
			foreach($search as $val)
			{
				$response['subs'][$val->status_acro] = $val->status_mean;
			}	
		}
		else
		{
			$response['status'] = FALSE;
		}
		
		echo json_encode($response);
	}
	
	function dlrequest()
	{
		$data['css'] =  $this->globals->css();
		$data['javascript'] = $this->globals->javascript();
		$data['title'] = 'SP Madrid - DL Request';
		$this->load->view('header',$data);	
			$this->load->view('dlrequest',$data);
		$this->load->view('footer');	
	}
	
	function save_fieldrequest()
	{
		
		foreach($this->input->post() as $key => $value)
		{$$key = $value; }
		$agent_code = $this->session->userdata('code');
		$table = '';
		$response = array();
		switch($bank)
		{
				case "BPI":
					$table = 'tblBPI';
				break;
				case "HSBG":
					$table = 'tblHSBCM';
				break;
				case "HSBM":
					$table = 'tblHSBCM';
				break;
				case "PIF":
					$table = 'tblHDMF';
				break;
				case "EWB":
					$table = 'tblEWB';
				break;
				case "EWB7":
					$table = 'tblEWBC7';
				break;
				case "MCC":
					$table = 'tblMCC';
				break;
				case "UBP":
					$table = 'tblUBP';
				break;
				case 'PSB':
					$table = 'tblPSB';
				break;
		}
		if(isset($newadd) && $newadd == '')
		{
			$newadd = '';
		}
		
		if(!isset($newaddtype))
		{
			$newaddtype = '';
		}
		
		if(!isset($fliers) && $fldate == '')
		{
			$fldate= '';
			$fliers = '';
		}else
		{
			$fliers = 'YES';
			$fldate = date("Y-m-d",strtotime($fldate));
		}
		
		$stat = $this->agentmodel->checkbar($table,$barcode,$agent_code);
		if($stat)
		{
			switch($bank)
		{
				case "BPI":
						$acctno = $stat->AcctNo;
						$chname = $stat->CHName;
						$prod = $stat->Product;
						$fadd = $stat->PrimaryAdd;	
						$sadd =	$stat->SecondaryAdd;
						$tadd = $stat->TertiaryAdd;
						$LocCode = $stat->LocCode;
				break;
				case "HSBG":
						$acctno = $stat->accountnumber;
						$chname = $stat->NAME;
						$prod = $stat->ACCTTYP;
						$fadd = $stat->ADDRESS_1;	
						$sadd =	$stat->ADDRESS_2;
						$tadd = $stat->ADDRESS_3;
						$LocCode = $stat->PLCode;
				break;
				case "HSBM":
						$acctno = $stat->accountnumber;
						$chname = $stat->NAME;
						$prod = $stat->ACCTTYP;
						$fadd = $stat->ADDRESS_1;	
						$sadd =	$stat->ADDRESS_2;
						$tadd = $stat->ADDRESS_3;
						$LocCode = $stat->PLCode;
				break;
				case "PIF":
						$acctno = $stat->HLIDNO;
						$chname = $stat->NAME;
						$prod = $stat->Product;
						$fadd = '';	
						$sadd =	'';
						$tadd = '';
						$LocCode = $stat->PLCode;
				break;
				case "EWB":
						$acctno = $stat->ACCTNO;
						$chname = $stat->FULLNAME;
						$prod = $stat->ACCT_TYPE;
						$fadd = $stat->HOME_ADD1;	
						$sadd =	$stat->HOME_ADD2;
						$tadd = $stat->HOME_ADD3;
						$LocCode = $stat->PLCode;
				break;
				case "EWB7":
						$acctno = $stat->ACCOUNT_NUMBER;
						$chname = $stat->FULLNAME;
						$prod = '';
						$fadd = $stat->BILLADD;	
						$sadd =	$stat->HOMEADD;
						$tadd = $stat->BUSSADD;
						$LocCode = $stat->PLCode;
				break;
				case "MCC":
						$acctno = $stat->CARDNUMBER;
						$chname = $stat->NAME;
						$prod = $stat->Product;
						$fadd = $stat->ADDR1;	
						$sadd =	$stat->ADDR2;
						$tadd = $stat->ADDR3;
						$LocCode = $stat->PLCode;
				break;
				case "UBP":
						$acctno = $stat->CARD_NUMBER;
						$chname = $stat->CARD_NAME;
						$prod = '';
						$fadd = $stat->Home;	
						$sadd =	$stat->CB_COMPANY_ADDRESS2;
						$tadd = $stat->CB_COMPANY_ADDRESS3;
						$LocCode = '';
				break;
				case 'PSB':
						$acctno = $stat->AccountNo;
						$chname = $stat->AccountName;
						$prod = $stat->Acct_Desc;
						$fadd = $stat->PrimaryAdd;	
						$sadd =	$stat->SecondaryAdd;
						$tadd = '';
						$LocCode = $stat->PLCode;
				break;
		}

			$data = array(
				'AgentCode'=>$agent_code,
				'CHCode'=>$barcode,
				'Bank'=>$bank,
				'AddType'=>$type,
				'NewAddType'=>$newaddtype,
				'NewAdd'=>$newadd,
				'dDate'=>date("Y-m-d H:i:s"),
				'DLType'=>$dltype,
				'FliersDate'=>$fldate,
				'LandMark'=>$landmark,
				'DLReq'=>$field,
				'AcctNo'=>$acctno,
				'CHName'=>$chname,
				'Product'=>$prod,
				'PrimaryAdd'=>$fadd,
				'SecondaryAdd'=>$sadd,
				'TertiaryAdd'=>$tadd,
			);
		
			
			$insert = $this->agentmodel->insertfield($data);
			$data2 = array(
				'ID'=>$insert,
				'AcctNo'=>$acctno,
				'BANK'=>$bank,
				'PLACE'=>$bank,
				'CHCode'=>$barcode,
				'CHName'=>$chname,
				'AGENT'=>$agent_code,
				'PRIMARYAdd'=>$fadd,
				'SECONDARYAdd'=>$sadd,
				'DateReq'=>date("Y-m-d H:i:s"),
				'DLType'=>$dltype,
				'FieldType'=>$field,
				'LocCode'=>$LocCode,
				'AddType'=>$type,
				'Barcode'=>"*$barcode*",
				'AgentName'=>$this->session->userdata('username'),
				'Fliers'=>$fliers,
				'dDate'=>date("Y-m-d H:i:s"),
				'Product'=>$prod,
				'FliersDate'=>$fldate,
			);
			$insert2 = $this->agentmodel->insertdl($data2);
				
			
			if($insert){
				$response['status'] = TRUE;
				$response['message'] = 'Successfully Submited';
			}
			
			//print_r($data);
		}else
		{
			$response['status'] = FALSE;
			$response['message'] = 'This barcode does not exists on your list.';
		}
		
		echo json_encode($response);
		exit;
	}
	
	function flist(){
		$bank = $this->input->get('bnk');
		$code = $this->session->userdata('code');
		
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
				$where .= " WHERE AgentCode = '".$code."' ";
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
					$sql  = $this->agentmodel->list_data('tblFieldRequest',$where);
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
				
				
				  $query = $this->agentmodel->user_sort_limit('tblFieldRequest',$where, $sort,$limit);
				  if($query){
							if($query->num_rows() > 0){
									foreach($query->result() as $dis){
									$rows[] = array (
									"id" => $dis->ID,
									"cell" => array(
									'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
									,$dis->ID
									,$dis->CHCode
									,$dis->Bank
									,$dis->DLType
									,$dis->DLReq
									,$dis->dDate
									)
									);
									}
							}
					}
		
				$data['rows'] = $rows;
				$data['params'] = $_POST;
				echo json_encode($data); 	
	}
	
	//Array( [page] => 1 [rp] => 15 [sortname] => id [sortorder] => asc [query] => jett||BPI||Confirmed [qtype] => CHCode)
	function statusflex()
	{
		//print_r($_POST);
		
				$rows = array();
				$code = $this->session->userdata('code');
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
				$query = explode("||",$query);
				if($query[0] == 'jett'){
					$where = "";
					$where .= " WHERE AgentCode = '".$code."' and Bank = '".$query[1]."' and `Status` = '".$query[2]."'";
					
					$sql  = $this->agentmodel->list_data('tblStatus',$where);
					$resultarray = array();
					if($sql){
							if($sql->num_rows() > 0){
								foreach($sql->result() as $ro){
									$resultarray[] = $ro;
								}	
							}
					}
				}else
				{
					$query = addslashes($this->input->post('query'));
					$qtype = $this->input->post('qtype');
					$where = "";
					$where .= " WHERE AgentCode = '".$code."'";
					if ($query) {
					$qtype = explode('||', $qtype);
					$flag = 0;
					
					foreach ($qtype as $value) {
							if ($flag == 1) {
								$where .= " OR $value LIKE '%$query%' ";
							} else {
									$where .= " AND $value LIKE '%$query%' ";
									$flag = 1;
							}
						}
					}
					
					$sql  = $this->agentmodel->list_data('tblStatus',$where);
					$resultarray = array();
					if($sql){
							if($sql->num_rows() > 0){
								foreach($sql->result() as $ro){
									$resultarray[] = $ro;
								}	
							}
					}
				}
					
				$total = count($resultarray);
				$data['page'] = $page;
				$data['total'] = $total; 
				
				
				  $query = $this->agentmodel->user_sort_limit('tblStatus',$where, $sort,$limit);
				  if($query){
							if($query->num_rows() > 0){
									foreach($query->result() as $dis){
									$rows[] = array (
									"id" => $dis->ID,
									"cell" => array(
									'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
									,'<input class="select_checkbox" id="check_slt" name="checkboxname" type="radio" value="'.$dis->ID.'" />'
									,$dis->ChCode
									,$dis->CHName
									,$dis->AcctNo
									,$dis->Status
									,$dis->SubStatus
									,$dis->Amt
									,$dis->dDatePTP
									)
									);
									}
							}
					}
		
				$data['rows'] = $rows;
				$data['params'] = $_POST;
				echo json_encode($data); 	
	}
	
	function checkstatus()
	{
		$id = $this->input->post('id');
		$response = array();
		$where = "WHERE ID = '".$id."'";
		$q = $this->agentmodel->list_data('tblStatus',$where);
		$q = $q->row();
		$response['status'] = $q->Status;
		$response['chcode'] = $q->ChCode;
		$response['amt'] = $q->Amt;
		$response['ptp'] = $q->dDatePTP;
		$response['place'] = $q->AddStatus;
		
		echo json_encode($response);
	}
	
	function updatestatus()
	{
		foreach($this->input->post() as $key => $value)
		{$$key = $value; }
		
		if($ptpdate != '')
		{
			$ptpdate = date("Y-m-d",strtotime($ptpdate));
		}else
		{
			$ptpdate = "";
		}
		
		if(!isset($radio_checked))
		{
			$radio_checked = NULL;
		}
		
		$table = '';
		$response = array();
		switch($bank)
		{
				case "BPI":
					$table = 'tblBPI';
				break;
				case "HSBG":
					$table = 'tblHSBCM';
				break;
				case "HSBM":
					$table = 'tblHSBCM';
				break;
				case "PIF":
					$table = 'tblHDMF';
				break;
				case "EWB":
					$table = 'tblEWB';
				break;
				case "EWB7":
					$table = 'tblEWBC7';
				break;
				case "MCC":
					$table = 'tblMCC';
				break;
				case "UBP":
					$table = 'tblUBP';
				break;
				case 'PSB':
					$table = 'tblPSB';
				break;
		}
		
		if($data = $this->agentmodel->checkbar($table,$barcode,$this->session->userdata('code'))){
			$status_table = "tblStatus";
		switch($bank)
		{
				case "BPI":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->AcctNo,
							'CHName'=>$data->CHName,
							'Amt'=>$amount,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						
						if($this->agentmodel->updatestatus($ins,$status_table,$lead_id))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->CHName;
							$response['acctno'] = $data->AcctNo;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "HSBG":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->accountnumber,
							'CHName'=>$data->NAME,
							'Amt'=>$amount,
							//'dDate'=>$data->STATE_ENTRY_DATE,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->updatestatus($ins,$status_table,$lead_id))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->NAME;
							$response['acctno'] = $data->accountnumber;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "HSBM":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->accountnumber,
							'CHName'=>$data->NAME,
							'Amt'=>$amount,
							//'dDate'=>$data->STATE_ENTRY_DATE,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->updatestatus($ins,$status_table,$lead_id))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->NAME;
							$response['acctno'] = $data->accountnumber;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "PIF":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->AGENT,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->HLIDNO,
							'CHName'=>$data->NAME,
							'Amt'=>$amount,
							//'dDate'=>$data->fDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->updatestatus($ins,$status_table,$lead_id))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->NAME;
							$response['acctno'] = $data->HLIDNO;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "EWB":
					$ins = array(
							'ChCode'=>$data->CHCODE,
							'AgentCode'=>$data->AGENT,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->ACCTNO,
							'CHName'=>$data->FULLNAME,
							'Amt'=>$amount,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->updatestatus($ins,$status_table,$lead_id))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCODE;
							$response['chname'] = $data->FULLNAME;
							$response['acctno'] = $data->ACCTNO;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "EWB7":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->AGENT,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->ACCOUNT_NUMBER,
							'CHName'=>$data->FULLNAME,
							'Amt'=>$amount,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->updatestatus($ins,$status_table,$lead_id))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->FULLNAME;
							$response['acctno'] = $data->ACCOUNT_NUMBER;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "MCC":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->CARDNUMBER,
							'CHName'=>$data->NAME,
							'Amt'=>$amount,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->updatestatus($ins,$status_table,$lead_id))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->NAME;
							$response['acctno'] = $data->CARDNUMBER;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case "UBP":
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->CARD_NUMBER,
							'CHName'=>$data->CARD_NAME,
							'Amt'=>$amount,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->updatestatus($ins,$status_table,$lead_id))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->CARD_NAME;
							$response['acctno'] = $data->CARD_NUMBER;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
				case 'PSB':
					$ins = array(
							'ChCode'=>$data->CHCode,
							'AgentCode'=>$data->Agent,
							'Bank'=>$bank,
							'Status'=>$status,
							'SubStatus'=>$radio_checked,
							'AcctNo'=>$data->AccountNo,
							'CHName'=>$data->AccountName,
							//'dDate'=>$data->dDate,
							'dDate'=>date("Y-m-d H:i:s"),
							'AddStatus'=>$places,
							'dDatePTP'=>$ptpdate,
						);
						if($this->agentmodel->updatestatus($ins,$status_table,$lead_id))
						{
							$response['success'] = TRUE;
							$response['chcode'] = $data->CHCode;
							$response['chname'] = $data->AccountName;
							$response['acctno'] = $data->AccountNo;
							$response['status'] = $status;
							$response['radio'] = $radio_checked;
							$response['amount']=$amount;
							$response['date'] = date("Y-m-d",strtotime($ptpdate));
						}
				break;
		}



		}
		else
		{
			$response['success'] = FALSE;
			$response['message'] = 'Invalid barcode or agent code.';
		}
		echo json_encode($response);
	}
	
}