<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*this controller is for display leads*/
class Leads extends CI_Controller {
	/*check user access*/
	function __construct()
	{
		parent::__construct();
		$this->globals->is_admin($this->session->userdata('logged'),$this->session->userdata('user_id'),$this->session->userdata('role'));	
	}
	
	
	/* diplay leads page*/
	function index()
	{
		$data['css'] =  $this->globals->css();
		$data['javascript'] = $this->globals->javascript();
		
		$data['title'] = 'SP Madrid - Leads';
		$this->load->view('header',$data);	
			$this->load->view('leads',$data);
		$this->load->view('footer');	
	}
	
	/*return bank list return JSON*/
	function bpi()
	{
		
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
			$sql  = $this->bpi->list_data($where);
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
		
		
		  $query = $this->bpi->user_sort_limit($where, $sort,$limit);
		  if($query){
					if($query->num_rows() > 0){
							foreach($query->result() as $dis){
							$rows[] = array (
							"id" => $dis->ID,
							"cell" => array(
							'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
							,$dis->ID
							,$dis->CHCode
							,$dis->Agent
							,$dis->CHName
							,$dis->Placement
							,$dis->OBCUTOFF
							)
							);
							}
					}
			}

		$data['rows'] = $rows;
		$data['params'] = $_POST;
		echo json_encode($data); 
	}
	/*return bank list return JSON*/
	function ewb()
	{
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
			$sql  = $this->ewb->list_data($where);
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
		
		
		  $query = $this->ewb->user_sort_limit($where, $sort,$limit);
		  if($query){
					if($query->num_rows() > 0){
							foreach($query->result() as $dis){
							$rows[] = array (
							"id" => $dis->ID,
							"cell" => array(
							'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
							,$dis->ID
							,$dis->CHCODE
							,$dis->AGENT
							,$dis->FULLNAME
						
							)
							);
							}
					}
			}

		$data['rows'] = $rows;
		$data['params'] = $_POST;
		echo json_encode($data); 
	}
	/*return bank list return JSON*/
	function fp()
	{
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
			$sql  = $this->fp->list_data($where);
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
		
		
		  $query = $this->fp->user_sort_limit($where, $sort,$limit);
		  if($query){
					if($query->num_rows() > 0){
							foreach($query->result() as $dis){
							$rows[] = array (
							"id" => $dis->ID,
							"cell" => array(
							'<input class="select_checkbox" id="check_slt" name="checkboxname" type="checkbox" value="'.$dis->ID.'" />'
							,$dis->ID
							,$dis->CHCode
							,$dis->AgentNego
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
	}
	
	/*return bank list return JSON*/
	function adminleads()
	{
		ini_set('memory_limit', '-1');
		$bank = $this->input->get('bank');
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
				if ($query) {
					$qtype = explode('||', $qtype);
					$flag = 0;
					
					foreach ($qtype as $value) {
							if ($flag == 1) {
								$where .= " OR $value LIKE '%$query%' ";
							} else {
									$where .= " WHERE $value LIKE '%$query%' ";
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
									,$dis->Agent
									,$dis->AccountName
									,$this->curStatus($dis->CHCode)
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
				//$where .= " LEFT JOIN tblStatus ON (tblStatus.ChCode = ".$tbl['bpi'].".CHCode)";
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
									,$dis->Agent
									,$dis->CHName
									//,''
									,$this->curStatus($dis->CHCode)
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
									,$dis->Agent
									,$dis->NAME
									,$this->curStatus($dis->CHCode)
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
				//$where .= " WHERE Agent = '".$code."' ";
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
									,$dis->Agent
									,$dis->NAME
									,$this->curStatus($dis->CHCode)
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
				//$where .= " WHERE Agent = '".$code."' ";
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
									,$dis->AGENT
									,$dis->NAME
									,$this->curStatus($dis->CHCode)
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
				//$where .= " WHERE Agent = '".$code."' ";
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
									,$dis->AGENT
									,$dis->FULLNAME
									,$this->curStatus($dis->CHCODE)
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
				//$where .= " WHERE Agent = '".$code."' ";
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
									,$dis->AGENT
									,$dis->FULLNAME
									,$this->curStatus($dis->CHCODE)
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
				//$where .= " WHERE Agent = '".$code."' ";
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
									,$dis->Agent
									,$dis->NAME
									,$this->curStatus($dis->CHCode)
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
				//$where .= " WHERE Agent = '".$code."' ";
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
									,$dis->Agent
									,$dis->CARD_NAME
									,$this->curStatus($dis->CHCode)
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
	
	function curStatus($code)
	{
		$q = $this->status->status_search($code);
		return $q;
	}
}